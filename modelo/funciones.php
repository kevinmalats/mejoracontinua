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
                                  
                                
				  and (b.dcm_cd like '%001%' or b.dcm_cd like '%33%' or b.dcm_cd like '%19%' or b.dcm_cd like '%45%' 
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
   public function consultarTramiteRegistro(){
       $this->objColectorTra= new colectorTramite();
       $this->objConex= new Conexion("VUE");
       $sql="SELECT  distinct
					 COALESCE(b.req_no::TEXT,'No Aplica') AS req_no
					,COALESCE(b.dcm_cd::TEXT,'No Aplica') AS dcm_cd
					,COALESCE(b.rgsp_id::TEXT,'No Aplica') AS rgsp_id
					,COALESCE(b.afr_prst_cd::TEXT,'No Aplica') AS afr_prst_cd																				
				  from vue_gateway.tn_eld_edoc_last_stat as b				
				  inner join bonita.bonita_tn_eld_edoc_last_stat as c 
				  on b.req_no = c.req_no
				  inner join vue_gateway.tn_inp_016 a				
					on a.req_no = c.req_no				
				where 1 =1
				  and b.orgz_cd ='130'			  
				  and (b.afr_prst_cd = '210' or b.afr_prst_cd = '420')
				  and (b.ntfc_cfm_cd='22' or b.ntfc_cfm_cd='12')
				  and (a.ctft_no is not null) and (a.ctft_eftv_stdt is not null) and (a.ctft_eftv_finl_de is not null)
				  and b.mdf_dt > current_date - interval '90 day'
				  and \"estadoBonita\"=false";
       
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
   
       $result=$this->ejecutarQuery("(select a.dcm_cd as dcm_cd from vue_gateway.tn_eld_edoc_last_stat a where a.req_no = '".$req_no."' and a.orgz_cd = '130')");
       $array= pg_fetch_array($result,NULL,PGSQL_ASSOC);
       $req=$array['dcm_cd'];
        // echo $req;
       $res= substr($req, 0, -3);
       $res=$res."RES";
      // echo $res;
       
       //echo $req["dcm_cd"];
       $result=$this->ejecutarQuery("(SELECT count(ORD_NO) FROM vue_gateway.tn_eld_rpsb_atr_inf WHERE REQ_NO = '".$req_no."' and use_fg='N' and ntfc_cfm_cd='12')");
       $row= pg_fetch_array($result);
       //echo $row[0];
       if($row[0]!=1){
           echo "count Mal ";
           $mensaje="Dos firmas para este documento #".$req_no;
           $asunto="mensaje de error";
           $this->enviarMail($mensaje, $asunto);
           return;
       }else
           echo "numero bien ";
      /*$result= $this->ejecutarQuery("select aprb_id FROM vue_gateway.tn_eld_rpsb_atr_inf WHERE REQ_NO = '".$req_no."'");
      $row= pg_fetch_array($result); 
      //echo "el aprb_id es". $row["aprb_id"]." " ;
      if($row["aprb_id"]==''){
           echo "aprb Mal ";
           $mensaje="El campo aprb_id esta vacio en el documento #".$req_no;
           $asunto="mensaje de error";
           $this->enviarMail($mensaje, $asunto);
           return;
       }  else {
           echo "aprb bien ";
       }*/
       if($res=='130-016-RES'){
          $result=  $this->ejecutarQuery("select ctft_no  from vue_gateway.tn_inp_016 where req_no=c_req_no.req_no");
           $secuencial=  pg_fetch_array($result);
           if($secuencial=='S'){
               $result=  $this->ejecutarQuery("select a.dcm_type_nm from vue_gateway.tn_inp_016 a where a.req_no = c_req_no.req_no");
               $tipo=  pg_fetch_array($result);
               if($tipo=='Nuevo'){
                   $sql="UPDATE vue_gateway.tn_inp_016 
					set 
						ctft_no = 'INP-R'||TRIM(to_char(nextval('sec_codigoINP016'), '000000'))
						,CTFT_ISS_DE = NOW ()
						,CTFT_EFTV_STDT = NOW ()
						,CTFT_EFTV_FINL_DE = now() + INTERVAL '5 years' 					
					WHERE req_no = '".$req_no."'";
                   $result=  $this->ejecutarQuery($sql);
                   
               }else{
                    $sql="UPDATE vue_gateway.tn_inp_016 
					set 
						ctft_no = 'INP-R'||TRIM(to_char(nextval('sec_codigoINP016'), '000000'))
						,CTFT_ISS_DE = NOW () 					
					WHERE req_no  = '".$req_no."'";
                   $result=  $this->ejecutarQuery($sql);
               }
           }
       }
       $verificar=true;// variable que sirve como bandera para saber si hacer el roolback o el return en el try catch
                for ($i=0; $i<7;$i++){   
      echo "desconecta";
           print str_pad('',409676)."\n";
    
   
              usleep(3000000);
      }
       try{
           $this->managerTransaction("begin");
          //echo $req_no;
          $sql="update vue_gateway.tn_eld_rpsb_atr_inf set ntfc_cfm_cd ='21', use_fg='S', mdf_dt=now()
			where  req_no='".$req_no."'	  
			  and  use_fg='N'
			  and  ntfc_cfm_cd='12'";
          
       
           $result=$this->ejecutarQuery($sql);
           //$result=FALSE;
           if($result==false){
               $verificar=  FALSE;
           throw new Exception("Existio un error, provocado al actualizar la tabla en los campos use_fg y ntfc",1); 
           }
   
                
           $result=$this->ejecutarQuery("select  bonita.accion_actualizar_laststat('".$req_no."', '".$res."', '320', 0, '21', '130')"); 
           //$result=FALSE;
   
           if($result==false){
           throw new Exception("Existio un error, provocado",0); }
           
          $this->managerTransaction("commit");
         $this->managerTransaction("end");   
       } catch (Exception $ex) {
           echo "Error en el query ".$ex;
             for ($i=0; $i<7;$i++){   
                       echo "conecta";
                       print str_pad('',409676)."\n";
                        usleep(3000000);
                   }
             
               $mensaje="Se cayo la transaccion al actualizar datos con el documento #".$req_no;
           $asunto="mensaje de error";
           $this->enviarMail($mensaje, $asunto);
             if($verificar){
                 echo"roolback";
             $this->managerTransaction("roolback");
             
             return;
             
             }
             else{
                 "return";
                 return;
             }
    
            
           
       }
       if($res=='130-021-RES'or $res=='130-016-RES' or $res=='130-019-RES'){
           echo "Entro a ucp";
           //$this->ejecutarQuery("select insertar_AUCP_INP('".$req_no."')");
       }
       $this->ejecutarQuery("select bonita.accion_revocar_130xxx('".$req_no."','SYSTEM', 'SYSTEM')");
       echo "Exito en la transaccion $req_no";
       
       $this->ejecutarQuery("update bonita.bonita_tn_eld_edoc_last_stat d  set \"estadoAprobacion\" = false 
		where d.codigo in (
					select a.codigo
					FROM 					
						bonita.bonita_tn_eld_edoc_last_stat as a							
					where				  
						a.\"estadoBonita\"=FALSE
						and a.\"estadoAprobacion\"=true
						AND a.codigo = (select max(k.codigo) from bonita.bonita_tn_eld_edoc_last_stat k  where k.req_no='".$req_no."')
						order by a.codigo desc
					)");
        
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
       try {
       $result= pg_query($this->objConex->conexion,$sql) ;//or die("Error sql" . pg_last_error());
       if($result==false){
       throw new Exception("Existio un error,al conectarse a la base de datos, se intentara conectar nuevamente",1); 
       }
       
       } catch (Exception $ex) {
           echo $ex;
           $this->objConex= new Conexion("VUE");
       }    
       return $result;
   }

   public function consultaLaTablaInf(){
       $this->managerTransaction("commit");
       
       //echo "CODIGO A ENVIAR".$this->objColectorTra->obtenerTramite()->offsetGet(1)->getNumeroSolicitud();
      // $this->verNumCod( $this->objColectorTra->obtenerTramite()->offsetGet(1)->getNumeroSolicitud());
       foreach ($this->objColectorTra->obtenerTramite() as $tramite){
           echo "CODIGO A ENVIAR".$tramite->getNumeroSolicitud();
           $this->verNumCod($tramite->getNumeroSolicitud());
       }
      
   }
   private function enviarMail($mensaje, $asunto){
       mail('ken_1721@hotmail.es', $asunto, $mensaje);
   }
   
}
