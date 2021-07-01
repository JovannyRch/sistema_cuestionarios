<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

$tipo = $_SESSION["user"]["tipo"];

validarAdminProfe($tipo);


$id_cuestionario = "";

if(isset($_GET["id_cuestionario"])){
  $id_cuestionario = $_GET['id_cuestionario'];
}

?>

<?= headerLayout($tipo == "admin"? "Administrador": "Profesor") ?>
  <?= renderNav($tipo == "admin"? $admin_nav_items: $profesor_nav_items, 'Preguntas Cuestionarios') ?>
  <div id="app" class="container mt-2">
    <h4>{{ cuestionario.nom_cuestionario }}</h4>

    <table class="table table-stripped" v-if="preguntas.length > 0">
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
            <button type="button" class="btn btn-danger" @click="quitarPregunta(pregunta)">
              <i class="fa fa-trash" aria-hidden="true"></i>
              Quitar
            </button>
            <a :href="`pregunta_form.php?id_pregunta=${pregunta.id_pregunta}`" type="button" class="btn btn-warning">
              <i class="fas fa-pen"></i>
              Editar
            </a>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="alert alert-danger" role="alert" v-if="preguntas.length === 0">
        El cuestionario no tiene preguntas asignadas
    </div>
    
    <a :href="`cuestionario_pregunta_form.php?id_cuestionario=${cuestionario.id_cuestionario}`" type="button" class="btn btn-primary mt-3">Agregar Preguntas</a>
    <a href="cuestionario_lista.php" type="button" class="btn btn-danger mt-3">Volver</a>

    
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        preguntas: [],
        id_cuestionario: "<?= $id_cuestionario ?>",
        cuestionario: {
            nom_cuestionario: "",
            id_categoria: '',
        }
    },
      created: function(){
        if(this.id_cuestionario){
          this.fetchCuestionario();
          this.fetchPreguntasCuestionario();
        }
      },
      methods: {
        fetchCuestionario(){
          api("getCuestionario", {id_cuestionario: this.id_cuestionario}, (data) => this.cuestionario = data);
        },
        fetchPreguntasCuestionario(){
            api("getPreguntasCuestionario",{id_cuestionario: this.id_cuestionario}, 
            (data) => this.preguntas = data);
        },
        quitarPregunta: function (pregunta) {
          const resp = confirm(`¿En verdad deseas quitar la pregunta de este cuestionario?`);
          if(resp){
            api("deletePreguntaCuestionario", {
              "id_pregunta": pregunta.id_pregunta,
              "id_cuestionario": this.id_cuestionario
            },
            () => {
                toastr.success('Pregunta quitada exitosamente');
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
