<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from usuarios where nombre = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['contraseña'] === $password)
					{
						$_SESSION['id_usuario'] = $user_data['id_usuario'];
						header("Location: index.php");
						die;
					}
				}
			}
			
			echo "<script type='text/javascript'>alert('Usuario y/o contraseña incorrectos');</script>";
			
		}else
		{
			echo "<script type='text/javascript'>alert('Usuario y/o contraseña incorrectos');</script>";
			//alerta_incorrecto();
		}
	}

?>



<script>
function alerta_vacio() {

	let name = document.getElementById("nombre").value; 
	let password = document.getElementById("contraseña").value; 

	//alert(name);
	//alert(password);

	if (name == "" || password == "")
	{
		alert("Llene ambos campos");
	}

}

function alerta_incorrecto() {
	
	alert("Usuario y/o contraseña incorrectos");

}
</script>


<!DOCTYPE html>
<html>
<head>
	<title>Loguearse</title>
	<link rel="stylesheet" href="css/estilo_login.css">
</head>
<body>
	<div id="box">
		
		<form method="post">
			<div style="font-size: 40px;margin: 10px;color: white;">Iniciar sesión</div>

			<input id="nombre" type="text" name="user_name"><br><br>
			<input id="contraseña" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Loguearse" onclick="alerta_vacio()"><br><br>

			<a href="signup.php">Registrarse</a><br><br>
		</form>
	</div>
</body>
</html>