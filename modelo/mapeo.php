<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mapeo
 *
 * @author g-proceso
 */
class mapeo {
    private $codigo;
    private $nombreDeClase;
    private $nombreMetodo;
    private $utilizacion;
    private $fechaDeResgistro;
    private $idRegistrador;
    private $fechaModificacion;
    private $idEnmendador;
    
    
    public function setCodigo($codigo){
        $this->codigo= $codigo;
    }
    public function getCodigo(){
        return $this->codigo;
    }
    public function setNombreDeClase ($nC){
        $this->nombreDeClase=$nC;
    }
    public function getNombreDeClase(){
        return $this->nombreDeClase;
    }
    public function setUtilizacion($utiliacion){
        $this->utilizacion= $utiliacion;
    }
    public function getUtilizacion(){
        return $this->utilizacion;
    }
    public function setFechaRegistro($fR){
        $this->fechaDeResgistro=$fR;
    }
    public function getFechaRegistro(){
        return$this->fechaDeResgistro;
    }
    public function setIdRegistrador($iR){
        $this->fechaDeResgistro=$iR;
        
    }
    public function getIdRegistrador(){
        return $this->idRegistrador;
    }
    public function setFechaModificacion($fM){
        $this->fechaModificacion=$fM;
    }
    public function getFechaModificacion(){
        return $this->fechaModificacion;
    }
    public function setIdEnmendador($iE){
        $this->idEnmendador=$iE;
    }
    public function getIdEnmendador(){
        return $this->idEnmendador;
    }
}
