<?php

	/**
	* This class deals with wake on wan
	*/
	class WoW
	{

		private $hostname;    // hostname (domain) of the target machine or the router that talks to listening computer
		private $mac;         // mac address of the target machine
		private $port;        // open port on router mapped to target machine wol port
							  // note that same outgoing port should be open on sending server!
		private $ip;          // ip address of target machine

		private $msg = array(
			0 => "Target machine seems to be Online.",
			1 => "socket_create function failed for some reason",
			2 => "socket_set_option function failed for some reason",
			3 => "magic packet sent successfully!",
			4 => "magic packet failed!"
		);
		
		function __construct($hostname,$mac,$port,$ip = false)
		{
			$this->hostname = $hostname;
			$this->mac      = $mac;
			$this->port     = $port;
			if (!$ip)
			{
				$this->ip   = $this->get_ip_from_hostname();
			}
		}

		public function wake_on_wan()
		{
			if ($this->is_awake())
			{
				return $this->msg[0]; // is awake, nothing to do
			}
			else
			{
				$addr_byte = explode(':', $this->mac);
				$hw_addr = '';
				for ($a=0; $a<6; $a++) $hw_addr .= chr(hexdec($addr_byte[$a]));
				$msg = chr(255).chr(255).chr(255).chr(255).chr(255).chr(255);
				for ($a=1; $a<=16; $a++) $msg .= $hw_addr;
				// send it to the broadcast address using UDP
				$s = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
				
				if ($s == false)
				{
					return $this->msg[1]; // socket_create failed
				}

				$set_opt = @socket_set_option($s, 1, 6, TRUE);

				if ($set_opt < 0)
				{
					return $this->msg[2]; // socket_set_option failed
				}

				$sendto = @socket_sendto($s, $msg, strlen($msg), 0, $this->ip, $this->port);
				
				if ($sendto)
				{
					socket_close($s);
					return $this->msg[3]; // magic packet sent successfully!
				}

				return $this->msg[4]; // magic packet failed!
				
			}
		}

		private function is_awake()
		{
			$awake = @fsockopen($this->ip, 80, $errno, $errstr, 2);
			
			if ($awake)
			{
				fclose($awake);
			}
			
			return $awake;
		}

		private function get_ip_from_hostname()
		{
			return gethostbyname($this->hostname);
		}

	}

?>