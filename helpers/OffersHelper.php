<?php
namespace helpers;

use core\Application;
use PDO;

class OffersHelper{
    public static function getOffer($name){
        $connector = Application::APP()->database->connector();
        $query = "SELECT value FROM offers WHERE name=:name";
        $stmt = $connector->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return (int)($stmt->fetch()['value'] ?? Null);
    }

    public static function get(){
        $connector = Application::APP()->database->connector();
        $query = "SELECT name FROM offers ORDER BY value";
        $stmt = $connector->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getAll(){
        $connector = Application::APP()->database->connector();
        $query = "SELECT * FROM offers ORDER BY value";
        $stmt = $connector->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}