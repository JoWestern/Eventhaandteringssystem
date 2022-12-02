<?php
class Category{
    function selectCategory(){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $sql = "SELECT category_id, name FROM eventhandling.categories";

        $result = $conn->query($sql);
        return $result;

        $conn->close();
    }
}