<?php

try{
    $conn = new mysqli("localhost", "root", "", "solar_system");
}catch(Exception $e){
    echo "Error: ".$e->getMessage();
}

function insert($table_name, $data)
{
    $columns = [];
    $values = [];
    foreach ($data as $col => $val) {
        $columns[] = "`$col`";
        $values[] = "'".addslashes($val)."'";
    }
    $columns = implode(", ", $columns);
    $values = implode(", ", $values);
    return "INSERT INTO $table_name($columns) VALUES($values);";
}

function select($table_name, $where = [], $params = [])
{
    $condition = [];
    $options = [];
    foreach ($params as $clause => $val) {
        $options[] = "$clause ".addslashes($val);
    }
    $options = implode(" ", $options);
    foreach ($where as $col => $val) {
        $condition[] = "`$col` = '".addslashes($val)."'";
    }

    if (!empty($where))
        $condition = "WHERE " . implode(" AND ", $condition);
    else
        $condition = "";
    return "SELECT * FROM $table_name $condition $options;";
}

function update(
    $table_name, 
    $d, 
    $where
){

    $data = [];
    $condition = [];
    foreach ($d as $col => $val) {
        $data[] = "`$col` = '".addslashes($val)."'";
    }
    foreach ($where as $col => $val) {
        $condition[] = "`$col` = '".addslashes($val)."'";
    }
    $data = implode(", ", $data);
    $condition = implode(" AND ", $condition);
    return "UPDATE $table_name SET $data WHERE $condition;";
}