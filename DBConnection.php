<?php
if(!is_dir('./db'))
    mkdir('./db');
if(!defined('db_file')) define('db_file','./db/covid_counterdb.db');
function my_udf_md5($string) {
    return md5($string);
}

Class DBConnection extends SQLite3{
    protected $db;
    function __construct(){
         $this->open(db_file);
         $this->createFunction('md5', 'my_udf_md5');
         $this->exec("PRAGMA foreign_keys = ON;");
         $this->exec("CREATE TABLE IF NOT EXISTS `user_list` (
            `user_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `fullname` INTEGER NOT NULL,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `type` INTEGER NOT NULL,
            `status` INTEGER NOT NULL Default 1,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"); 

$this->exec("CREATE TABLE IF NOT EXISTS  employee_list (
            `employee_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `employee_code` TEXT NOT NULL,
            `firstname` TEXT NOT NULL,
            `middlename` TEXT NULL,
            `lastname` TEXT NOT NULL,
            `gender` TEXT NOT NULL,
            `contact` TEXT NOT NULL,
            `email` TEXT NOT NULL,
            `status` INTEGER NOT NULL DEFAULT 1,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `date_updated` TIMESTAMP NULL
        )");

$this->exec("CREATE TABLE IF NOT EXISTS  sensorlog(
            'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            'sensor_door'	VARCHAR(30),
            'current_people'	VARCHAR(30),
            'reading_time'	TIMESTAMP NOT NULL,
            'occupancy_limit_id'	TEXT NOT NULL
        )");

        
$this->exec("CREATE TABLE IF NOT EXISTS  occupancy_limit (
            'occupancy_id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        'current_limit'	INTEGER NOT NULL,
            'date_created'	TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

       
}
    function __destruct(){
         $this->close();
    }


}


$conn = new DBConnection();
