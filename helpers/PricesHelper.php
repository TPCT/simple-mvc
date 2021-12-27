<?php
namespace helpers;

use core\Application;
use PDO;

class PricesHelper{
    public static function getPrice($name){
        $connector = Application::APP()->database->connector();
        $query = "SELECT value FROM prices WHERE name=:name";
        $stmt = $connector->prepare($query);
        $stmt->bindValue(":name", $name);
        $stmt->execute();
        return (int)($stmt->fetch()['value'] ?? Null);
    }

    public static function get(){
        $connector = Application::APP()->database->connector();
        $query = "SELECT name FROM prices ORDER BY name";
        $stmt = $connector->prepare($query);
        $stmt->execute();
        return \array_reverse($stmt->fetchAll(PDO::FETCH_COLUMN) ?? []);
    }

    public static function getAll(){
        $connector = Application::APP()->database->connector();
        $query = "SELECT * FROM prices ORDER BY name";
        $stmt = $connector->prepare($query);
        $stmt->execute();
        return \array_reverse($stmt->fetchAll() ?? []);
    }
}