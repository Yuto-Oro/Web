<?php 
/* Formulario para restablecer contraseña, envia link de reset.php */
require 'db.php';
session_start();

// Checamos si el formulario se remitio con method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // El usuario no existe
    { 
        $_SESSION['message'] = "No existe usuario con ese correo!";
        header("location: error.php");
    }
    else // El usuario existe (num_rows != 0)
    { 

        $user = $result->fetch_assoc(); // $user se convierte en arreglo con informacion de user
        
        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

        // Mensaje de sesion para mostrar en success.php
        $_SESSION['message'] = "<p>Por favor checa tu email <span>$email</span>"
        . " por un link de confirmacion para resetear tu password.</p>"; 

        // Envia link de registro y confirmacion (reset.php)
        $to      = $email;
        $subject = 'Link de restablecimiento de contraseña ( TiendaOro )';
        $message_body = '
        Hola '.$first_name.',

        Has solicitado que se restablezca tu contraseña!

        Por favor has click en el siguiente link para que se restablezca tu contraseña:

        http://localhost/ProyectoWeb/reset.php?email='.$email.'&hash='.$hash;  

        mail($to, $subject, $message_body);

        header("location: success.php");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Restablece tu contraseña</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    
  <div class="form">

    <h1>Restablece tu contraseña</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Correo Electronico<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>
          
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
