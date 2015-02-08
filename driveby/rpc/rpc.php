<?php

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

/*
 *
 * This file is used to pass command line commands into a remote system.
 * The commands should be sent as if they were being typed on this local machine.
 *
 * (SECURITY ISSUES!)
 *
 * I dont recommend allowing any of these systems open access to the internet!
 * At the very least you should limit what IP's have access to port 80!
 *
 * At this point I don't have time to think of every possible risk to this system
 * because I run it on a private network that has no external access.  If you intend
 * to use this 'in the wild' then BEWARE - nuff said.
 *
 */

$cmd = rawurldecode($_REQUEST['q']);
passthru($cmd);
sleep(1);
echo "$cmd\n";