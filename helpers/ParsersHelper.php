<?php
namespace helpers;

class ParsersHelper{
    public static function subscription($subscription){
        foreach($subscription as $key => $value){
            if ($key == 'start_date' || $key == 'end_date')
                $subscription = date("Y-m-d", strtotime($value));
        }
        return $subscription;
    }
}