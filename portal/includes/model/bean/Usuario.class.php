<?php

class Usuario{

	var $id;
	var $nome;
	var $email;
	var $login;
	var $senha;
        var $ativo;
        var $perfil;
        var $ultima_alteracao;
	
	//Id
	function getId(){
		return $this -> id;
	}
	function setId($valor){
		$this -> id = $valor;	
	}
	function getUltimaModificacao(){
		return $this -> ultima_alteracao;
	}
	function setUltimaModificacao($valor){
		$this -> ultima_alteracao = $valor;	
	}
	function getPerfil(){
		return $this -> perfil;
	}
	function setPerfil($valor){
		$this -> perfil = $valor;	
	}
	function getAtivo(){
		return $this -> ativo;
	}
	function setAtivo($valor){
		$this -> ativo = $valor;	
	}
	
	//Nome
	function getNome(){
		return $this -> nome;
	}
	function setNome($valor){
		$this -> nome = $valor;	
	}
	
	//Email
	function getEmail(){
		return $this -> email;
	}
	function setEmail($valor){
		$this -> email = $valor;	
	}
	
	//Login
	function getLogin(){
		return $this -> login;
	}
	function setLogin($valor){
		$this -> login = $valor;	
	}
		
	//Senha
	function getSenha(){
		return $this -> senha;
	}
	function setSenha($valor){
		$this -> senha = $valor;	
	}

}

?>