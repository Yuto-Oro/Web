<?php
/* Muestra la informacion del usuario */
session_start();

// Checamos si el usuario esta conectado con la variable de SESSION
if ( $_SESSION['logged_in'] != 1 ) 
{
  $_SESSION['message'] = "Te debes conectar antes de ver la pagina de perfil!";
  header("location: error.php");    
}
else 
{
  $first_name = $_SESSION['first_name'];
  $last_name = $_SESSION['last_name'];
  //$last_name2 = $_SESSION['last_name2'];
  //$edad = $_SESSION['edad'];
  //$username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $active = $_SESSION['active'];
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Bienvenido <?= $first_name.' '.$last_name?></title>
  <?php include 'css/css.html'; ?>
</head>

<body>
  <div class="form">

    <h1>Bienvenido</h1>

    <p>
      <?php 
          // Muestra mensaje acerca de verificacion de correo
      if ( isset($_SESSION['message']) )
      {
        echo $_SESSION['message'];

              // Al recargar la pagina los mensajes desaparecen
        unset( $_SESSION['message'] );
      }

      ?>
    </p>

    <?php

          // Continua recordando al usuario que no ha activado su cuenta
    if ( !$active )
    {
      echo
      '<div class="info">
      Cuenta no verificada, por favor confirma tu correo presionando
      el link del email
      </div>';
    }
  ?>
  <h2><?php echo $first_name.' '.$last_name; ?></h2>
  <p><?= $email ?></p>
  <a href="displayProducts.php"><button class="button button-block" name="product"/>Consulta nuestras Peliculas</button></a>
  <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>
</html>
