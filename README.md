
![Wake on lan or wan](https://cloud.githubusercontent.com/assets/8479569/5924422/05d8c172-a675-11e4-82b5-b6bafe9b5bf1.jpg "Wake on Lan or Wan")

# Wake on Wan (or Lan)
### shortly WoW

I use this script to wake up my home servers remotely from internet. I say servers but it can be used for anything really - desktop computers / laptops.

I usually have a subdomain for each of my server like: wol.servername.host.com which hosts the script. Everytime I hit the hostname my server wakes up.

Obviously you shouldn't host this script on the computer you plan to wake up ;) just checking if you are paying attention.

##### important notes
1. Target computer should have motherboard that supports wake on lan (magic packets). And it should be enabled, both in BIOS and OS. For ubuntu this is an excellent doc: https://help.ubuntu.com/community/WakeOnLan
2. Don't forget to open correct ports, sending machine, target machine and on router.

##### instructions
1. Upload index.php and wow.class.php onto your sending server. You can use any shared hosting provider, but note that most of them will not open ports below 1000 for you. So choose something 1000 like 1007 for example.
2. Edit index.php - line 5 `$WoW = new WoW("wow.example.com","xx:xx:xx:xx:xx:xx","xxxx");`
    1. WoW accepts a. hostname, b. mac address, c. port number. and optional d. ip address. If d is not provided script automatically gets ip from hostname.
3. Lets use port 1007 as an example.
4. Open outgoing port 1007 on sending server.
5. On target machines network router:
    1. Add following forwarder: UDP, from 1007 to 7, ip 192.168.1.254
       1. 192.168.1.254 this IP shouldn't belong to any device. It is a free IP address we will use for an ARP entry later
       2. 1007 is the outoing port we opened on sending machine.
       3. 7 is the port my motherboard uses for wake on lan packages. Check manual for yours!
    2. We will need to add ARP entry in the router: `arp -i br0 -s 192.168.1.254 FF:FF:FF:FF:FF:FF`

So in nutshell it works like this:
1. Script sends magic packet to target computers router
2. Router forwards port from 1007 to 7 and to IP address 192.168.1.254
3. 192.168.1.254 has ARP entry FF:FF:FF:FF:FF:FF which means broadcast to network
4. Message is broadcasted in the network on port 7.
5. Sleeping/Powered off computer has NIC still powered on, and receives wake on lan message on port 7.
6. System wakes up.

#Enjoy!
