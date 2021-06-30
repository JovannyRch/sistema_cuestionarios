<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('admin');

$id_cuestionario = "";

if(isset($_GET["id_cuestionario"])){
  $id_cuestionario = $_GET['id_cuestionario'];
}

?>

<?= headerLayout('Administrador') ?>
  <?= renderNav($admin_nav_items, 'Cuestionarios') ?>
  <div id="app" class="container mt-2">
    <h4>{{ cuestionario.nom_cuestionario }}</h4>

    <table class="table table-stripped" v-if="preguntas.length > 0">
      <thead>
        <tr>
          <th>Pregunta</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="pregunta in preguntas">
          <td>{{pregunta.pregunta}}</td>
          
          <td>
            <button type="button" class="btn btn-primary" @click="agregarPregunta(pregunta)">
              <i class="fa fa-plus" aria-hidden="true"></i>
              Agregar
            </button>
            
          </td>
        </tr>
      </tbody>
    </table>

    <div class="alert alert-danger" role="alert" v-if="preguntas.length === 0">
        No hay preguntas nuevas para agregar a este cuestionario
    </div>
    

    <a :href="`cuestionario_pregunta_lista.php?id_cuestionario=${cuestionario.id_cuestionario}`" type="button" class="btn btn-danger mt-3">Cancelar</a>

    
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
          this.fetchPreguntasDisponibles();
        }
      },
      methods: {
        fetchCuestionario(){
          api("getCuestionario", {id_cuestionario: this.id_cuestionario}, (data) => this.cuestionario = data);
        },
        fetchPreguntasDisponibles(){
            api("getPreguntasDisponibles",{id_cuestionario: this.id_cuestionario}, 
            (data) => this.preguntas = data);
        },
        agregarPregunta: function (pregunta) {
          const resp = confirm(`¿Desea agregar esta pregunta al cuetionario ${this.cuestionario.nom_cuestionario}?`);
          if(resp){
            api("addPreguntaCuestionario", {
              "id_pregunta": pregunta.id_pregunta,
              "id_cuestionario": this.id_cuestionario
            },
            () => {
                toastr.success('Pregunta agregada exitosamente');
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
