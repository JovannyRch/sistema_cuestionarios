<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('admin');
?>


<?= headerLayout('Reportes') ?>
  <?= renderNav($admin_nav_items, 'Reportes') ?>
  <div id="app" class="container mt-2 mb-5">
    <h4>Reportes</h4>
    <div class="row mt-5" v-if="page === 0">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Reporte de estadísticas globales de los cuestionario.</h4>
            <button @click="page = 1" class="btn btn-success">
              <i class="fas fa-chart-line    "></i> Ver reporte
            </button>
          </div>
        </div>
      </div>
      <div class="col-6">
      <div class="card">
          <div class="card-body">
            <h4 class="card-title">Reporte de estadísticas globales por pregunta.</h4>
            <button @click="page = 2" class="btn btn-success">
            <i class="fas fa-chart-line    "></i> Ver reporte
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="page === 1">
      
        <div class="d-flex justify-content-between">
          <h5><b>Reporte de estadísticas globales de los cuestionario</b></h5> 
          <button @click="page = 0" class="btn btn-outline-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button>
        </div>
        <div class="w-50">
          <div class="form-group">
            <label for="cuestionario">Cuestionario</label>
            <select v-model="reporteCuestionario.cuestionario" class="form-control" name="cuestionario" id="cuestionario">
              <option :value="null" disabled>Seleccione un cuestionario</option>
              <option v-for="cuestionario in cuestionarios" :value="cuestionario">{{cuestionario.nom_cuestionario}}</option>
            </select>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <div class="form-group">
                <label for="inicio">Fecha inicial</label>
                <input  v-model="reporteCuestionario.inicio" type="date"
                  class="form-control" name="inicio" id="inicio" placeholder="Seleccione una fecha de incio">
              </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <label for="fin">Fecha final</label>
                <input type="date" v-model="reporteCuestionario.fin"
                  class="form-control" name="fin" id="fin" placeholder="Seleccione una fecha de fin">
              </div>
            </div>
          </div>
          <div class="mt-3">
              <button @click="fetchReporteCuestionario" :disabled="!validarReporteCuestionario()" class="btn btn-success">Obtener reporte</button>
          </div>
        </div>
        <div v-if="resultadosCuestionario !== null" class="w-100 mt-4">
          <h5>Cuestionario: <b>{{resultadosCuestionario.cuestionario.nom_cuestionario}}</b></h5>
          <p>
            Promedio general: {{resultadosCuestionario.promedio}}
          </p>
          <table class="table table-striped  table-responsive">
            <thead class="thead-default">
              <tr>
                <th>Pregunta</th>
                <th>Respuestas</th>
                <th>Errores</th>
                <th>Aciertos</th>
                <th>Porcentaje</th>
              </tr>
              </thead>
              <tbody>
                <tr v-for="pregunta in resultadosCuestionario.preguntas">
                  <td scope="row">{{pregunta.pregunta}}</td}>
                  <td>{{pregunta.total}}</td>
                  <td>{{pregunta.errores}}</td>
                  <td>{{pregunta.aciertos}}</td>
                  <td>{{pregunta.porcentaje}}</td>
                </tr>
              </tbody>
          </table>
        </div>
    </div>
    <div v-if="page === 2">
        <div class="d-flex justify-content-between">
          <h5><b>Reporte de estadísticas globales por pregunta</b></h5> 
          <button @click="page = 0" class="btn btn-outline-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button>
        </div>
        <div class="w-100">
            <div class="form-group">
              <label for="pregunta">Pregunta</label>
              <select @change="fetchCuestionariosEnPregunta" v-model="reportePregunta.pregunta" class="form-control" name="pregunta" id="pregunta">
                <option :value="null">Todas las preguntas</option>
                <option v-for="pregunta in preguntas" :value="pregunta">{{pregunta.pregunta}}</option>
              </select>
            </div>
            <div class="form-group mt-3">
              <label for="cuestionarioPregunta">Cuestionario (*Opcional)</label>
              <select v-model="reportePregunta.cuestionario" class="form-control" name="cuestionarioPregunta" id="cuestionarioPregunta">
                <option :value="null">En todos los cuestionarios</option>
                <option v-for="cuestionario in cuestionariosPregunta" :value="cuestionario">{{cuestionario.nom_cuestionario}}</option>
              </select>
            </div>
            <div class="mt-3">
              <button @click="fetchReportePregunta"  class="btn btn-success">Obtener reporte</button>
            </div>
          </div>
          <div v-if="titleReporte" class="mt-4">
              <h4>{{titleReporte}}</h4>
              <table class="table table-striped  table-responsive mt-3">
              <thead class="thead-default">
                  <tr>
                    <th>Pregunta</th>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                    <th>Respuestas</th>
                    <th>Errores</th>
                    <th>Aciertos</th>
                    <th>Porcentaje</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr v-for="pregunta in resultadosPregunta">
                      <td scope="row">{{pregunta.pregunta}}</td}>
                      <td>{{pregunta.a}}</td>
                      <td>{{pregunta.b}}</td>
                      <td>{{pregunta.c}}</td>
                      <td>{{pregunta.d}}</td>
                      <td>{{pregunta.e}}</td>
                      <td>{{pregunta.total}}</td>
                      <td>{{pregunta.errores}}</td>
                      <td>{{pregunta.aciertos}}</td>
                      <td>{{pregunta.porcentaje}}</td>
                    </tr>
                  </tbody>
              </table>
          </div>
      </div>
        
  
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        page: 0,
        cuestionarios: [],
        preguntas: [],
        reporteCuestionario: {
          cuestionario: null,
          inicio: "",
          fin: "",
        },
        reportePregunta: {
          pregunta: null,
          cuestionario: null,
        },
        cuestionariosPregunta: [],
        resultadosPregunta: null,
        resultadosCuestionario: null,
        titleReporte: "",
      },
      created: function(){
        this.fetchCuestionarios();
        this.fetchPreguntas();
      },
      methods: {
        fetchCuestionarios: function(){
          get("getCuestionarios", (data) => {
            this.cuestionarios = data;
          })
        },
        fetchPreguntas: function(){
          get("getPreguntas", (data) => {
            this.preguntas = data;
          })
        },
        fetchCuestionariosEnPregunta: function(){
          const data = {
            id_pregunta: this.reportePregunta.pregunta.id_pregunta,
          };
          this.reportePregunta.cuestionario = null;
          api("getCuestionariosConPregunta",data, (data) => {
            this.cuestionariosPregunta = data;
            if(data.length === 0){
              toastr.warning("La pregunta no está enscrita en ningún cuestionario");
            }
          })
        }, 
        validarReporteCuestionario: function(){
          const { cuestionario, inicio, fin } = this.reporteCuestionario;
          if( cuestionario === null || inicio === "" || fin === "" ){
            return false;
          }
          return true;
        },
        fetchReporteCuestionario: function(){
          const { cuestionario, inicio, fin } = this.reporteCuestionario;
          const data = {
            id_cuestionario: cuestionario.id_cuestionario,
            inicio,
            fin,
          };
          api("reporteCuestionario", data, (data) => {
            const promedio = Number(data.promedio).toFixed(2);
            const reporte = this.getReportePreguntasEnCuestionario(data.preguntas);
            this.resultadosCuestionario = {
              cuestionario: this.reporteCuestionario.cuestionario,
              promedio,
              preguntas: reporte,
            }
            console.log(this.resultadosCuestionario);
          })
        },

        getReportePreguntasEnCuestionario: function(preguntas){
          const res = preguntas.map((p) => {
            const total = p.respuestas.length;
            const errores = this.getCantidadErrores(p.respuestas, p.respCorrecta);
            const aciertos = total - errores;
            return {
              pregunta: p.pregunta,
              total,
              errores, 
              aciertos,
              porcentaje: `${((aciertos * 100) /total).toFixed(2)}%`
            }
          })
          return res;
        },
        getCantidadErrores: function(respuestas, correcta){
          return respuestas.filter((r) => r.respuesta !== correcta).length;
        },
        getCantidadRespuesta: function(respuestas, respuesta){
          return respuestas.filter((r) => r.respuesta === respuesta).length;
        },
        getReporteRespuestas: function(respuestas, correcta){

        },
        fetchReportePregunta: function(){
          this.resultadosPregunta = null;
          const id_pregunta = this.reportePregunta.pregunta?.id_pregunta || "";
          const id_cuestionario = this.reportePregunta.cuestionario?.id_cuestionario || "";
          const data = {
            id_pregunta,
            id_cuestionario
          };
          api("getReportePregunta", data, (data) => {
            this.resultadosPregunta = this.formatReportePregunta(data);
            if(!id_pregunta && !id_cuestionario){
              this.titleReporte = "Reporte global de todas las preguntas";
            }else{
              if(this.reportePregunta.cuestionario === null){
                this.titleReporte = `En todos los cuestionarios`;
              }else{
                this.titleReporte = `En el cuestionario '${this.reportePregunta.cuestionario.nom_cuestionario}'`;
              }
            }
          })
        },
        formatReportePregunta: function(preguntas){
            const res = preguntas.map((p) => {
              const total = p.respuestas.length;
              const errores = this.getCantidadErrores(p.respuestas, p.respCorrecta);
              const aciertos = total - errores;
              return {
                pregunta: p.pregunta,
                total,
                errores, 
                aciertos,
                a: this.getCantidadRespuesta(p.respuestas, "A"),
                b: this.getCantidadRespuesta(p.respuestas, "B"),
                c: this.getCantidadRespuesta(p.respuestas, "C"),
                d: this.getCantidadRespuesta(p.respuestas, "D"),
                e: this.getCantidadRespuesta(p.respuestas, "E"),
                porcentaje: total == 0? "--": `${((aciertos * 100) /total).toFixed(2)}%`
              }
            });

            return res;
        }
      }
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
