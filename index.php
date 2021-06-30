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
    <h4><b>{{usuario.nom_persona}}</b></h4>
    <div class="row">
      <div class="col-6" v-for="cuestionario in cuestionarios">
        <div class="card mt-4">
          <div class="card-body">
            <h4 class="card-title"><b>{{cuestionario.nom_cuestionario}}</b></h4>
            <h6><i>{{cuestionario.nom_categoria}}</i></h6>
            <p class="card-text" v-if="cuestionario.cal_cuestionario == -1">
              <a :href="`cuestionario.php?id_cuestionario=${cuestionario.id_cuestionario}`" class="btn btn-success">Contestar</a>
            </p>
            <p v-else class="card-text">
              Calificación obtenida: <b>{{cuestionario.cal_cuestionario}}</b>
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
        usuario: JSON.parse('<?= $usuario ?>'),
      },
      created: function(){
        this.fethCuestionariosPorAlumno();
      },
      methods: {
        fethCuestionariosPorAlumno: function(){
          api("getCuestionariosAlumnoConEstatus", {id_alumno: this.usuario.id_persona}, (data) =>{
            this.cuestionarios = data;
          });
        },
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
