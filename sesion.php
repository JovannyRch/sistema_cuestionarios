<?php

session_start();

function validarUsuarioNormal(){
  validarSesion();
  $isValid = $_SESSION["user"]["tipo"] == "normal";
  if(!$isValid){
    header("Location: login.php");
  }
}

function validarUsuarioAdmin(){
  validarSesion();
  $isValid = $_SESSION["user"]["tipo"] == "admin";
  if(!$isValid){
    header("Location: login.php");
  }
}


function validarSesion(){
  $isSessionActive = isset($_SESSION["user"]);
  if(!$isSessionActive){
    header("Location: login.php");
  }
}

function cerrarSesion(){
  unset($_SESSION['user']); 
  session_destroy();
  header("Location: login.php");
}