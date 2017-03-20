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
        
       require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/PruebaKM/Database/conexion.php';
        $con= new Conexion("VUE");
        $fila=  count($con->consulta());
        $resultado= $con->consulta() ;
        ?>
       <!-- <table>
            <tr>
                <td><?php for ( $i=0; $i<$fila; $i++ ){?>
            <tr>
                <?php echo $resultado[$i];?>
            </tr>
                    
               <?php }?>
            </tr>
        </table>-->
        <?php for ( $i=0; $i<$fila; $i++ ){
            //$resultado[$i]="Bad bunny ";
            //echo $resultado[$i];
        }
        ?>
    </body>
</html>
