<?php

class Relatorio{


	var $data_inicio;
	var $data_fim;
	
	
	

	function getDataInicio(){
		return $this -> data_inicio;
	}
	function setDataInicio($valor){
		$this ->  data_inicio= $valor;
	}
	
	function getDataFim(){
		return $this -> data_fim;
	}
	function setDataFim($valor){
		$this ->  data_fim= $valor;
	}
	
	
	
	
}

?>