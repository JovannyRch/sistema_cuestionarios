

<?php

require 'consultas.php';

$consultas = new Consultas();
$servicio = "";

if (isset($_POST['servicio'])) {
    $servicio = $_POST['servicio'];
}else{
  responseError("Petición vacía");
}

try {
    switch ($servicio) {
      case 'crearCuestionario':
        $nom_cuestionario = getParam("nom_cuestionario");
        $id_categoria = getParam("id_categoria");
        $consultas->crearCuestionario($nom_cuestionario, $id_categoria);
        break;
      case 'getCuestionarios':
        $data = $consultas->getCuestionarios();
        response($data);
        break;
      case 'getCuestionario':
        $id_cuestionario = getParam("id_cuestionario");
        $cuestionario = $consultas->getCuestionario($id_cuestionario);
        response($cuestionario);
        break;
      case 'updateCuestionario':
        $id_cuestionario = getParam("id_cuestionario");
        $nom_cuestionario = getParam("nom_cuestionario");
        $id_categoria = getParam("id_categoria");
        $consultas->updateCuestionario($id_cuestionario, $nom_cuestionario, $id_categoria);
        break;
      case 'deleteCuestionario':
          $id_cuestionario = getParam("id_cuestionario");
          $consultas->eliminarCuestionario($id_cuestionario);
          responseSuccess("Eliminado con exito");
          break;
      case 'getCategorias':
          $data = $consultas->getCategorias();
          response($data);
          break;
      case "getPreguntas":
        $data = $consultas->getPreguntas();
        response($data);
        break;
      case "getPregunta":
        $id_pregunta = getParam("id_pregunta");
        $pregunta = $consultas->getPregunta($id_pregunta);
        response($pregunta);
        break;
      case "crearPregunta":
        $pregunta = getParam("pregunta");
        $respA = getParam("respA");
        $respB = getParam("respB");
        $respC = getParam("respC");
        $respD = getParam("respD");
        $respE = getParam("respE");
        $respCorrecta = getParam("respCorrecta");
        $consultas->crearPregunta($pregunta,$respA, $respB, $respC, $respD, $respE, $respCorrecta);
        responseSuccess("Creado con exito");
        break;
      case "updatePregunta":
          $id_pregunta = getParam("id_pregunta");
          $pregunta = getParam("pregunta");
          $respA = getParam("respA");
          $respB = getParam("respB");
          $respC = getParam("respC");
          $respD = getParam("respD");
          $respE = getParam("respE");
          $respCorrecta = getParam("respCorrecta");
          $consultas->updatePregunta($id_pregunta, $pregunta,$respA, $respB, $respC, $respD, $respE, $respCorrecta);
          responseSuccess("Creado con exito");
          break;
      case 'deletePregunta':
            $id_pregunta = getParam("id_pregunta");
            $consultas->deletePregunta($id_pregunta);
            responseSuccess("Eliminado con exito");
            break;
      case "getAlumnos":
        $alumnos = $consultas->getAlumnos();
        response($alumnos);
        break;
      case "getCuestionariosAlumno":
        $id_alumno = getParam("id_alumno");
        $cuestionarios = $consultas->getCuestionariosPorAlumno($id_alumno);
        response($cuestionarios);
        break;
      case "resultados_alumno_x_cuestionario":
        $id_alumno = getParam("id_alumno");
        $id_cuestionario = getParam("id_cuestionario");
        $resultados = $consultas->resultadoCuestionarioAlumno($id_alumno, $id_cuestionario);
        response($resultados);
        break;
      //Cuestionario_preguntas
      case "getPreguntasCuestionario":
        $id_cuestionario = getParam("id_cuestionario");
        $preguntas = $consultas->getPreguntasCuestionario($id_cuestionario);
        response($preguntas);
        break;
      default:
        responseError('Servicio no encontrado:'.$servicio)
        ;
        break;
    }
} catch (\Throwable $th) {
  responseError('Error '.$th);
}
