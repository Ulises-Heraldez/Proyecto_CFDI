<?php

session_start();

if(isset($_SESSION['id_usuario']))
{
	unset($_SESSION['id_usuario']);

}

header("Location: login.php");
die;