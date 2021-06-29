<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('admin');
?>


<?= headerLayout('Administrador') ?>
  <?= renderNav($admin_nav_items, 'Preguntas') ?>
  <div id="app" class="container mt-2">
    <h4>Preguntas</h4>
    <div class="d-flex justify-content-end">
      <a href="pregunta_form.php" class="btn btn-success"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Crear pregunta</a>
    </div>

    <table class="table table-stripped">
      <thead>
        <tr>
          <th>Pregunta</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="pregunta in preguntas">
          <td>{{pregunta.pregunta}}</td>
          <td>{{pregunta.respA}}</td>
          <td>{{pregunta.respB}}</td>
          <td>{{pregunta.respC}}</td>
          <td>{{pregunta.respD}}</td>
          <td>{{pregunta.respE}}</td>
          <td>
            <button type="button" class="btn btn-danger" @click="eliminarPregunta(pregunta)">
              <i class="fa fa-trash" aria-hidden="true"></i>
              Eliminar
            </button>
            <a :href="`pregunta_form.php?id_pregunta=${pregunta.id_pregunta}`" type="button" class="btn btn-warning">
              <i class="fas fa-pen"></i>
              Editar
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        preguntas: []
      },
      created: function(){
        this.fetchPreguntas();
      },
      methods: {
        fetchPreguntas: function(){
          get("getPreguntas", (data) =>{
            this.preguntas = data;
          });
        },
        eliminarPregunta: function (pregunta) {
          const resp = confirm(`¿En verdad deseas eliminar la pregunta '${pregunta.pregunta}'?`);
          if(resp){
            api("deletePregunta", {
              "id_pregunta": pregunta.id_pregunta
            },
            () => {
                toastr.success('Pregunta eliminado exitosamente');
               this.preguntas = this.preguntas.filter((p) => p.id_pregunta !== pregunta.id_pregunta);
              }
            );
          }
        }
    
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
