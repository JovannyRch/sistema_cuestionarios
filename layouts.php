<?php

  function headerLayout(string $title = ""){
    return "
      <!DOCTYPE html>
      <html lang='en'>
      <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>$title</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css' rel='stylesheet' crossorigin='anonymous'>
        <link href='assets/estilos.css' />
       
        <script src='https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' integrity='sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==' crossorigin='anonymous' referrerpolicy='no-referrer' />
        <script src='https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js' integrity='sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src='https://code.jquery.com/jquery-3.5.1.min.js' integrity='sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=' crossorigin='anonymous'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js' integrity='sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
       
        </head>
        <script>
            function get(servicio, callback){
              $.ajax({
                    type: 'POST',
                    url: 'api.php',
                    data: {
                      servicio
                    },
                    success:  (response) => {
                      try{
                        return callback(JSON.parse(response));
                      }catch(e){
                        return callback(response);
                      }
                    } 
                  });
            }

            function api(servicio, data = {}, callback){
              $.ajax({
                    type: 'POST',
                    url: 'api.php',
                    data: {
                      servicio,
                      ...data,
                    },
                    success:  (response) => {
                      try{
                        return callback(JSON.parse(response));
                      }catch(e){
                        return callback(response);
                      }
                    } 
                  });
            }
        </script>
      <body>
    ";
  }

  function footerLayout(){
    return "
       
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
        </body>
      </html>
    ";
  }

?>