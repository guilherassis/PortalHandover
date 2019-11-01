<?php

	require_once("../lib/nusoap.php");
	$server = new soap_server;
	$server->register('hello');
	$server->register('GetLoginAuthenticate');
	$server->register('get_depto');
	$ora_user = "oitvucusr"; //USUÁRIO
	$ora_senha = "sydle"; //SENHA
	$ora_sid = "cpprd";	
	/*$ora_user = "way"; //USUÁRIO
	$ora_senha = "way04orpl"; //SENHA
	$ora_sid = "cpprd";	*/
	
	function hello($name,$senha){
		return 'Hello ' . $name . ', sua senha é: ' . $senha;
	}
	
	function GetLoginAuthenticate($user,$password,$system){
		global $ora_user,$ora_senha,$ora_sid;
		
		$usr_data = array('0','0');
		$usr_code = null;
				$sql = "select a.usr_code codusu, a.usr_login login, a.usr_name nomeusu, b.are_name area, e.rol_name perfil from OUC_USER a, ouc_area b, ouc_user_area c, " . 
		" Ouc_User_Role d, ouc_role e, ouc_system f where upper(a.usr_login) = upper('".$user."') and a.usr_md5pass = upper(way.gera_md5('".$password."')) " .
		" and c.uar_arecode = b.are_code and a.usr_code = c.uar_usrcode and a.usr_code = d.uro_usrcode and e.rol_code = d.uro_rolcode and e.rol_sys_code = f.sys_code and f.sys_initials = '".$system."'" ;

/*		$sql = "select a.usr_code codusu, a.usr_login login, a.usr_name nomeusu, b.are_name area, e.rol_name perfil from OUC_USER a, ouc_area b, ouc_user_area c, " . 
		" Ouc_User_Role d, ouc_role e, ouc_system f where upper(a.usr_login) = upper('".$user."') and a.usr_md5pass = upper(way.gera_md5('".$password."')) " .
		" and c.uar_arecode = b.are_code and a.usr_code = c.uar_usrcode and a.usr_code = d.uro_usrcode and e.rol_code = d.uro_rolcode and e.rol_sys_code = f.sys_code and f.sys_initials = '".$system."' and b.are_name like '%".$system."%'";*/

		
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
	
	function get_depto($user){
		global $ora_user,$ora_senha,$ora_sid;

		$are_name = null;
		$sql = "select b.are_name from ouc_user_area c, ouc_area b where c.uar_arecode = b.are_code and c.uar_usrcode = " . $user;
		
		$ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
		
		$sql = ociparse($ora_conecta,$sql);

		ociexecute($sql,OCI_DEFAULT);
		
		
		if(Ocifetch($sql)){
			$are_name = ociresult($sql,"ARE_NAME");
		}
		
		ocifreestatement($sql); //LIBERA DA MEMÓRIA
    	ocilogoff($ora_conecta); //DESCONECTA DO ORACLE
		return $are_name;

	}	
	
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>