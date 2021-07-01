<?php
include './layouts.php';
include './consultas.php';
include './helpers.php';
include './sesion.php';

validarTipoUsuario('normal');


$id_cuestionario = "";
$usuario = json_encode($_SESSION["user"]["usuario"]);


if (isset($_GET["id_cuestionario"])) {
    $id_cuestionario = $_GET['id_cuestionario'];
}

?>


<?= headerLayout('Contestar cuestionario') ?>
  <?= renderNav(array(), "") ?>
  <div id="app" class="container mt-2">
    <div v-if="cuestionario === null" class="text-center">
        Cargando...
    </div>
    <div v-else>
        <div class=" d-flex justify-content-between mb-4">
            <div><h3>{{cuestionario.nom_cuestionario}}</h3></div>
            <div><h4>{{usuario.nom_persona}}</h4></div>
        </div>
       <div  v-if="cuestionario.cal_cuestionario == -1">
         <div class="d-flex justify-content-end mb-3">
           <i>{{index+1}} / {{total}}</i>
         </div>
        <div class="card">
            <div class="card-body">
              <h4 class="card-title"><b>{{index+1}}.- {{preguntaActual.pregunta}}</b></h4>
              <div class="row mt-3 d-flex justify-content-center">
              
                <div v-if="preguntaActual.respA" class="col-6">
                  <div :class="`card mb-3 ${preguntaActual.respuesta === 'A'? 'text-white bg-success': ''}`" @click="elegirRespuesta('A')">
                    <div class="card-body">
                      <h5 class="card-title">
                       <b>a)</b> {{preguntaActual.respA}}
                      </h5>
                    </div>
                  </div>
                </div>
                <div v-if="preguntaActual.respB" class="col-6">
                  <div :class="`card mb-3 ${preguntaActual.respuesta === 'B'? 'text-white bg-success': ''}`" @click="elegirRespuesta('B')">
                      <div class="card-body">
                        <h5 class="card-title">
                        <b>b)</b> {{preguntaActual.respB}}
                        </h5>
                      </div>
                    </div>
                </div>
                <div  v-if="preguntaActual.respC" class="col-6">
                  <div :class="`card mb-3 ${preguntaActual.respuesta === 'C'? 'text-white bg-success': ''}`" @click="elegirRespuesta('C')">
                    <div class="card-body">
                      <h5 class="card-title">
                      <b>c)</b> {{preguntaActual.respC}}
                      </h5>
                    </div>
                  </div>
                </div>
                <div v-if="preguntaActual.respD" class="col-6">
                  <div :class="`card mb-3 ${preguntaActual.respuesta === 'D'? 'text-white bg-success': ''}`" @click="elegirRespuesta('D')">
                      <div class="card-body">
                        <h5 class="card-title">
                        <b>d)</b> {{preguntaActual.respD}}
                        </h5>
                      </div>
                    </div>
                </div>
                <div v-if="preguntaActual.respE" class="col-6">
                      <div :class="`card mb-3 ${preguntaActual.respuesta === 'E'? 'text-white bg-success': ''}`" @click="elegirRespuesta('E')">
                          <div class="card-body">
                            <h5 class="card-title">
                            <b>e)</b> {{preguntaActual.respE}}
                            </h5>
                          </div>
                        </div>
                    </div>
              </div>
            
            </div>
          </div>
          <div class="d-flex justify-content-between mt-5">
                <button class="btn btn-primary" :disabled="index === 0" @click="prev">
                  <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                </button>

                <button class="btn btn-outline-success" @click="terminar">
                    Terminar
                </button>

                <button class="btn btn-primary" :disabled="index === total - 1" @click="next">
                  <i class="fa fa-arrow-right" aria-hidden="true"></i> 
                </button>
          </div>  
       </div>
        <div v-else>
          <div class="alert alert-warning text-center" role="alert">
            <strong>Ya has contestado este examen</strong>
          </div>
          <div class="text-center mt-5">
              <div><h4>TU CALIFICACIÓN</h4></div>
              <h2><b>{{cuestionario.cal_cuestionario}}</b></h2>
          </div>
        </div>
  
    </div>
  </div>
  <script>
  
  var app = new Vue({
      el: "#app",
      data: {
        id_cuestionario: "<?=$id_cuestionario?>",
        cuestionario: null,
        usuario: JSON.parse('<?= $usuario ?>'),
        index: 0,
        preguntaActual: null,
        preguntas: [],
        total: 0,
        calificacion: -1,
    },
      created: function(){
        this.fetchCuestionario();
      },
      methods: {
       fetchCuestionario: function(){
         if(this.id_cuestionario){
          const data = {id_cuestionario: this.id_cuestionario, id_alumno: this.usuario.id_persona};
          api("getCuestionarioAlumno", data, (data) =>{
            this.cuestionario = data;
            this.preguntas = data.preguntas.map((p) => {
              return {...p, respuesta: ''};
            });
            this.index = 0;
            this.total = this.preguntas.length;
            this.actualizarPregunta();
          })
         }else{
           toastr.error("Error");
         }
       },
       actualizarPregunta(){
         this.preguntaActual = this.preguntas[this.index];
       },
       elegirRespuesta(respuesta){
        this.preguntaActual.respuesta = respuesta;
        this.preguntas = this.preguntas.map((p) => {
          if(p.id_pregunta === this.preguntaActual.id_pregunta){
              p.respuesta = respuesta;
          } 
          return p;
        })
       },
       next: function(){
         if(this.index !== this.total - 1){
           this.index++;
           this.actualizarPregunta();
         }
       },
       prev: function(){
        if(this.index  !== 0){
           this.index--;
           this.actualizarPregunta();
         }
       },
       obtenerCalificacion: function(respuestas){
          let res = 0;
          for(const r of respuestas){
            res += r.valor;
          } 
          return res;
        },
       terminar: function(){
         const totalNoContestadas = this.preguntas.filter((p) => p.respuesta === "").length;
         if(totalNoContestadas > 0){
          toastr.warning("Conteste todas las preguntas");
          return;
        }
        const { id_ins_per_cuest } = this.cuestionario;
        const respuestas = this.preguntas.map(this.formatRespuesta);
        this.calificacion = this.obtenerCalificacion(respuestas);
        console.log("respuestas", respuestas);
        console.log("calificacion", this.calificacion);
        api("guardarRespuestas", {respuestas}, () => {
          this.actualizarCalificacion();
        });
       },
       actualizarCalificacion: function(){
        const { id_ins_per_cuest } = this.cuestionario;
        api("actualizarCalificacion", {id_ins_per_cuest, calificacion: this.calificacion}, () => {
          toastr.success("Examen finalizado con éxito!");
          this.fetchCuestionario();
        });
       },
       obtenerPuntajePorPretunta: function(){
         return Math.round(10/this.total);
       },
       formatRespuesta: function(pregunta){
         const { id_ins_per_cuest } = this.cuestionario;
         const { id_cuest_pregunta, respuesta } = pregunta;
         const isCorrect = pregunta.respCorrecta === respuesta;
         const valor = isCorrect ? this.obtenerPuntajePorPretunta() : 0;
         return {
          id_ins_per_cuest, 
          id_cuest_pregunta,
          respuesta,
          valor
         }
       }
      },
    });

   

  </script>
<?= footerLayout() ?>
<?php unset($_SESSION['alert']); ?> 
