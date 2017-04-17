<?php
/* Proceso de Restablecimiento de contraseña, actualiza la base de datos con la contraseña nueva del usuario */
require 'db.php';
session_start();

// Nos aseguramos de que el formulario se remitido con el metodo="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{ 

    // Nos aseguramos que las dos contraseñas coincidan
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) 
    { 
        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
        
        // Obtenemos $_POST['email'] y $_POST['hash'] del campo oculto en reset.php form
        $email = $mysqli->escape_string($_POST['email']);
        $hash = $mysqli->escape_string($_POST['hash']);
        
        $sql = "UPDATE users SET password='$new_password', hash='$hash' WHERE email='$email'";

        if ( $mysqli->query($sql) ) 
        {
            $_SESSION['message'] = "Tu contraseña se ha restablecido correctamente";
            header("location: success.php");    
        }
    }
    else 
    {
        $_SESSION['message'] = "Las dos contraseñas no coinciden, intenta nuevamente";
        header("location: error.php");    
    }
}
?>