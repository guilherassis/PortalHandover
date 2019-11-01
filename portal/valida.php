<?php
		require_once 'includes/model/dao/Conection.class.php';
        $conn = new Conection(); 
        $conn->AbreConexao();
        

if(isset($_GET['login'])){
	$codigo= $_GET['login'] ;

	$sq_verifica = mysql_query("Select COUNT(*) from handover_usuario where login='".$codigo."'");
	$verifica = mysql_fetch_row($sq_verifica);
	if($verifica[0]!=0){

		echo "false";

	}else{

		echo "true";
	}

}



if(isset($_GET['codigo_prj'])){
$codigo_prj= $_GET['codigo_prj'] ;

$sq_verifica = mysql_query("Select COUNT(*) from handover_demandas where codigo_prj='".$codigo_prj."'");
$verifica = mysql_fetch_row($sq_verifica);
if($verifica[0]!=0){

	echo "false";

}else{
	
	echo "true";
}

}


if(isset($_GET['responsavel'])){
	$responsavel= $_GET['responsavel'] ;

	$sq_verifica = mysql_query("Select COUNT(*) from handover_demandas where responsavel='".$responsavel ."'");
	$verifica = mysql_fetch_row($sq_verifica);
	if($verifica[0]!=0){

		echo "false";

	}else{

		echo "true";
	}

}

?>
