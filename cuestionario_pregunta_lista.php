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

    <div class="alert alert-danger" role="alert" v-if="preguntas.length === 0">
        El cuestionario no tiene preguntas asignadas
    </div>
    

    <a href="cuestionario_lista.php" type="button" class="btn btn-danger mt-3">Cancelar</a>

    
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
        guardar(){
          if(this.validarForm()){
            if(this.edit){
              api("updateCuestionario", {
                id_cuestionario: this.cuestionario.id_cuestionario,
                nom_cuestionario: this.cuestionario.nom_cuestionario,
                id_categoria: this.cuestionario.id_categoria,
              }, () => {
                
                toastr.success("Cuestionario actualizado exitosamente");
                
              })
            }else{
              api("crearCuestionario", this.cuestionario, () => {
              toastr.success("Cuestionario creado exitosamente");
              
            })
            }
            setTimeout(() => {
              window.location.href="cuestionario_lista.php";  
              
            }, 2000);
          }else{
            toastr.error("Complete todos los campos");
          }
        },
        validarForm(){
          const { nom_cuestionario, id_categoria }  = this.cuestionario;
          return nom_cuestionario !== "" && id_categoria !== "";
        },
        fetchCuestionario(){
          api("getCuestionario", {id_cuestionario: this.id_cuestionario}, (data) => this.cuestionario = data);
        },
        fetchPreguntasCuestionario(){
            api("getPreguntasCuestionario",{id_cuestionario: this.id_cuestionario}, 
            (data) => this.preguntas = data);
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
