<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 03.07.2016
 * Time: 11:21
 */

require_once ('db_config.php');

$sort = $_POST['sort'];
$user = $_POST['user'];

$result = $mysqli->query("SELECT * FROM item_sort WHERE `user`='$user'");

if($result->num_rows){
    $mysqli->query("UPDATE item_sort SET value = '$sort' WHERE `user`='$user'");
}else{
    $mysqli->query("INSERT INTO item_sort (`user`, `value`) VALUES ('$user', '$sort')");
}