<?php

/* Copyright 2010 Timothy White */

/*  This file is part of GRASE Hotspot.

    http://hotspot.purewhite.id.au/

    GRASE Hotspot is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    GRASE Hotspot is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GRASE Hotspot.  If not, see <http://www.gnu.org/licenses/>.
*/
$NONINTERACTIVE_SCRIPT = true;

require_once('includes/constants.inc.php');
require_once('includes/misc_functions.inc.php');

function __autoload($class_name) {
    require_once './classes/' . $class_name . '.class.php';
}

// Special case for stale sessions, don't log it
/*if(isset($_GET['clearstalesessions']))
{
    CronFunctions::getInstance()->clearStaleSessions();
    exit;
}*/

AdminLog::getInstance()->log_cron("CRON");

//$Settings = new SettingsMySQL(DatabaseConnections::getInstance()->getRadminDB());
//$dbversion = $Settings->getSetting("DBVersion");

$upgradedb = CronFunctions::getInstance()->upgradeDB();
if($upgradedb) echo "$upgradedb\n";

$stalesessions = CronFunctions::getInstance()->clearStaleSessions();
if($stalesessions) echo "$stalesessions\n";

$expiredusers = CronFunctions::getInstance()->deleteExpiredUsers();
if($expiredusers) echo "$expiredusers\n";

$prevmonths = CronFunctions::getInstance()->condensePreviousMonthsAccounting();
if($prevmonths) echo "$prevmonths\n";

$oldpostdata = CronFunctions::getInstance()->clearOldPostAuth();
if($oldpostdata) echo "$oldpostdata\n";

$postauthmacreject = CronFunctions::getInstance()->clearPostAuthMacRejects();
if($postauthmacreject) echo "$postauthmacreject\n";



if(@ $_GET['deleteoutoftimeusers'])
{
    $outoftime = CronFunctions::getInstance()->deleteOutOfTimeUsers();
    if($outoftime) echo "$outoftime\n";
}

if(@ $_GET['deleteoutofdatausers'])
{
    $outofdata = CronFunctions::getInstance()->deleteOutOfDataUsers();
    if($outofdata) echo "$outofdata\n";
}

$oldbatches = CronFunctions::getInstance()->clearOldBatches();
if($oldbatches) echo "$oldbatches\n";

?>
