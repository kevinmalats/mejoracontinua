<?php
 require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/MejoraContinua/Database/conexion.php';
 require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/MejoraContinua/modelo/tramite.php';
  require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/MejoraContinua/modelo/colectorTramite.php';
 /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funciones
 *
 * @author g-proceso
 */
class funciones {
    private $objTramite;
    private $objConex;
    private $objColectorTra;
    public function getColectorTramite(){
        return $this->objColectorTra;
    }

        public function consultaTramite(){
       $this->objColectorTra= new colectorTramite();
       $this->objConex= new Conexion("VUE");
       $sql= "select a.dcm_cd, a.req_no, a.rgsp_id, a.afr_prst_cd from vue_gateway.tn_eld_edoc_last_stat a ";
       
       $result= pg_query($this->objConex->conexion,$sql) or die("Error sql" . pg_last_error());
       while($row= pg_fetch_array($result, NULL, PGSQL_ASSOC)){
          
           $this->objTramite=  new tramite();  
             $this->objTramite->setCodigoDocumento($row["dcm_cd"]);
             $this->objTramite->setNumeroSolicitud($row["req_no"]);
             $this->objTramite->setIdRegistrador($row["rgsp_id"]);
             $this->objTramite->setCodigoEstadoTramite($row["afr_prst_cd"]);
             
           $this->objColectorTra->añadirTramite($this->objTramite);
       }
 
        
       
   }
   
}
