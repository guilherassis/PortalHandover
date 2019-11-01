<?php
// inclus�o do arquivo de classes NuSOAP
require_once('../lib/nusoap.php');
// cria��o de uma inst�ncia do servidor
$server = new soap_server;
// inicializa o suporte a WSDL
$server->configureWSDL('server.AutenticaCplus','urn:server.hello');
$server->wsdl->schemaTargetNamespace = 'urn:server.hello';
// registra o m�todo a ser oferecido
$server->register('AutenticaCplus', //nome do m�todo
		array('user' => 'xsd:string', 'password' => 'xsd:string'), //par�metros de entrada
		array('depto' => 'xsd:string'), //par�metros de sa�da
			  'urn:server.AutenticaCplus', //namespace
			  'urn:server.AutenticaCplus#AutenticaCplus', //soapaction
			  'rpc', //style
			  'encoded', //use
			  'Retorna a �rea do usu�rio' //documenta��o do servi�o
);

$server->register('BuscaNomeUsuario', //nome do m�todo
		array('user' => 'xsd:string'), //par�metros de entrada
		array('nome' => 'xsd:string'), //par�metros de sa�da
			  'urn:server.BuscaNomeUsuario', //namespace
			  'urn:server.BuscaNomeUsuario#BuscaNomeUsuario', //soapaction
			  'rpc', //style
			  'encoded', //use
			  'Retorna o nome do usu�rio' //documenta��o do servi�o
);

$server->register('BuscaDepartamentoUsuario', //nome do m�todo
		array('user' => 'xsd:string'), //par�metros de entrada
		array('depto' => 'xsd:string'), //par�metros de sa�da
			  'urn:server.BuscaNomeUsuario', //namespace
			  'urn:server.BuscaNomeUsuario#BuscaNomeUsuario', //soapaction
			  'rpc', //style
			  'encoded', //use
			  'Retorna o departamento do usu�rio' //documenta��o do servi�o
);

$ora_user = "way";
$ora_senha = "way04orpl";
$ora_sid = "cpprd";

function AutenticaCplus($user,$password) {
	global $ora_user,$ora_senha,$ora_sid;
	$sql = "select login.login, login.codigo, login.depto from vw_login_usuario login, tva2900 u ".
           "where usr_decode(u.login) = upper('$user') and ".
           "usr_decode(u.senha) in ('$password', upper('$password')) and ".
           "login.codigo = u.codusu and login.ativo = 'S'";
           
    $ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
    
    $sql = ociparse($ora_conecta,$sql) or die("ERRO NA AN�LISE DA CL�USULA SQL");
    	
    $depto = null;

    ociexecute($sql,OCI_DEFAULT);
    $login = $codigo = $depto = "";
    while(Ocifetch($sql)){
	    $depto  = ociresult($sql,'DEPTO');
    }
	return $depto;
}

function BuscaNomeUsuario($user){
	global $ora_user,$ora_senha,$ora_sid;
	$sql = "select login.nome from vw_login_usuario login, tva2900 u  ".
           "where login.LOGIN = upper('$user') and login.codigo = u.codusu and login.ativo = 'S'";
           
    $ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
    
    $sql = ociparse($ora_conecta,$sql) or die("ERRO NA AN�LISE DA CL�USULA SQL");
    	
    $nome = null;

    ociexecute($sql,OCI_DEFAULT);
    $login = $codigo = $depto = "";
    while(Ocifetch($sql)){
	    $nome  = ociresult($sql,'NOME');
    }
	return $nome;
}

function BuscaDepartamentoUsuario($user){
	global $ora_user,$ora_senha,$ora_sid;
	$sql = "select login.depto from vw_login_usuario login, tva2900 u  ".
           "where login.LOGIN = upper('$user') and login.codigo = u.codusu and login.ativo = 'S'";
           
    $ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
    
    $sql = ociparse($ora_conecta,$sql) or die("ERRO NA AN�LISE DA CL�USULA SQL");
    	
    $depto = null;

    ociexecute($sql,OCI_DEFAULT);
    $login = $codigo = $depto = "";
    while(Ocifetch($sql)){
	    $nome  = ociresult($sql,'DEPTO');
    }
	return $depto;
}


// requisi��o para uso do servi�o
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
