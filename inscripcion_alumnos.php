<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('admin');
?>


<?= headerLayout('Incripción de alumnos') ?>
  <?= renderNav($admin_nav_items, 'Inscripción alumnos') ?>
  <div id="app" class="container mt-2 pb-4 pt-4">
    <h4>Inscripción de alumnos</h4>
    <div class="form-group w-50 mt-3">
        <label for="cuestionario">Cuestionario</label>
        <select @change="fetchResultados" v-model="cuestionario" class="custom-select" name="cuestionario" id="cuestionario">
          <option selected :value="null">Seleeciona un cuestionario</option>
          <option v-for="cuestionario in cuestionarios" :value="cuestionario">
            {{cuestionario.nom_cuestionario}}
          </option>
        </select>
      </div>
      <div v-if="cuestionario !== null" class="mt-5">
          <div class="row">
                <div class="col-md-6">
                  <h5><b>Alumnos no inscritos</b></h5>
                </div>
                <div class="col-md-6">
                  <h5><b>Alumnos inscritos</b></h5>
                </div>
          </div>
      </div>
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        cuestionarios: [],
        cuestionario: null,
        alumnosDisponibles: [],
        alumnosInscritos: [],
      },
      created: function(){
        this.fetchCuestionarios();
      },
      methods: {
        fetchCuestionarios: function(){
          get("getCuestionarios", (data) => {
            this.cuestionarios = data;
          })
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
