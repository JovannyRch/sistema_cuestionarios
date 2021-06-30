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
                  <h5><b>Alumnos Inscritos</b></h5>
                  <table class="table table-stripped">
                  <thead>
                    <tr>
                      <th>Alumno</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="alumno in alumnosInscritos">
                      <td>{{alumno.nom_persona}} {{alumno.app_persona}} {{alumno.apm_persona}}</td>
                      <td>
                      <button type="button" class="btn btn-warning" @click="quitarAlumno(alumno)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Quitar
                      </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </div>
                <div class="col-md-6">
                  <h5><b>Alumnos No Inscritos</b></h5>
                  <table class="table table-stripped">
                  <thead>
                    <tr>
                      <th>Alumno</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="alumno in alumnosDisponibles">
                      <td>{{alumno.nom_persona}} {{alumno.app_persona}} {{alumno.apm_persona}}</td>
                      <td>
                        <button type="button" class="btn btn-primary" @click="agregarAlumno(alumno)">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                          Inscribir
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
        },
        fetchAlumnosInscritos: function(){
          api("getAlumnosInscritos", {
              "id_cuestionario": Number(this.cuestionario.id_cuestionario)
            },
            (data) => this.alumnosInscritos = data)
        },
        fetchAlumnosNoInscritos: function(){
          api("getAlumnosNoInscritos", {
              "id_cuestionario": Number(this.cuestionario.id_cuestionario)
            },
            (data) => this.alumnosDisponibles = data)
        },
        fetchResultados(){
          
          if(this.cuestionario != null){
            console.log(Number(this.cuestionario.id_cuestionario))
            this.fetchAlumnosInscritos();
            this.fetchAlumnosNoInscritos();
          }
        },
        quitarAlumno: function (alumno) {
          const resp = confirm(`¿En verdad deseas quitar a ${alumno.nom_persona} de este cuestionario?`);
          if(resp){
            api("deleteAlumnoCuestionario", {
              "id_persona": alumno.id_persona,
              "id_cuestionario": this.cuestionario.id_cuestionario
            },
            () => {
                toastr.success('Alumno quitad@ exitosamente');
                this.fetchResultados();
              }
            );
          }
        },
        agregarAlumno: function (alumno) {
          const resp = confirm(`¿En verdad deseas agregar a ${alumno.nom_persona} a este cuestionario?`);
          if(resp){
            console.log(alumno);
            api("addAlumnoCuestionario", {
              "id_persona": alumno.id_persona,
              "id_cuestionario": this.cuestionario.id_cuestionario,
              "cali": -1.0
            },
            () => {
                toastr.success('Alumno agregado exitosamente');
                this.fetchResultados();
              }
            );
          }
        },
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
