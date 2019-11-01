<?php
	//include "../lib/nusoap.php";

	require_once("../lib/nusoap.php");
	
	$server = new soap_server;
	$server->register('hello');
	$server->register('GetLoginAuthenticate');
	$server->register('SetAtualizaQuadro');
	$server->register('get_depto');
	$ora_sid = "cplustst.world";	
	$ora_user = "way"; //USUÁRIO
	$ora_senha = "way04orpl"; //SENHA
	//$ora_sid = "cpprd";	
	
	function hello($name,$senha){
		return 'Hello ' . $name . ', sua senha é: ' . $senha;
	}
	
	
	function SetAtualizaQuadro($insRX,$insCodCid,$insDataRetorno,$insTipo,$insProduto){
		global $ora_user,$ora_senha,$ora_sid;
		
		$sql = "begin sinaliza_manutecao_rx(:insRX,:insCodCid, :insDataRetorno, :insTipo, :insProduto); end;";
		
		$ora_conecta = ocilogon($ora_user,$ora_senha,$ora_sid) or die ("erro");
		$sql = ociparse($ora_conecta,$sql) or die ("erro");
		
		OCIBindByName($sql, ":insRX", $insRX);
		OCIBindByName($sql, ":insCodCid", $insCodCid);
		OCIBindByName($sql, ":insDataRetorno", $insDataRetorno);
		OCIBindByName($sql, ":insTipo", $insTipo);	
		OCIBindByName($sql, ":insProduto", $insProduto);
	
		ociexecute($sql,OCI_DEFAULT);
		
		$committed = OCICommit($ora_conecta);
		
		ocilogoff($ora_conecta);	
		
		return "EXECUTADO";
	}	
	
	
	function GetLoginAuthenticate($user,$password,$system){
		global $ora_user,$ora_senha,$ora_sid;
		
		$usr_data = array('0','0');
		$usr_code = null;
		$sql = "select a.usr_code codusu, a.usr_login login, a.usr_name nomeusu, b.are_name area, e.rol_name perfil from OUC_USER a, ouc_area b, ouc_user_area c, " . 
		" Ouc_User_Role d, ouc_role e, ouc_system f where upper(a.usr_login) = upper('".$user."') and a.usr_md5pass = upper(way.gera_md5('".$password."')) " .
		" and c.uar_arecode = b.are_code and a.usr_code = c.uar_usrcode and a.usr_code = d.uro_usrcode and e.rol_code = d.uro_rolcode and e.rol_sys_code = f.sys_code and f.sys_initials = '".$system."'";
		
//		return $sql;

		$ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
		
		$sql = ociparse($ora_conecta,$sql);

		ociexecute($sql,OCI_DEFAULT);
		
		
		if(Ocifetch($sql)){
			$usr_data[0] = ociresult($sql,"CODUSU");
			$usr_data[1] = ociresult($sql,"LOGIN");
			$usr_data[2] = ociresult($sql,"NOMEUSU");
			$usr_data[3] = ociresult($sql,"AREA");
			$usr_data[4] = ociresult($sql,"PERFIL");
		}
		
		ocifreestatement($sql); //LIBERA DA MEMÓRIA
    	ocilogoff($ora_conecta); //DESCONECTA DO ORACLE
		return $usr_data;

	}
	
	
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>