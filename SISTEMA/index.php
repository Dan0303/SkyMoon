<?php 
session_start();
if(!isset($_SESSION['usuario_id'])){
     header("Location:login.html");
     exit();
   
}
//print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<a href="Cerrar.php">Cerrar</a> |
<a href="#">quienes somos</a> | 
<a href="#">desarrollador</a>

<h2>Inicio de la aplicacion, Bienvenido@ <?php echo $_SESSION['usuario_nombre'];?></h2>

<p>Este es el inicio de la aplicacion</p>

</body>
</html>