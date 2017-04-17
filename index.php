<link rel="stylesheet" type="text/css" href="css/form.css">
<?php 
/* Página principal con dos forms: Registro e inicio de sesion */
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registrate/Inicia Sesion</title>
  <?php include 'css/css.html'; ?>
</head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) //si el usuario iniciara sesion
    { 
      require 'login.php';  
    }
    
    elseif (isset($_POST['register'])) //si el usuario se registrara 
    {   
      require 'register.php';   
    }
  }
  ?>
  <body>
    <div class="form">

      <ul class="tab-group">
        <li class="tab"><a href="#signup">Registrate</a></li>
        <li class="tab active"><a href="#login">Inicia Sesion</a></li>
      </ul>
      
      <div class="tab-content">

       <div id="login">   
        <h1>¡Bienvenido nuevamente!</h1>

        <form action="index.php" method="post" autocomplete="off">

          <div class="field-wrap">
            <label>
              Direccion Email<span class="req">*</span>
            </label>
            <input type="email" required autocomplete="off" name="email"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Contraseña<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="password"/>
          </div>
          
          <p class="forgot"><a href="forgot.php">¿Olvidaste tu contraseña?</a></p>
          
          <button class="button button-block" name="login" />Inicia Sesion</button>
          
        </form>

      </div>

      <div id="signup">   
        <h1>Registrate sin Costo</h1>

        <form action="index.php" method="post" autocomplete="off">

          <div class="top-row">
            <div class="field-wrap">
              <label>
                Nombre(s)<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='firstname' />
            </div>

            <div class="field-wrap">
              <label>
                Apellido Paterno<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name='lastname' />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Apellido Materno<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name='lastname2' />
          </div>

          <div class="field-wrap">
            <label>
              Edad<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name='age' />
          </div>

          <div class="field-wrap">
            <label>
              Correo Electronico<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name='email' />
          </div>

          <div class="field-wrap">
            <label>
              Nombre Usuario<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name='username' />
          </div>
          
          <div class="field-wrap">
            <label>
              Contraseña<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name='password'/>
          </div>
          
          <button type="submit" class="button button-block" name="register" />Registrate</button>
          
        </form>

      </div>  

    </div><!-- tab-content -->

  </div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="js/index.js"></script>
</body>
</html>
