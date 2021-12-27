<?php
namespace helpers;

use core\Application;

class SubscriptionsHelper{
    public static function end_date($start_date, $package){
        $start_date = strtotime($start_date);
        switch($package){
            case "Month": return strtotime("+1 month", $start_date);
            case "3 Months": return strtotime("+3 months", $start_date);
            case "6 Months": return strtotime("+6 months", $start_date);
            case "12 Months": return strtotime("+1 year", $start_date);
            default: return Null;
        };
    }

    public static function getAll(){
        $connector = Application::APP()->database->connector();
        $start_date = date("Y-m-d", strtotime("first day of this month"));
        $end_date = date("Y-m-d", strtotime("last day of this month"));
        $query = "SELECT subscriptions.*, DATE(subscriptions.start_date) AS start_date, DATE(subscriptions.end_date) AS end_date, customers.name, customers.country FROM (subscriptions INNER JOIN customers ON subscriptions.customer_id = customers.id) WHERE subscriptions.start_date >= :start_date AND subscriptions.start_date <= :end_date";
        $stmt = $connector->prepare($query);
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":end_date", $end_date);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

