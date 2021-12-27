<?php
namespace migrations;

use core\Application;

class m0001_initial{
    public function up(){
        $connector = Application::APP()->database->connector();
        $query = "
            CREATE TABLE IF NOT EXISTS `customers` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `name` varchar(127) NOT NULL,
                `country` varchar(127) DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`)
            )          
        ";

        $connector->exec($query);

        $query = "
            CREATE TABLE IF NOT EXISTS `prices` (
                `name` varchar(127) NOT NULL,
                `value` int(11) NOT NULL,
                PRIMARY KEY (`name`)
            )        
        ";

        $connector->exec($query);
        
        $query = "
            CREATE TABLE IF NOT EXISTS `offers` (
                `name` varchar(127) NOT NULL,
                `value` tinyint(4) NOT NULL,
                PRIMARY KEY (`name`)
            )
        ";

        $connector->exec($query);

        $query = "
            CREATE TABLE IF NOT EXISTS `users` (
                `username` varchar(127) NOT NULL,
                `password` varchar(127) NOT NULL
            )
        ";
        
        $connector->exec($query);

        $query = "
            CREATE TABLE IF NOT EXISTS `subscriptions` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `customer_id` bigint(11) NOT NULL,
                `type` varchar(127) NOT NULL,
                `offer` varchar(127) DEFAULT NULL,
                `start_date` datetime NOT NULL DEFAULT current_timestamp(),
                `end_date` datetime NOT NULL DEFAULT current_timestamp(),
                `cash` int(10) unsigned NOT NULL DEFAULT 0,
                `debit` int(10) unsigned NOT NULL DEFAULT 0,
                `comment` varchar(1024) DEFAULT NULL,
                `status` BOOLEAN DEFAULT 0,
                `transaction_by` varchar(127) DEFAULT NULL,
                PRIMARY KEY (`id`),
                --FOREIGN KEY(customer_id) REFERENCES customers(id),
                --FOREIGN KEY(type) REFERENCES prices(name),
                --FOREIGN KEY(offer) REFERENCES offers(name)
            )
    ";

    $connector->exec($query);
    }

    public function down(){
        $connector = Application::APP()->database->connector();
        $connector->exec("DROP TABLE customers");
        $connector->exec("DROP TABLE subscriptions");
        $connector->exec("DROP TABLE prices");
        $connector->exec("DROP TABLE offers");
        $connector->exec("DROP TABLE users");
    }
}