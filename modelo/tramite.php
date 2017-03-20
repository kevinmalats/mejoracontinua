<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.tion 
 */

/**
 * Description of tramite
 *
 * @author g-proceso
 */
class tramite {
    private $numeroSoilicitud;
    private $codigoDocumento;
    private $idRegistrador;
    private $codigoEstadoTramite;
    
    public function setNumeroSolicitud($ns){
        $this->numeroSoilicitud=$ns;
    }
    public function getNumeroSolicitud(){
        return $this->numeroSoilicitud;;
    }
    public function setCodigoDocumento($cd){
        $this->codigoDocumento= $cd;
    }
    public function getCodigoDocumento(){
        return $this->codigoDocumento;
    }
    public function setIdRegistrador($ir){
        $this->idRegistrador=$ir;
    }
    public function getIdRegistrador(){
        return $this->idRegistrador;
    }
    public function setCodigoEstadoTramite($param) {
        $this->codigoEstadoTramite=$param;
        
    }
    public function getCodigoEstadoTramite() {
        return $this->codigoEstadoTramite;
        
    }
}
