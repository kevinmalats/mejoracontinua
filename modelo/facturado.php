<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of facturado
 *
 * @author g-proceso
 */
class facturado {
public function crearArchivo() {
$nombre_archivo = "logs.txt"; 
 
    if(file_exists($nombre_archivo))
    {
        $mensaje = "El Archivo $nombre_archivo se ha modificado";
    }
 
    else
    {
        $mensaje = "El Archivo $nombre_archivo se ha creado";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, date("d m Y H:m:s"). " ". $mensaje. "\n"))
        {
            echo "Se ha ejecutado correctamente";
        }
        else
        {
            echo "Ha habido un problema al crear el archivo";
        }
 
      
    }
    $fp = fopen($nombre_archivo, "r");
     $linea = fgets($fp);
     echo $linea;
    
    
    
  fclose($archivo);
}
  
}
