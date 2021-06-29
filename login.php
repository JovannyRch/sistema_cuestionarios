<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';

session_start();

$password = "";
$email = "";

if (isset($_POST["email"]) && $_POST["password"]) {
    $consultas = new Consultas();
    $email = $_POST["email"];
    $password = $_POST["password"];

    $usuario = $consultas->iniciarSesion($email, $password);

    if (isset($usuario)) {
      $_SESSION['user'] = $usuario;
      if($usuario["tipo"]  == "admin"){
        header("Location: cuestionario_lista.php");
      }
      else if($usuario["tipo"] == "profesor"){
        header("Location: index_profesor.php");
      }
      else{
        header("Location: index.php");
      }
    } else {
        $_SESSION['alert'] = array("type"=> "danger", "message" => "Credenciales no encontradas, por favor verifique sus datos");
    }
}

?>


<?= headerLayout('Inicio de sesión') ?>
  
  <div class="d-flex flex-column mt-5 justify-content-center align-items-center">
    <h3 class="text-center mt-4">Inicio de sesión</h3>
    <div class="mt-4 w-50">
      <?php
          if (isset($_SESSION['alert'])) {
              checkAlert($_SESSION['alert']);
          }
      ?>
      <form class="mt-3" action="./login.php" method="post" >
          <div class="form-group">
            <label for="email">Correo</label>
            <input value="<?= $email ?>"type="text" class="form-control" name="email" id="email"  placeholder="Ingresa tu correo">
          </div>
          <br/> 
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input value="<?= $password ?>" type="password" class="form-control" name="password" id="password"  placeholder="Ingresa tu contraseña">
          </div>
         <div class="d-flex justify-content-center mt-3">
           <button class="btn btn-primary">Iniciar sesión</button>
         </div>
      </form>
    </div>
  </div>

<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
