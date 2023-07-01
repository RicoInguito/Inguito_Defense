<?php

abstract class Database
{
    abstract public function connection();
    abstract public function db_error();
}
?>