<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
       require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/MejoraContinua/modelo/funciones.php';
      $objFunciones= new funciones();
      $objFunciones->consultaTramite();
      foreach ($objFunciones->getColectorTramite()->obtenerTramite()as $tramite ){
          echo "codigo ".$tramite->getCodigoDocumento();
      }
 ?>
    </body>
</html>
