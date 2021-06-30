<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('normal');

$usuario = json_encode($_SESSION["user"]["usuario"]);
?>


<?= headerLayout('Cuestionarios') ?>
  <?= renderNav(array(), 'Cuestionarios') ?>
  <div id="app" class="container mt-5 mb-5">
    <h4>Cuestionarios - <b>{{usuario.nom_persona}}</b></h4>
    <div class="row">
      <div class="col-6" v-for="cuestionario in cuestionarios">
        <div class="card mt-4">
          <div class="card-body">
            <h4 class="card-title">{{cuestionario.nom_cuestionario}}</h4>
            <p class="card-text">
              <button class="btn btn-success">Contestar</button>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        cuestionarios: [],
        usuario: JSON.parse('<?= $usuario ?>')
      },
      created: function(){
        this.fethCuestionariosPorAlumno();
      },
      methods: {
        fethCuestionariosPorAlumno: function(){
          api("getCuestionariosAlumnoConEstatus", {id_alumno: this.usuario.id_persona}, (data) =>{
            this.cuestionarios = data.map((item) => item.cuestionario);
            console.log("Data", data);
          });
        },
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
