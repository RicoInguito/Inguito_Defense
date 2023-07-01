<?php

interface DbConnection
{
    public function createTable();
    public function getAll();
    public function create($params);
    public function getid($id);
    public function update($params);
    public function delete($params);
    public function search($params);
}

?>