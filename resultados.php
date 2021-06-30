<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('admin');
?>


<?= headerLayout('Resultados') ?>
  <?= renderNav($admin_nav_items, 'Resultados') ?>
  <div id="app" class="container mt-2 mb-5">
    <h4>Resultados</h4>
    <div class="d-flex flex-column mt-4">
      <div class="form-group w-50">
        <label for="alumno">Alumno</label>
        <select @change="fetchCuestionariosPoAlumno" v-model="alumno" class="form-control" name="alumno" id="alumno">
          <option selected :value="null">Seleeciona un alumno</option>
          <option v-for="alumno in alumnos" :value="alumno">
            {{alumno.nom_persona}}
          </option>
        </select>
      </div>

      <div class="form-group w-50 mt-3">
        <label for="cuestionario">Cuestionario</label>
        <select @change="fetchResultados" v-model="cuestionario" class="form-control" name="cuestionario" id="cuestionario">
          <option selected :value="null">Selecciona un cuestionario</option>
          <option v-for="cuestionario in cuestionarios" :value="cuestionario">
            {{cuestionario.nom_cuestionario}}
          </option>
        </select>
      </div>
    </div>
    <div class="mt-4" v-if="resultadosObtenidos">
        <h5><b>{{alumno.nom_persona}}</b> - <i><b>{{cuestionario.nom_cuestionario}}</b></i></h5>
        <div class="mb-2 mt-2">
          Total preguntas: {{preguntas.length}}
        </div>
        <div class="card mb-2" v-for="(pregunta, index) in preguntas">
          <div class="card-body d-flex">
             <div style="width: 95%">
              <div>{{index+1}}.- {{pregunta.pregunta}}</div>
              
             </div>
             <div style="width: 5%">
              
                <div v-if="esRespuestaCorrecta(pregunta, pregunta.resultado.respuesta)" class="alert alert-success text-center" role="alert">
                  <i  class="fa fa-check" aria-hidden="true"></i>
                </div>
                <div v-else class="alert alert-danger text-center" role="alert">
                  <i class="fa fa-times-circle" aria-hidden="true"></i>
                </div>
                <div class="text-center">
                  <b>{{pregunta.resultado.valor}}</b>
                </div>
             </div>
          </div>
        </div>
        <div class="d-flex justify-content-end" style="font-size: 20px;"> 
            <i>Resultado: </i> <b >{{obtenerPuntaje(preguntas)}}</b>
        </div>
    </div>
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        alumnos: [],
        cuestionarios: [],
        cuestionario: null,
        alumno: null,
        resultadosObtenidos: false,
        preguntas: [],
      },
      created: function(){
        this.fetchAlumnos();
      },
      methods: {
        obtenerPuntaje: function(preguntas){
          let total = 0;

          for(const p of preguntas){
            total += Number(p.resultado.valor);
          }
          return total;
        },
        esRespuestaCorrecta: function(pregunta, respuestaUsuario){
          return pregunta.respCorrecta == respuestaUsuario;
        },  

        obtenerRespuestaCorrecta(pregunta){
          if(pregunta.respCorrecta === "A"){
              return pregunta.respA;
          }
          if(pregunta.respCorrecta === "B"){
              return pregunta.respB;
          }
          if(pregunta.respCorrecta === "C"){
              return pregunta.respC;
          }
          if(pregunta.respCorrecta === "D"){
              return pregunta.respD;
          }
          if(pregunta.respCorrecta === "E"){
              return pregunta.respE;
          }
        },
        obtenerRespuestaUsuario(pregunta, respuestaUsuario){
          if(respuestaUsuario === "A"){
              return pregunta.respA;
          }
          if(respuestaUsuario === "B"){
              return pregunta.respB;
          }
          if(respuestaUsuario === "C"){
              return pregunta.respC;
          }
          if(respuestaUsuario === "D"){
              return pregunta.respD;
          }
          if(respuestaUsuario === "E"){
              return pregunta.respE;
          }
        },
        fetchAlumnos: function(){
          get("getAlumnos", (data) =>{
            this.alumnos = data;
          });
        },
        fetchCuestionariosPoAlumno(){
          if(this.alumno !== null){
            const data = {
              id_alumno: this.alumno.id_persona
            }
            console.log("Data", data);
            api("getCuestionariosAlumno", data, (data) => {
              this.cuestionarios = data;
              if(this.cuestionarios.length === 0){
                toastr.info("El alumno seleccionado no tiene cuestionarios asignados");
              }
            })
          }
        },
        fetchResultados(){
          const data = {
            id_alumno: this.alumno.id_persona,
            id_cuestionario: this.cuestionario.id_cuestionario,
          };
          api("resultados_alumno_x_cuestionario", data, (data) => {
            this.preguntas = data;
            this.resultadosObtenidos = true;
          })
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
