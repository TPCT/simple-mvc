<?php
namespace migrations;

use core\Application;

class m0003_add_prices{
    private const prices = [
        "Month" => 240,
        "3 Months" => 650,
        "6 Months" => 1200,
        "12 Months" => 2200
    ];

    public function up(){
        $connector = Application::APP()->database->connector();
        $query = "INSERT INTO prices(name, value) VALUES (:name, :value)";
        foreach($this::prices as $name => $value){
            $stmt = $connector->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":value", $value);
            $stmt->execute();
        }
    }

    public function down(){
        $connector = Application::APP()->database->connector();
        $query = "DELETE FROM prices WHERE name=:name";
        foreach($this::prices as $name => $value){
            $stmt = $connector->prepare($query);
            $stmt->bindValue(":name", $name);
            $stmt->execute();
        }
    }
}