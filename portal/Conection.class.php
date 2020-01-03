<?php

    
   function AbreConexao() {

   	$ip = "localhost";
   	$user = "root";
   	$pass = "usbw";
   	$database = "bd_handover";


 
   	$charset = "utf8";
      $link =  mysqli_connect($ip,$user,$pass, $database) or die(mysqli_connect_error($link)); 
        mysqli_set_charset($link, $charset);
        return $link;
   }

  function FechaConexao($link) {
     mysqli_close($link) or die (mysqli_error($link));
  } 
 
  function DBEscape($dados){
  	
  	$link = AbreConexao();
  	
  	$dados = mysqli_real_escape_string($link,$dados);
  	
  	FechaConexao($link);
  }
  
?>
