<?php

$string = '� ������ ������� �� ���. � ��� � ���� ���. � �� ������ ��� �� ��������, ��� � ��������� �� ��������. � ������-�� � �����. � ������ ������ ����������. � ��� ���� ����� �� �����.'; 

function neWString ($a) {
 echo $a . "<br><br>";
 $b = explode(". ", $a);
 $val = ".";
 for ($i = 0; $i < count($b)-1; $i++){
  $b[$i] = $b[$i].$val;
 }
 rsort($b);
 $new_str = implode(" ", $b);
 echo $new_str;
}

neWString($string)
?>