<?php
		$ora_user = "oitvucusr"; //USUÁRIO
		$ora_senha = "sydle"; //SENHA
		$ora_sid = "cplustst.world";	
		$user = 'admcallback';
		$password = '88411';
		
		$sql = "select a.usr_code USR_CODE from OUC_USER a where a.usr_login = '".$user."' and a.usr_md5pass = upper(way.gera_md5('".$password."'))";
		
		//"select usr_code from ITG_USER a where a.usr_login = '".$user."' and a.usr_password = '".$password."' ";
		
		$ora_conecta = ocilogon($ora_user,$ora_senha,$ora_sid);
		
		$sql = ociparse($ora_conecta,$sql);
		
		ociexecute($sql,OCI_DEFAULT);
		
		
		if(Ocifetch($sql)){
			$usr_code = ociresult($sql,"USR_CODE");
		}
		
		ocifreestatement($sql); //LIBERA DA MEMÓRIA
    	ocilogoff($ora_conecta); //DESCONECTA DO ORACLE
?>		