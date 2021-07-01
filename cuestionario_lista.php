<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';
$tipo = $_SESSION["user"]["tipo"];

validarAdminProfe($tipo);
?>


<?= headerLayout($tipo == "admin"? "Administrador": "Profesor") ?>
  <?= renderNav($tipo == "admin"? $admin_nav_items: $profesor_nav_items, 'Cuestionarios') ?>
  <div id="app" class="container mt-2">
    <h4>Cuestionarios</h4>
    <div class="d-flex justify-content-end">
      <a href="cuestionario_form.php" class="btn btn-success"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Crear cuestionario</a>
    </div>

    <table class="table table-stripped">
      <thead>
        <tr>
          <th>Nombre del cuestionario</th>
          <th>Fecha elaboración</th>
          <th>Categoría</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cuestionario in cuestionarios">
          <td>{{cuestionario.nom_cuestionario}}</td>
          <td>{{cuestionario.fec_elaboracion}}</td>
          <td>{{cuestionario.nom_categoria}}</td>
          <td>
            <button type="button" class="btn btn-danger" @click="eliminarCuestionario(cuestionario)">
              <i class="fa fa-trash" aria-hidden="true"></i>
              Eliminar
            </button>
            <a :href="`cuestionario_form.php?id_cuestionario=${cuestionario.id_cuestionario}`" type="button" class="btn btn-warning">
              <i class="fas fa-pen    "></i>
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
        cuestionarios: []
      },
      created: function(){
        this.fethCuestionarios();
      },
      methods: {
        fethCuestionarios: function(){
          get("getCuestionarios", (data) =>{
            this.cuestionarios = data;
          });
        },
        eliminarCuestionario: function (cuestionario) {
          const resp = confirm(`¿En verdad deseas eliminar el cuestionario '${cuestionario.nom_cuestionario}'?`);
          if(resp){
            api("deleteCuestionario", {
              "id_cuestionario": cuestionario.id_cuestionario
            },
            () => {
                toastr.success('Cuestionario eliminado exitosamente');
                this.cuestionarios = this.cuestionarios.filter((c) => c.id_cuestionario !== cuestionario.id_cuestionario);
              }
            );
          }
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
