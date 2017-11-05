<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 05.11.2017
 * Time: 15:00
 */

class saleCalculation {

    const SALE_KOEF_2 = 0.98;
    const SALE_KOEF_3 = 0.97;
    const SALE_KOEF_4 = 0.96;
    const SALE_KOEF_5 = 0.95;
    const FIRST_PRICE = 345;
    public static $old_purchases = 134;

    public static function getOldPurchases(){
        return self::$old_purchases;
    }

    public static function getFirstPrice(){
        return self::FIRST_PRICE;
    }

    public static function calc_sale () {
        if (self::getOldPurchases() < 0) {
            echo "Введите правильное число покупок, сделаных ранее";
        } elseif (self::getOldPurchases() > 0 && self::getOldPurchases() < 30) {
            $your_price = self::getFirstPrice() * self::SALE_KOEF_2;
        } elseif (self::getOldPurchases() > 30 && self::getOldPurchases() < 70){
            $your_price = self::FIRST_PRICE * self::SALE_KOEF_3;
        } elseif (self::getOldPurchases() > 70 && self::getOldPurchases() < 130){
            $your_price = self::FIRST_PRICE * self::SALE_KOEF_4;
        } elseif (self::getOldPurchases() > 130){
            $your_price = self::FIRST_PRICE * self::SALE_KOEF_5;
        } elseif (self::getOldPurchases() == 0){
            $your_price = self::FIRST_PRICE;
        }
        return $your_price;
        }

}