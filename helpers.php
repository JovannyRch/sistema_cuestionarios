<?php

  function checkAlert($alert)
  {
      try {
          $type = $alert["type"];
          $message = $alert["message"];
          echo "  <div class='alert alert-$type mt-2 mb-2 text-center' role='alert'>
                <strong>$message</strong>
              </div>";
      } catch (Exception $e) {
          echo "";
      }
  }

  function renderItems($items, $current)
  {
      $result = "";
      foreach ($items as $item) {
          $title = $item["title"];
          $href = $item["href"];
          $isActive = $current == $title ? "active":"";
          $result .= "
      <li class='nav-item'>
        <a class='nav-link $isActive' aria-current='page' href='$href'>$title</a>
      </li>";
      }

      return $result;
  }

  function renderNav($options = array(), $current = "")
  {
      $lis = renderItems($options, $current);
      return "
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
      <div class='container-fluid'>
        <a class='navbar-brand' href='#'>Navbar</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
          <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
          <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
            $lis
          </ul>
          <a type='button' class='btn btn-warning' href='logout.php' >Cerrar sesión</a>
        </div>
      </div>
    </nav>
    ";
  }

  
  $admin_nav_items = array(
    array( "title" => "Cuestionarios", "href" => "cuestionario_lista.php"),
    array( "title" => "Reporte alumno", "href" => "cuestionario_crear.php"),
  );

  