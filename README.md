# driveby
This wasn't really written for public use initially.  But since so many have asked how I was doing things like 
the online Heatmaps via Google Maps, I figured I'd post the code so others could at least browse through some
of it.  

I hope it's useful.

I'm willing to try to work on issues that occur when time permits at least for the near term. 

This stuff REALLY isn't production ready code.  

ONE THING YOU'LL FOR CERTAIN NEED TO DO is to EDIT: classes/config.php this is where I think most of the paths
and definitions of hardware used by the system are defined.

I use two systems in my setup that share a NFS drive.  One controls the RTL's and other controls things like 
the Web GUI and GPS, NFS, and things like that.

THIS IS NOT PLUG AND PLAY.  I can help you to a point, but I'm not your private IT team.  If you can't code in
PHP, HTML, Javascript that's on you - sorry.

------------

SOME BASIC HOWTO SETUP on your systems being used:

UBUNTU APACHE/PHP5:
   sudo apt-get install apache2 php5-cli libapache2-mod-php5 curl libcurl3 libcurl3-dev php5-curl

UBUNTU GPS:
   sudo apt-get install gpsd gpsd-clients python-gps

GPS:
   http://www.catb.org/gpsd/
   http://www.catb.org/gpsd/installation.html
   http://www.catb.org/gpsd/gpsd-time-service-howto.html
   http://www.lammertbies.nl/comm/info/GPS-time.html
   DRIVEBY GITHUB: classes/Client.Gps.class.inc
                   classes/Gps.class.inc

WHAT GPS TO USE: That's basically up to you as long as GPSD can work with it ok on your brand of Linux.
                 On my own system I used an inexpensive L10 GPS http://www.mikroe.com/click/gps-l10/
                 It syncs up very quickly, and has worked flawlessly and seems to get on average around 8 
                 to 10 sat's at one time using the antenna I use (see next below).

My GPS Antenna: http://ebay.com and search for "GPS-TMG-26N GPS 26dB Gain Antenna" it's a little pricey about 2x the 
                the cost of the $35 GPS but you can find others on Ebay as well.  I have found the GPS-TMG-26N 
                I use to be EXCELLENT, even works great indoors.  Doesn't matter how good your GPS is, if it
                can't hear the Sat's it's worthless, so it makes sense to get a GOOD antenna if you can afford it.

USEFUL GPS DEBUG:
   dmesg | grep -i gps
   grep -i gps /var/log/syslog
   telnet localhost 2947 -or- telnet 127.0.0.1 2947 (if connects then gpsd is running)
   service gpsd [stop|start|restart|status]
   
RTL TOOLS:
   https://github.com/keenerd/rtl-sdr

NFS:

   https://help.ubuntu.com/community/SettingUpNFSHowTo

CRONTAB:

You may have to resolve permissions these entries have access to below.  That's on you to deal with.
The only really important on is the gps_sets_os_time.php if you don't have NTP working on the internet while ur
mobile.  This too isn't really a requirement IF you can make sure that when you are using multiple servers (as
in my case) that the clocks on your servers are all set to roughly the same time.  Within a 1-5 seconds is 
probably good enough.  These CRON entries keep the WEB GUI happy with current CPU tempurature, System Load and Time
otherwise.  They're not really a requirement for the system to pull GPS and RTL_POWER readings otherwise.

ON GPS HOSTING SERVER:

   (as non-root user)
   * * * * * /usr/bin/php /var/www/html/driveby/stat_temp_log.php > /dev/null 2>&1
   * * * * * /usr/bin/php /var/www/html/driveby/stat_sysload_log.php > /dev/null 2>&1

   (as ROOT user)
   * * * * * /usr/bin/php /var/www/html/driveby_new/gps_sets_os_time.php > /dev/null 2>&1

ON REMOTE SERVER:
   (as non-root user)
   * * * * * /usr/bin/php /var/www/html/driveby/stat_sysload_log.php > /dev/null 2>&1

   (as ROOT user)
   * * * * * /usr/bin/php /var/www/html/driveby/stat_temp_log.php > /dev/null 2>&1
