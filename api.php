

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
      
      default:
        responseError('Servicio no encontrado:'.$servicio);
        break;
    }
} catch (\Throwable $th) {
  responseError('Error '.$th);
}
