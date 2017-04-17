<?php
  /* Formulario de restablecimiento de contraseña, el link a esta pagina esta incluido 
   en el mensaje al mail en forgot.php 
  */
   require 'db.php';
   session_start();

  // Checamos que Email y Hash no esten vacias
   if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
   {
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 

    // Checamos que email coincida con hash y ademas exista
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    { 
      $_SESSION['message'] = "Has ingresado un URL invalido para el restablecimiento de tu contraseña";
      header("location: error.php");
    }
  }
  else 
  {
    $_SESSION['message'] = "Lo sentimos, la verificacion fallo, intente nuevamente.";
    header("location: error.php");  
  }
  ?>
  <!DOCTYPE html>
  <html >
  <head>
    <meta charset="UTF-8">
    <title>Restablece tu contraseña</title>
    <?php include 'css/css.html'; ?>
  </head>

  <body>
    <div class="form">

      <h1>Teclea tu contraseña nueva</h1>

      <form action="reset_password.php" method="post">

        <div class="field-wrap">
          <label>
            Contraseña nueva<span class="req">*</span>
          </label>
          <input type="password"required name="newpassword" autocomplete="off"/>
        </div>

        <div class="field-wrap">
          <label>
            Confirma tu contraseña nueva<span class="req">*</span>
          </label>
          <input type="password"required name="confirmpassword" autocomplete="off"/>
        </div>

        <!-- Este campo es necesario para obtener el email del usuario -->
        <input type="hidden" name="email" value="<?= $email ?>">    
        <input type="hidden" name="hash" value="<?= $hash ?>">    

        <button class="button button-block"/>Apply</button>

      </form>

    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>

  </body>
  </html>
