<?php
namespace migrations;

use core\Application;

class m0004_add_offers{
    private const offers = [
        "No offer" => 0
    ];

    public function up(){
        $connector = Application::APP()->database->connector();
        $query = "INSERT INTO offers(name, value) VALUES (:name, :value)";
        foreach($this::offers as $name => $value){
            $stmt = $connector->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":value", $value);
            $stmt->execute();
        }
    }

    public function down(){
        $connector = Application::APP()->database->connector();
        $query = "DELETE FROM offers WHERE name=:name";
        foreach($this::offers as $name => $value){
            $stmt = $connector->prepare($query);
            $stmt->bindValue(":name", $name);
            $stmt->execute();
        }
    }
}