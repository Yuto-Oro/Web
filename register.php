<?php
/* Proceso de Registro, inserta informacion del usuario a la base de datos 
   y envia mensaje de confirmacion de cuenta al correo
 */

// Establecemos todas las variables de sesion usadas en la pagina profile.php 
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];
$_SESSION['last_name2'] = $_POST['lastname2'];
$_SESSION['edad'] = $_POST['age'];
$_SESSION['username'] = $_POST['username'];

// Escapamos todas nuestras variables para protegernos de inyecciones SQL
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$last_name2 = $mysqli->escape_string($_POST['lastname2']);
$edad = $mysqli->escape_string($_POST['age']);
$username = $mysqli->escape_string($_POST['username']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
      
// Checamos si un usuario con ese correo ya existe
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

// Sabemos que si existe si el numero de filas > 0
if ( $result->num_rows > 0 ) 
{
    
    $_SESSION['message'] = 'Ya existe un usuario con ese correo!';
    header("location: error.php");   
}
else // El correo no esta registrado en nuestra db, proseguimos...
{ 

    // 0 es no-activo por DEFAULT
    $sql = "INSERT INTO users (first_name, last_name,last_name2, age, email, username, password, hash) " 
            . "VALUES ('$first_name','$last_name','$last_name2','$edad','$email','$username','$password', '$hash')";

    // Añadir usuario a la base de datos
    if ( $mysqli->query($sql) )
    {

        $_SESSION['active'] = 0; //0 hasta que el usuario active su cuenta con verify.php
        $_SESSION['logged_in'] = true; // Para que sepamos que el usuario ha iniciado sesion
        $_SESSION['message'] =
                
                 "Un link de confirmacion ha sido enviado a $email, por favor verifica
                 tu cuenta haciendo click al siguiente link en el mensaje";

        // Enviamos link de registro confirmacion (verify.php)
        $to      = $email;
        $subject = 'Verificacion de Cuenta ( TiendaOro )';
        $message_body = '
        Hola '.$first_name.',

        Gracias por registrarte en la PrebeTienda.

        Por favor haz click en el siguiente link para activar tu cuenta:

        http://localhost/ProyectoWeb/verify.php?email='.$email.'&hash='.$hash;  

        mail( $to, $subject, $message_body );

        header("location: profile.php"); 
    }
    else 
    {
        $_SESSION['message'] = 'Fallo el registro';
        header("location: error.php");
    }

}