<?php
/* Proceso de inicio de sesion, checa que el usuario/contraseña existan y esten correctos. */

// Escapamos por razones de seguridad 
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

if ( $result->num_rows == 0 ) // El usuario no existe
{ 
    $_SESSION['message'] = "No existe usuario con ese correo";
    header("location: error.php");
}
else // El usuario existe
{ 
    $user = $result->fetch_assoc();

    if ( password_verify($_POST['password'], $user['password']) ) 
    {
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
        
        // Así sabremos que el usuario esta conectado
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
    }
    else 
    {
        $_SESSION['message'] = "Contraseña errona, por favor intenta nuevamente";
        header("location: error.php");
    }
}

