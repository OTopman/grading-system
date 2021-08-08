<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 1:18 PM
 */

    session_start();
    require_once 'func.php';
    define('Env', 'online');

    define("DB_PREFIX", "ht_");

    define("LIB_DIR","http://projects.io/app/creche/");
    define("HOME_DIR","http://projects.io/web/projects/grading-system/");
    define("HTML_TEMPLATE",LIB_DIR.'templates/');

    define("USER_SESSION_HOLDER", "admin");
    define("WEB_TITLE","Project Defense Grading System");
    define("WEB_SUB_TITLE","HA");

    if (Env == "online") {
        define('DB_HOST', 'localhost');
        define('DB_TABLE', 'verajnse_grading_system');
        define('DB_USER', 'verajnse_grading_system');
        define('DB_PASSWORD', 'MXUDb}7;&Q+f');
    }else{
        define('DB_HOST', 'localhost');
        define('DB_TABLE', 'fpe_app_grading');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
    }

    try {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_TABLE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    catch (PDOException $e){
        die('<br/><center><font size="15">Could not connect with database</font></center>');
    }