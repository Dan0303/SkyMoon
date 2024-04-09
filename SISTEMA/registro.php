<?php 



if($_SERVER["REQUEST_METHOD"]=="POST"){
include("conexion.php");

    $errores= array(); // este array valida si hay datos vacios
   
    // esto es un temario donde se verifica si los datos solicitados en el registro fueron enviados a traves del metodo post
    $nombres=(isset($_POST['nombres']))? $_POST['nombres']:null;
    $email=(isset($_POST['email']))? $_POST['email']:null;
    $apellidos=(isset($_POST['apellidos'])) ? $_POST['apellidos']:null;
    $password=(isset($_POST['password'])) ? $_POST['password']:null;
    $confirmarPassword=(isset($_POST['confirmarPassword'])) ? $_POST['confirmarPassword']:null;
    $genero=(isset($_POST['genero'])) ? $_POST['genero']:null;
    $libro=(isset($_POST['libro'])) ? $_POST['libro']:null;

    //validacion de nombres
    if(empty($nombres)){
        $errores['nombres']="Debe ingresar los nombres";
    }
    //validacion de apellidos
    if(empty($apellidos)){
        $errores['apellidos']="Debe ingresar los apellidos";
    }
    //validacion del genero
    if(empty($genero)){
        $errores['genero']="Debe selecionar el genero";
    }
    //validacion del libro
    if(empty($libro)){
         $errores['libro']="Debe selecionar  un libro";
    }
    //validacion de email
    if(empty($email)){
        $errores['email'] = "El email es obligatorio.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errores['email'] = "Ingrese un email válido.";   
    }
    if(empty($password)){
        $errores['genero']="la contraseña es obligatoria";
    }
    if(empty($confirmarPassword)){
        $errores['confirmarPassword']="la contraseña es incorrecta, debes confirmar la contraseña";
    }elseif($password!=$confirmarPassword){
        $errores['confirmarPassword']="la contraseña no coinciden";
    }


    foreach($errores as $error){
        echo "<br>".$error;
    }
    //print_r($errores);

    if(empty($errores==true)){ // consulta con la base de datos
    try{
        $pdo=new PDO('mysql:host='.$direccionservidor.';dbname='.$baseDatos,$usuarioBD,$contraseniaBD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // INCRIPTACION DE LA CONTRASEÑA
        $nuevoPassword=password_hash($password,PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `email`, `password`, `genero`, `libro`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?)";
       
        $resultado=$pdo -> prepare($sql);
        $resultado->execute([$nombres, $apellidos, $email, $nuevoPassword, $genero, $libro]);
        header("location:login.html");
   
    }catch(PDOException $e){
        echo "hubo un error de conexion".$e->getMessage();
    }
}else{
    echo "<br>"."<a href='registro.html'>Regresar al inicio</a>";;
}
}
?>