<?php
$conn = mysqli_connect('localhost','root',NULL,'projectdb','3306');

if(!$conn){
    echo 'Connection error: '.mysqli_connect_error();
}
?>
