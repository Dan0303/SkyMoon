<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST"){ 
    include("conexion.php");
    $errores= array();
    //print_r($_POST);
    
    $email=(isset($_POST['email']))?htmlspecialchars($_POST['email']):null;
    $password=(isset($_POST['password']))?$_POST['password']:null;
    
    if(empty($email)){
        $errores['email'] = "El email es obligatorio.";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errores['email'] = "Ingrese un email válido.";   
    }
    if(empty($password)){
        $errores['genero']="la contraseña es obligatoria";
    }

    if(empty($errores==true)){
    try{
        $pdo=new PDO('mysql:host='.$direccionservidor.';dbname='.$baseDatos,$usuarioBD,$contraseniaBD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql="SELECT * FROM usuarios WHERE email=:email";
        $sentencia= $pdo->prepare($sql);
        $sentencia->execute(['email'=>$email]);

        $usuarios= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        //print_r($usuarios);

        $login = false;

        foreach($usuarios as $user){
             // INCRIPTACION DE LA CONTRASEÑA
            if(password_verify($password, $user["password"])){
                $_SESSION['usuario_id']=$user['id'];
                $_SESSION['usuario_nombre']=$user['nombres'].' '.$user['apellidos'];
                
                $login=true;
            }
                //echo 'Inicio de sesión correcto!';
                //header("Location: index.php");

        }

        if($login){
            echo "existe en la db";
            header("Location:index.php");
        }else{
            echo "no existe en la db";
        }
    }catch(PDOException $e){



    }
}else{
    foreach($errores as $error){
        echo "<br>".$error;
        

    }
    echo "<br>"."<a href='login.html'>Regresar al login</a>";;
}
}


?>