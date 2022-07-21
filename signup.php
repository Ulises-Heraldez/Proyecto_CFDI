<?php
session_start();

include("connection.php");
include("functions.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//something was posted
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];

	if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

		//save to database
		$user_id = random_num(20);
		$query = "insert into usuarios (nombre,contraseña) values ('$user_name','$password')";

		mysqli_query($con, $query);

		header("Location: login.php");
		die;
	} else {		
		echo "<script type='text/javascript'>alert('Ingrese información válida');</script>";

	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Registro</title>
	<link rel="stylesheet" href="css/estilo_signup.css">
</head>

<body>

	<div id="box">

		<form method="post">
			<div style="font-size: 40px;margin: 10px;color: white;">Registrarse</div>

			<input id="nombre" type="text" name="user_name"><br><br>
			<input id="contraseña" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Registrarse"><br><br>

			<a href="login.php">Loguearse</a><br><br>
		</form>
	</div>
</body>

</html>