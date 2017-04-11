<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author g-proceso
 */
class Conexion {
       //VUE
    private $hostVUE="192.168.1.175";
    private $portVUE="5432";
    private $dbnameVUE="Solicitudes_Dev";
    private $userVUE="postgres";
    private $passwordVUE="puntocafe";
    
    //INP
    private $host="192.168.169.90";
    private $port="5432";
    private $dbname="control_bonita_inp";
    private $user="postgres";
    private $password="1npb0n1t4";
    
    public $conexion;
    public $cadena;
    
    
    public function __construct($tipo) {
           if($tipo=='VUE'){
               $this->cadena = "host='$this->hostVUE' port='$this->portVUE' dbname='$this->dbnameVUE' user='$this->userVUE' password='$this->passwordVUE'";
             $this->conexion= pg_connect($this->cadena) or die('Error');
             
             
        }else{
            $this->cadena = "host='$this->host' port='$this->port' dbname='$this->dbname' user='$this->user' password='$this->password'";
              $this->conexion= pg_connect($this->cadena) or die('Error');
        }   
        }
        public function consulta(){
     $sql="select * from vue_gateway.tn_eld_edoc_last_stat where req_no='01009988201700000169P'";
     $result = pg_query($this->conexion,$sql)or die("Error sql" . pg_last_error());                        
            $fila = pg_fetch_array($result, NULL, PGSQL_ASSOC);
            
   return $fila;
        }    
        
        
    
}
