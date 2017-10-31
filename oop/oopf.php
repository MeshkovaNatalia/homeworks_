<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 31.10.2017
 * Time: 21:31
 */

class Parent1
{
    public $name, $age;
    function __construct($age)
    {
        $this->age = $age;
    }

    function getInfo() {
        echo "Пользователю $this->name $this->age лет<br>";
    }

    function getClassInfo(){
        echo "Это родительский класс<br>";
    }

    function __destruct()
    {
        echo "_______!";
    }
}

class Child1 extends Parent1
{
    public $gender, $surname;
    function __construct($age)
    {
        parent::__construct($age, $gender = rand(0,1));
        $this->gender = $gender;
    }

    function getClassInfo(){
        echo "Это дочерний класс 1<br>";
    }

    function getInfo()
    {
        parent::getInfo();
        echo "Его фамилия: $this->surname, пол: $this->gender<br>";
    }
}

class Child2 extends Parent1
{
    const PAY_SUMM = 25;
    private $pay;

    function __construct()
    {
        parent::__construct($pay = self::PAY_SUMM);
        if (!empty($pay)) {
            $this->pay = $pay;
        }
    }
    function getClassInfo(){
        echo "Это дочерний класс 2";
    }

    function getInfo()
    {
        //parent::getInfo();
        echo "Должен заплатить $this->pay долларов";
    }

}

$user = new Child1(25);
$user->name = "Ivan";
$user->surname = "Ivanov";
//$user->getClassInfo();
$user->getInfo();
$payy = new Child2(34);
echo $payy->getInfo();
//print_r($user);