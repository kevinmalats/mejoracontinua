<?php
 require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/PruebaKM/Database/conexion.php';
 require_once filter_input(INPUT_SERVER, "DOCUMENT_ROOT").'/PruebaKM/modelo/mapeo.php';
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
    private $objMapeo;
    private $objConex;
    
   public function devuelveMapeo(){
       $objMapeo=  new mapeo();
       $objConex= new Conexion("Vue");
       $codigo;
       $sql= "select a.dcm_cd from vue_gateway.tn_eld_edoc_last_stat a where a.req_no = c_req_no.req_no and a.orgz_cd = _orgz_cd";
        
       
   }
   
}
