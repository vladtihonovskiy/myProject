<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(dirname(__FILE__).'/../Constant.php');
/**
 * Created by PhpStorm.
 * User: rusla
 * Date: 28.08.2017
 * Time: 21:25
 */
class DbConnect
{
    public $userkey;
    public   $db;
    function DbConnect()
    {   $this->db=mysqli_connect(HOST, USERDB, PASSWORDDB);
// Check connection
        if (!$this->db) {
            die("Connection failed: " . mysqli_connect_error());
        }
// Create database
        $sql = "CREATE DATABASE IF NOT EXISTS ".DBNAME;
        if (mysqli_query($this->db , $sql)) {
        } else {
            echo "Error creating database: " . mysqli_error($this->db);
        }
        $db=mysqli_connect(HOST,USERDB,PASSWORDDB,DBNAME);
        $query = "CREATE TABLE IF NOT EXISTS Product_type (
          id int(11) AUTO_INCREMENT,
                          name varchar(255) NOT NULL,
                          PRIMARY KEY  (id)
        )";
        mysqli_query($db,$query);
        $query = "CREATE TABLE IF NOT EXISTS Category (
          id int(11) AUTO_INCREMENT,
                          name varchar(255) NOT NULL,
                          PRIMARY KEY  (id)
        )";
        mysqli_query($db,$query);
        $query = "CREATE TABLE IF NOT EXISTS Product (
          id int(11) AUTO_INCREMENT,
                          product_type_id int(11) NOT NULL,
                          category_id int(11) NOT NULL,
                          name varchar(255) NOT NULL,
                          description varchar(255) NOT NULL,
                          image varchar(255) NOT NULL,
                          PRIMARY KEY  (id)
        )";
        mysqli_query($db,$query);
    }
    // get array of product id
    function GetRequestbyid($setid)
    {
        $mysqli = new mysqli(HOST, USERDB, PASSWORDDB, DBNAME);
        $resultarray=array();

        $query="SELECT * FROM Product WHERE id='$setid'";
        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc()) {
                $resultarray[]=$row;
            }

            $result->free();
        }

        $mysqli->close();


        return  $resultarray;
    }
    // get array of Category or Product type name
    function GetCategoryname($nametable,$getname)
    {
        $mysqli = new mysqli(HOST, USERDB, PASSWORDDB, DBNAME);
        $resultarray=array();

        $query="SELECT name FROM $nametable WHERE id='$getname'";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $resultarray[]=$row;
            }
            $result->free();
        }
        $mysqli->close();

        return  $resultarray;
    }
    // get array Search from Product
    function Search($search_value)
    {   $mysqli = new mysqli(HOST, USERDB, PASSWORDDB, DBNAME);
        if ($mysqli->connect_errno) {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        $resultarray=array();
        $query="SELECT * FROM `Product` WHERE `name` LIKE '%$search_value%';";

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc()) {
                $resultarray[]=$row;
            }

            $result->free();
        }
        $mysqli->close();
        return  $resultarray;
    }
    // set new category of Product name
    function Setcategory($nametable,$getname)
    {
        $db=mysqli_connect(HOST,USERDB,PASSWORDDB,DBNAME);
        $query="INSERT INTO `$nametable` (`id`, `name`) VALUES (NULL,'$getname');";
        mysqli_query( $db,$query);
        return (mysqli_insert_id($db));
    }
    // update product value
    function Updatevalue($product_type_id,$category_id,$name,$description,$image,$id)
    {   $db=mysqli_connect(HOST,USERDB,PASSWORDDB,DBNAME);
        $query= "UPDATE  `Product` SET `product_type_id`='$product_type_id',`category_id`='$category_id',`name`='$name',`description`='$description',`image`='$image' WHERE `Product`.`id` = '$id'";
        mysqli_query( $db,$query);
    }
    // Set Product value
    function Setvalue($product_type_id,$category_id,$name,$description,$image)
    {   $db=mysqli_connect(HOST,USERDB,PASSWORDDB,DBNAME);
        $query="INSERT INTO `Product` (`id`, `product_type_id`, `category_id`, `name`, `description`, `image`) VALUES (NULL, '$product_type_id', '$category_id', '$name', '$description', '$image');";
        mysqli_query( $db,$query);
    }
    // Get table convert to array
    function getAllCutomType($tablename){
        $mysqli = new mysqli(HOST, USERDB, PASSWORDDB, DBNAME);
        if ($mysqli->connect_errno) {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        $resultarray=array();
        $query = "SELECT * FROM ".$tablename;

        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $resultarray[]=$row;
            }
            $result->free();
        }
        $mysqli->close();
        return  $resultarray;

    }
}