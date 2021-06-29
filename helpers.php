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
