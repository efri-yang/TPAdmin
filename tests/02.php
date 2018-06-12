<?php
class Person {
    private $_data = array();
    public function __get($property) {
        echo "__get";

    }

    public function __set($property, $value) {
        echo "_set";
        $this->_data[$property] = $value;
    }
}

$p1 = new Person();
$p1->age = 30;

$p1->age;

?>