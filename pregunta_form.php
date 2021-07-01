<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('profesor');

$id_pregunta = "";

if(isset($_GET["id_pregunta"])){
  $id_pregunta = $_GET['id_pregunta'];
}

?>


<?= headerLayout('Profesor') ?>
  <?= renderNav($profesor_nav_items, 'Preguntas') ?>
  <div id="app" class="container mt-2 pb-4 pt-4">
    <h4>{{ edit? "Editar": "Agregar"}} Pregunta</h4>
    <div class="w-50">
        <div class="form-group">
          <label for="pregunta">Pregunta</label>
          <textarea v-model="pregunta.pregunta" class="form-control" id="pregunta" rows="3"></textarea>
        </div>
        <br />
        <div class="form-group">
          <label for="respA">Opción A</label>
          <input v-model="pregunta.respA" type="text"
            class="form-control" name="respA" id="respA" placeholder="Escribe la opción A">
        </div>
        <br />

        <div class="form-group">
          <label for="respB">Opción B</label>
          <input v-model="pregunta.respB" type="text"
            class="form-control" name="respB" id="respB" placeholder="Escribe la opción B">
        </div>
        <br />

        <div class="form-group">
          <label for="respC">Opción C</label>
          <input v-model="pregunta.respC" type="text"
            class="form-control" name="respC" id="respC" placeholder="Escribe la opción C">
        </div>
        <br />

        <div class="form-group">
          <label for="respD">Opción D</label>
          <input v-model="pregunta.respD" type="text"
            class="form-control" name="respD" id="respD" placeholder="Escribe la opción D">
        </div>
        <br />

        <div class="form-group">
          <label for="respE">Opción E</label>
          <input v-model="pregunta.respE" type="text"
            class="form-control" name="respE" id="respE" placeholder="Escribe la opción E">
        </div>
        <br />
        <div class="form-group">
          <label for="categoria">Opción correcta</label>
          <select class="form-control" name="categoria" id="categoria" v-model="pregunta.respCorrecta">
            <option value="" selected disabled>Selecciona la respuesta correcta</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
          </select>
        </div>
    </div>
    <button @click="guardar" class="btn btn-success mt-3"> 
      {{ edit? "Guardar cambios": "Agregar"}}
    </button>
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        cuestionarios: [],
        id_pregunta: "<?= $id_pregunta ?>",
        pregunta: {
          pregunta: "",
          respA: '',
          respB: '',
          respC: '',
          respD: '',
          respE: '',
          respCorrecta: '',
        },
        edit: false,
    },
      created: function(){
        if(this.id_pregunta){
          this.edit = true;
          this.fetchPregunta();
        }
      },
      methods: {
        guardar(){
          if(this.validarForm()){
            if(this.edit){
              api("updatePregunta", this.pregunta, () => {
                toastr.success("Pregunta actualizada exitosamente");
              })
            }else{
              api("crearPregunta", this.pregunta, () => {
              toastr.success("Pregunta creado exitosamente");
            })
            }
            setTimeout(() => {
              window.location.href="preguntas_lista.php";  
              
            }, 2000);
          }else{
            toastr.error("Complete todos los campos");
          }
        },
        validarForm(){
          const { pregunta, 
              respA,
              respB,
              respC,
              respD,
              respE,
              respCorrecta 
          } = this.pregunta;
          return pregunta !== "" && respA !== "" && respB !== "" && respC !== "" && respD !== "" && respE !== "" && respCorrecta !== "";
        },
        fetchPregunta(){
          api("getPregunta", {id_pregunta: this.id_pregunta}, (data) => this.pregunta = data);
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
