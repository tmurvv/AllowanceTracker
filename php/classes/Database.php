<?php
    //include settings from config file.
    $config = require 'php/config/config.php';

    //set variables from config file array
    $driver = $config['database']['driver'];
    $host = $config['database']['host'];
    $dbname = $config['database']['dbname'];
    $db_username = $config['database']['username'];
    $db_password = $config['database']['password'];
    $dsn = "{$driver}:host={$host}; dbname={$dbname}";

    //connect to the database
    try {
        $db = new PDO($dsn,$db_username,$db_password);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected to piggyb database";
    } catch (PDOException $ex){
        echo "Connection failed ".$ex->getMessage();
    }
?>