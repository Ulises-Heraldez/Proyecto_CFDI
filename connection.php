<?php

//Hosteado Online
// $dbhost = "185.37.231.112";
// $dbuser = "y204001_mike";
// $dbpass = "^u?wCltrh,ds";
// $dbname = "y204001_mike";

//Hosteado Local
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "200019";
$dbname = "cfdi";


if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
