<?php

/* Copyright 2008 Timothy White */

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

class ErrorHandling
{
    // ErrorHandling::fatal_error
    public function fatal_error($error)
    {
        $AdminLog =& AdminLog::getInstance();
        $AdminLog->log_error($error);
        
        global $NONINTERACTIVE_SCRIPT;
        if(isset($NONINTERACTIVE_SCRIPT) && $NONINTERACTIVE_SCRIPT)
        {
            // Non-interactive script running, return error message as comments
            echo "#error_occured\n";
            echo "# An error has occured in the application\n";
            echo "# ::$error::\n";
            echo "# Memory used: ".memory_get_usage()."\n";
            die();
        
        }        
        
        if(file_exists('/usr/share/php/smarty/libs/') && ! is_link('/usr/share/php/smarty/libs/'))
        {
            // Debian bug http://bugs.debian.org/cgi-bin/bugreport.cgi?bug=514305
            // Remove this code once fixed?
            require_once('smarty/libs/Smarty.class.php');
        }else
        {
            require_once('smarty/Smarty.class.php');
        }
                //require_once 'libs/Smarty.class.php';

        $smarty = new Smarty;

        $smarty->compile_check = true;
        smartyerrorblockt();
        $smarty->register_block('t', 'smarty_block_t'); // Needed even though message will be in English
        $smarty->assign("Application", APPLICATION_NAME);
        $smarty->assign("error", $error);
        
        $smarty->display("error.tpl");
        die();

    }
    
    // ErrorHandling::fatal_db_error
    public function fatal_db_error($error, $pear_error_obj)
    {
        $AdminLog =& AdminLog::getInstance();
        $AdminLog->log_error($error . $pear_error_obj->toString());
        
        global $NONINTERACTIVE_SCRIPT;
        if(isset($NONINTERACTIVE_SCRIPT) && $NONINTERACTIVE_SCRIPT)
        {
            // Non-interactive script running, return error message as comments
            echo "#error_occured\n";
            echo "# An error has occured in the application\n";
            echo "# More information may be available in the server logs\n";
            echo "# ::$error::\n";
	    echo "#\n# ". $pear_error_obj->toString() . "\n"; // TODO: Do we really want to allow these error messages to be available without needing to access server logs?
            echo "# Memory used: ".memory_get_usage()."\n";
            die();
        
        }        
        
        if(file_exists('/usr/share/php/smarty/libs/') && ! is_link('/usr/share/php/smarty/libs/'))
        {
            // Debian bug http://bugs.debian.org/cgi-bin/bugreport.cgi?bug=514305
            // Remove this code once fixed?
            require_once('smarty/libs/Smarty.class.php');
        }else
        {
            require_once('smarty/Smarty.class.php');
        }
        //require_once 'libs/Smarty.class.php';

        $smarty = new Smarty;

        $smarty->compile_check = true;
        smartyerrorblockt();
        $smarty->register_block('t', 'smarty_block_t'); // Needed even though message will be in English
        $smarty->assign("Application", APPLICATION_NAME);
        $smarty->assign("error", $error . $pear_error_obj->getMessage());
        
        $smarty->display("error.tpl");
        //var_dump($pear_error_obj);
        die();

    }    
    
    
    // ErrorHandling::fatal_nodb_error
    public function fatal_nodb_error($error)
    {
        global $NONINTERACTIVE_SCRIPT;
        if(isset($NONINTERACTIVE_SCRIPT) && $NONINTERACTIVE_SCRIPT)
        {
            // Non-interactive script running, return error message as comments
            echo "#error_occured\n";
            echo "# An error has occured in the application\n";
            echo "# ::$error::\n";
            echo "# Memory used: ".memory_get_usage()."\n";
            die();
        
        }
        //$AdminLog =& AdminLog::getInstance();
        //$AdminLog->log_error($error);
        if(file_exists('/usr/share/php/smarty/libs/') && ! is_link('/usr/share/php/smarty/libs/'))
        {
            // Debian bug http://bugs.debian.org/cgi-bin/bugreport.cgi?bug=514305
            // Remove this code once fixed?
            require_once('smarty/libs/Smarty.class.php');
        }else
        {
            require_once('smarty/Smarty.class.php');
        }


//        require_once 'libs/Smarty.class.php';

        $smarty = new Smarty;

        $smarty->compile_check = true;
        smartyerrorblockt();
        $smarty->register_block('t', 'smarty_block_t'); // Needed even though message will be in English
        $smarty->assign("Application", APPLICATION_NAME);
        $smarty->assign("error", $error);
        $smarty->assign("memory_used", memory_get_usage());
        
        $smarty->display("error.tpl");
        die();

    }    

}

function smartyerrorblockt()
{
            if(!function_exists('smarty_block_t'))
            {
                function smarty_block_t($params, $text, &$smarty)
                {
                    return "$text";
                }
            }
}

?>
