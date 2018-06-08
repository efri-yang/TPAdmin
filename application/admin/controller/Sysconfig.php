<?php
namespace app\admin\controller;

class Sysconfig extends Base {
    public function index() {
        return $this->fetch("index");
    }
}
?>