<?php

  class  Conection{

    var $ip = "localhost";
    var $user = "root";
    var $pass = "usbw";
    var $database = "bd_handover";
  	


    
  	/*
  	var $ip= "localhost";
  var $user = "root";
  	var $pass = "usbw";
  	var $database = "sicoof";
  	*/
  	function AbreConexao() {
  	
  		$this->conn = mysql_connect ($this->ip,$this->user,$this->pass); // aqui declaramos a var conn como variável da classe
  		mysql_select_db ( $this->database, $this->conn);
  		mysql_set_charset('utf8',$this->conn);
  		// esse "$this->" ele e utilizado para referenciar uma variável da classe
  	
  	}
  	function FechaConexao() {
  		mysql_close ($this->conn); // aqui fecho a conexão se baseando na variável acima declarada
  	}
  }
  
?>
