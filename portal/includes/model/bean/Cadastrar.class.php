<?php

class Cadastrar{

	var $id;
	var $responsavel;
	var $tipo;
	var $codigo_prj;
	var $nome_prj;
	var $status;
	var $data_status;
	var $data_release;
	var $objetivo;
	var $proximos_passos;
	var $progresso;
	var $pts_atencao;
	var $operacao;
	var $desenvolvimento;
	var $status_entregaveis;
	var $status_entregaveis_v2;
	var $sistemas_criticos;
	var $finalizada;
	var $frenteTrabalho;
	var $requisitosFuncionais;
	var $status_gerencial;
	var $indice;
	var $ultima_alteracao;

	
	

	function getId(){
		return $this -> id;
	}
	function setId($valor){
		$this -> id = $valor;
	}



	function getResponsavel(){
		return $this -> responsavel;
	}
	function setResponsavel($valor){
		$this -> responsavel = $valor;
	}
	function getTipo(){
		return $this -> tipo;
	}
	function setTipo($valor){
		$this -> tipo = $valor;
	}

	function getCodigo_prj(){
		return $this -> codigo_prj;
	}
	function setCodigo_prj($valor){
		$this -> codigo_prj = $valor;	
	}

	function getNome_prj(){
		return $this -> nome_prj;
	}
	function setNome_prj($valor){
		$this -> nome_prj = $valor;	
	}
	
	
	function getStatus(){
		return $this -> status;
	}
	function setStatus($valor){
		$this -> status = $valor;	
	}


	function getData_status(){
		return $this -> data_status;
	}
	function setData_status($valor){
		
		$this -> data_status = $valor;	
	}
	

	function getData_release(){
		return $this -> data_release;
	}
	function setData_release($valor){
		$this -> data_release = $valor;	
	}

	function getObjetivo(){
		return $this -> objetivo;
	}
	function setObjetivo($valor){
		$this -> objetivo = $valor;	
	}

	function getProximos_passos(){
		return $this -> proximos_passos;
	}
	function setProximos_passos($valor){
		$this ->  proximos_passos= $valor;
	}
	
	function getProgresso(){
		return $this -> progresso;
	}
	function setProgresso($valor){
		$this ->  progresso= $valor;
	}
	
	
	function getPts_atencao(){
		return $this -> pts_atencao;
	}
	function setPts_atencao($valor){
		$this ->  pts_atencao= $valor;
	}
	
	function getOperacao(){
		return $this -> operacao;
	}
	function setOperacao($valor){
		$this ->  operacao= $valor;
	}
	
	function getDesenvolvimento(){
		return $this -> desenvolvimento;
	}
	function setDesenvolvimento($valor){
		$this ->  desenvolvimento= $valor;
	}
	
	function getStatus_entregaveis(){
		return $this -> status_entregaveis;
	}
	function setStatus_entregaveis($valor){
		$this ->  status_entregaveis= $valor;
	}
	
	function getStatus_entregaveis_v2(){
		return $this -> status_entregaveis_v2;
	}
	function setStatus_entregaveis_v2($valor){
		$this ->  status_entregaveis_v2= $valor;
	}

	function getSistemas_criticos(){
		return $this -> sistemas_criticos;
	}
	function setSistemas_criticos($valor){
		$this ->  sistemas_criticos= $valor;
	}
	
	function getFinalizada(){
		return $this -> finalizada;
	}
	function setFinalizada($valor){
		$this -> finalizada = $valor;	
	}

	function getFrenteTrabalho(){
		return $this -> frenteTrabalho;
	}
	function setFrenteTrabalho($valor){
		$this -> frenteTrabalho = $valor;	
	}

	function getRequisitosFuncionais(){
		return $this -> requisitosFuncionais;
	}
	function setRequisitosFuncionais($valor){
		$this -> requisitosFuncionais = $valor;	
	}

	function getIndice(){
		return $this -> indice;
	}
	function setIndice($valor){
		$this -> indice = $valor;	
	}
	
	function getStatus_Gerencial(){
		return $this -> status_gerencial;
	}
	function setStatus_Gerencial($valor){
		$this -> status_gerencial = $valor;	
	}

	function getUltima_alteracao(){
		return $this -> ultima_alteracao;
	}
	function setUltima_alteracao($valor){
		$this -> ultima_alteracao = $valor;	
	}
	

	
	


	
}

?>