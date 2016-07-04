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

$mysqli->query("UPDATE item_sort SET value = '$sort' WHERE `user`='$user'");