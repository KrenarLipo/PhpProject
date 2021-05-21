<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crud_connection";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

    die("failed to connect");
}