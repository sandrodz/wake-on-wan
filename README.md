# Wake on Wan
# shortly WoW

I use this script to wake up my home servers remotely from internet. I say servers but it can be used for anything really - desktop computers / laptops.

Obviously you shouldn't host this file on the computer you plan to wake up ;) just checking if you are paying attention.

##### important notes
1. Target computer should have motherboard which supports wake on lan (magic packets). And it should be enabled, both in BIOS and OS. For ubuntu this is an excellent doc: https://help.ubuntu.com/community/WakeOnLan
2. Don't forget to open correct ports, sending machine, target machine and on router.

##### instructions
1. Upload index.php and wow.class.php onto your sending server. You can use any shared hosting provider, but note that they will not open any ports between 1-1000 for you.
2. Edit index.php - line 5 `$WoW = new WoW("wow.example.com","xx:xx:xx:xx:xx:xx","xxxx");`
    1. WoW accepts a. hostname, b. mac address, c. port number. and optional d. ip address. If d is not provided script automatically gets ip from hostname. Everything else except 4th parameter is required.
3. Lets use port 1007 as an example.
4. Open outgoing port 1007 on sending server
5. On target machine network router, add following forwarder: UDP, from 1007 to 7, ip 192.168.1.254, note this is not your target server IP! also note, 7 target port varies among different motherboards, so check the manuall!
6. We will need to edit ARP entry in the router: `arp -i br0 -s 192.168.1.254 FF:FF:FF:FF:FF:FF`

Now test your script, hit with your browser and check if server comes online.
