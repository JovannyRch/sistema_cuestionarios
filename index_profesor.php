<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';


validarTipoUsuario("profesor");

?>


<?= headerLayout('Profesor') ?>

  <div class="container mt-5">
    <div class="d-flex flex-row justify-content-end">
      <a type="button" class="btn btn-warning" href="logout.php" >Cerrar sesión</a>
    </div>
    <h4>Profesor</h4>
  </div>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
