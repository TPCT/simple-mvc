<?php
namespace migrations;

use core\Application;

class m0002_add_users{
    private const users = [
        "admin_1" => [
            "username" => "sameh",
            "password" => "admin1234",
        ]
    ];

    public function up(){
        $connector = Application::APP()->database->connector();
        $query = "INSERT INTO users(username, password) VALUES (:username, :password)";
        foreach($this::users as $user){
            $stmt = $connector->prepare($query);
            $password = \password_hash($user['password'], \PASSWORD_DEFAULT);
            $stmt->bindParam(":username", $user['username']);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
        }
    }

    public function down(){
        $connector = Application::APP()->database->connector();
        $query = "DELETE FROM users WHERE username=:username";
        foreach($this::users as $user){
            $stmt = $connector->prepare($query);
            $stmt->bindValue(":username", $user['username']);
            $stmt->execute();
        }
    }
}