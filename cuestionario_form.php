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
    <h4>{{ edit? "Editar": "Agregar"}} Cuestionario</h4>
    <div class="w-50">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input v-model="cuestionario.nom_cuestionario" type="text"
            class="form-control" name="nombre" id="nombre" placeholder="Escribe el nombre del cuestionario">
        </div>
        <br />
        <div class="form-group">
          <label for="categoria">Seleccione una categoria</label>
          <select class="form-control" name="categoria" id="categoria" v-model="cuestionario.id_categoria">
            <option v-for="categoria in categorias" :value="categoria.id_categoria">{{categoria.nom_categoria}}</option>
          </select>
        </div>
    </div>  
    <button @click="guardar" class="btn btn-success mt-3"> 
      {{ edit? "Guardar cambios": "Agregar"}}
    </button>

    <a :href="`cuestionario_pregunta_lista.php?id_cuestionario=${cuestionario.id_cuestionario}`" type="button" class="btn btn-primary mt-3">Ver Preguntas</a>

    <a href="cuestionario_lista.php" type="button" class="btn btn-danger mt-3">Cancelar</a>

    
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        cuestionarios: [],
        categorias: [],
        id_cuestionario: "<?= $id_cuestionario ?>",
        cuestionario: {
          nom_cuestionario: "",
          id_categoria: '',
        },
        edit: false,
    },
      created: function(){
        this.fetchCategorias();
        if(this.id_cuestionario){
          this.edit = true;
          this.fetchCuestionario();
        }
      },
      methods: {
        fetchCategorias: function(){
          get("getCategorias", (data) =>{
            this.categorias = data;
          });
        },  
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
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
