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
       $sql= "select distinct
					 COALESCE(b.req_no::TEXT,'No Aplica') AS req_no
					,COALESCE(b.dcm_cd::TEXT,'No Aplica') AS dcm_cd
					,COALESCE(b.rgsp_id::TEXT,'No Aplica') AS rgsp_id
					,COALESCE(b.afr_prst_cd::TEXT,'No Aplica') AS afr_prst_cd																				
				  from vue_gateway.tn_eld_edoc_last_stat as b				
				  inner join bonita.bonita_tn_eld_edoc_last_stat as c 
					on b.req_no = c.req_no
				where 1 =1
				  and b.orgz_cd ='130'			  
				  and (b.afr_prst_cd = '130')
				  and (b.ntfc_cfm_cd='12')
				  and (b.dcm_cd like '%27%' or b.dcm_cd like '%33%' or b.dcm_cd like '%19%' or b.dcm_cd like '%45%' 
				  or b.dcm_cd like '%21%' or b.dcm_cd like '%32%' or b.dcm_cd like '%10%' or b.dcm_cd like '%12%' 
				  or b.dcm_cd like '%14%' or b.dcm_cd like '%08%' or b.dcm_cd like '%42%' or b.dcm_cd like '130-006%' 
				  or b.dcm_cd like '130-040%' or b.dcm_cd like '130-044%' or b.dcm_cd like '%19%' or b.dcm_cd like '%34%'
				  or b.dcm_cd like '130-016%' or b.dcm_cd like '130-004%' or b.dcm_cd like '%31%'
				  or b.dcm_cd like '130-010%' or b.dcm_cd like '130-012%' or b.dcm_cd like '130-014%')";
				 /* and b.mdf_dt > current_date - interval '3 day'
				  and b.req_no !='16910680201400000596P' and b.req_no != '16910680201500001552P' and b.req_no !='16936452201400000208P'
				  and 'estadoBonita'=false ";*/
       
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
   private function verNumCod($req_no){
       echo $req_no;
       $result=$this->ejecutarQuery("(select a.dcm_cd as dcm_cd from vue_gateway.tn_eld_edoc_last_stat a where a.req_no = '".$req_no."' and a.orgz_cd = '130')");
       $array= pg_fetch_array($result,NULL,PGSQL_ASSOC);
       $req=$array['dcm_cd'];
        // echo $req;
       $res= substr($req, 0, -3);
       $res=$res."RES";
       echo $res;
       
       //echo $req["dcm_cd"];
       $result=$this->ejecutarQuery("(SELECT count(ORD_NO) FROM vue_gateway.tn_eld_rpsb_atr_inf WHERE REQ_NO = '".$req_no."' and use_fg='N' and ntfc_cfm_cd='12')");
       $row= pg_fetch_array($result);
       //echo $row[0];
       if($row[0]==0){
           echo "count Mal ";
       }else
           echo "numero bien ";
      $result= $this->ejecutarQuery("select aprb_id FROM vue_gateway.tn_eld_rpsb_atr_inf WHERE REQ_NO = '".$req_no."'");
      $row= pg_fetch_array($result); 
      //echo "el aprb_id es". $row["aprb_id"]." " ;
      if($row["aprb_id"]==''){
           echo "aprb Mal ";
       }  else {
           echo "aprb bien ";
       }
       try{
           $this->managerTransaction("begin");
           $this->ejecutarQuery("update vue_gateway.tn_eld_rpsb_atr_inf set ntfc_cfm_cd ='21', use_fg='S', mdf_dt=now()
			where  req_no='".$req_no."'	  
			  and  use_fg='N'
			  and  ntfc_cfm_cd='12'");
      
       
   
           $this->ejecutarQuery("select  bonita.accion_actualizar_laststat('".$req_no."', '".$res."', '320', 0, '21', '130')"); 
   
           
       } catch (Exception $ex) {
             echo "Error en el query";
             $this->managerTransaction("roolback");
       }
       $this->managerTransaction("commit");
       $this->managerTransaction("end");
       
        
   }
  private  function managerTransaction($operacion){
		if(func_num_args()==1){
			$operacion = strtolower($operacion);
			if($operacion=="begin"){
				return $this->ejecutarQuery("BEGIN WORK; ");
			}
			elseif ($operacion=="commit"){
				return $this->ejecutarQuery(" COMMIT;");
			}
			elseif ($operacion=="rollback") {
				return $this->ejecutarQuery(" ROLLBACK;");;
			}
			elseif ($operacion=="end") {
				return $this->ejecutarQuery(" END WORK;");;
			}
			else {
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
   private function ejecutarQuery($sql){
       $result= pg_query($this->objConex->conexion,$sql) or die("Error sql" . pg_last_error());
       return $result;
   }

   public function consultaLaTablaInf(){
       
       foreach ($this->objColectorTra->obtenerTramite() as $tramite){
           $this->verNumCod($tramite->getNumeroSolicitud());
       }
      
   }
   
}
