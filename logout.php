<?php
/* Proceso de cerrar sesion, desactiva y destruye variables de sesion */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">
          <h1>Gracias por visitarnos, esperamos vuelva pronto</h1>
              
          <p><?= 'Se ha cerrado correctamente tu sesion'; ?></p>
          
          <a href="index.php"><button class="button button-block"/>Home</button></a>

    </div>
</body>
</html>
