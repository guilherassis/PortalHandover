<?php
// inclusгo do arquivo de classes NuSOAP
require_once('../lib/nusoap.php');
// criaзгo de uma instвncia do servidor
$server = new soap_server;
// inicializa o suporte a WSDL
$server->configureWSDL('server.AutenticaUsuario','urn:server.AutenticaUsuario');
$server->wsdl->schemaTargetNamespace = 'urn:server.AutenticaCplus';
// registra o mйtodo a ser oferecido
$server->register('AutenticaUsuario', //nome do mйtodo
		array('user' => 'xsd:string', 'password' => 'xsd:string'), //parвmetros de entrada
		array('codeuser' => 'xsd:integer'), //parвmetros de saнda
			  'urn:server.AutenticaUsuario', //namespace
			  'urn:server.AutenticaUsuario#AutenticaUsuario', //soapaction
			  'rpc', //style
			  'encoded', //use
			  'Retorna o cуdigo do usuбrio' //documentaзгo do serviзo
);

$server->register('BuscaNomeUsuario', //nome do mйtodo
		array('codeuser' => 'xsd:integer'), //parвmetros de entrada
		array('nome' => 'xsd:string'), //parвmetros de saнda
			  'urn:server.BuscaNomeUsuario', //namespace
			  'urn:server.BuscaNomeUsuario#BuscaNomeUsuario', //soapaction
			  'rpc', //style
			  'encoded', //use
			  'Retorna o nome do usuбrio' //documentaзгo do serviзo
);

$server->register('BuscaDepartamentoUsuario', //nome do mйtodo
		array('codeuser' => 'xsd:integer'), //parвmetros de entrada
		array('depto' => 'xsd:string'), //parвmetros de saнda
			  'urn:server.BuscaNomeUsuario', //namespace
			  'urn:server.BuscaNomeUsuario#BuscaNomeUsuario', //soapaction
			  'rpc', //style
			  'encoded', //use
			  'Retorna o departamento do usuбrio' //documentaзгo do serviзo
);

$ora_user = "way";
$ora_senha = "way04orpl";
$ora_sid = "cpprd";

function AutenticaUsuario($user,$password) {
	global $ora_user,$ora_senha,$ora_sid;
	$sql = "select login.login, login.codigo, login.depto from vw_login_usuario login, tva2900 u ".
           "where usr_decode(u.login) = upper('$user') and ".
           "usr_decode(u.senha) in ('$password', upper('$password')) and ".
           "login.codigo = u.codusu and login.ativo = 'S'";
           
    $ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
    
    $sql = ociparse($ora_conecta,$sql) or die("ERRO NA ANБLISE DA CLБUSULA SQL");
    	
    $codeuser = null;

    ociexecute($sql,OCI_DEFAULT);
    $login = $codigo = $depto = "";
    while(Ocifetch($sql)){
	    $codeuser  = ociresult($sql,'CODIGO');
    }
	return $codeuser;
}

function BuscaNomeUsuario($user){
	global $ora_user,$ora_senha,$ora_sid;
	$sql = "select login.nome from vw_login_usuario login, tva2900 u  ".
           "where login.codigo = $user and login.codigo = u.codusu and login.ativo = 'S'";
           
    $ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
    
    $sql = ociparse($ora_conecta,$sql) or die("ERRO NA ANБLISE DA CLБUSULA SQL");
    	
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
           "where login.codigo = $user and login.codigo = u.codusu and login.ativo = 'S'";
           
    $ora_conecta = @ocilogon($ora_user,$ora_senha,$ora_sid);
    
    $sql = ociparse($ora_conecta,$sql) or die("ERRO NA ANБLISE DA CLБUSULA SQL");
    	
    $depto = null;

    ociexecute($sql,OCI_DEFAULT);
    $login = $codigo = $depto = "";
    while(Ocifetch($sql)){
	    $depto  = ociresult($sql,'DEPTO');
    }
	return $depto;
}

// requisiзгo para uso do serviзo
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>