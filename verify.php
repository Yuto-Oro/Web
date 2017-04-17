<?php 
/* Verifica que el email del usuario este registrado, el link a esta pagina
   esta incluido en el mensaje 'email' en register.php  
*/
   require 'db.php';
   session_start();

    // Nos aseguramos que las variables email y hash no esten vacias
   if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
   {
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 
    
    // Seleccionamos usuario donde email y hash coincidan y que, ademas, no hayan verificado su cuenta aun (active = 0)
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash' AND active='0'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message'] = "La cuenta ya ha sido activada o el URL es invalido";

        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Tu cuenta ha sido activada";
        
        // Cambiamos el status del usuario a activo (active = 1)
        $mysqli->query("UPDATE users SET active='1' WHERE email='$email'") or die($mysqli->error);
        $_SESSION['active'] = 1;
        
        header("location: success.php");
    }
}
else 
{
    $_SESSION['message'] = "Parametros invalidos para la activacion de la cuenta.";
    header("location: error.php");
}     
?>