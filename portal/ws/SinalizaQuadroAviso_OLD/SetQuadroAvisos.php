<?php
	//include "../lib/nusoap.php";

	require_once("../lib/nusoap.php");
	
	$server = new soap_server;
	$server->register('hello');
	$server->register('GetLoginAuthenticate');
	$server->register('SetAtualizaQuadro');
	$server->register('get_depto');
	
	// inicializa o suporte a WSDL
	$server->configureWSDL('server.AtualizaQuadros','urn:server.AtualizaQuadros');
	$server->wsdl->schemaTargetNamespace = 'urn:server.AtualizaQuadros';
	// registra o mйtodo a ser oferecido
	$server->register('SetAtualizaQuadro', //nome do mйtodo
			array('rx' => 'xsd:string', 
				  'codcid' => 'xsd:integer', 
				  'retorno' => 'xsd:string', 
				  'tipo' => 'xsd:string',
				  'produto' => 'xsd:integer'), //parвmetros de entrada
			array('situacao' => 'xsd:integer'), //parвmetros de saнda
			  	  'urn:server.SetAtualizaQuadro', //namespace
			  	  'urn:server.SetAtualizaQuadro#SetAtualizaQuadro', //soapaction
			  	  'rpc', //style
			  	  'encoded', //use
			  	  'Sinaliza Problema de RX no Quadro de Avisos' //documentaзгo do serviзo
	);	

	
	$server->register('hello', //nome do mйtodo
			array('nome' => 'xsd:string','senha' => 'xsd:string'), //parвmetros de entrada
			array('saida' => 'xsd:string'), //parвmetros de saнda
			  	  'urn:server.hello', //namespace
			  	  'urn:server.hello#hello', //soapaction
			  	  'rpc', //style
			  	  'encoded', //use
			  	  'Metodo de teste de invocaзгo' //documentaзгo do serviзo
	);	
	
	$ora_sid = "cpprd";
	$ora_user = "way";
	$ora_senha = "way04orpl";
	
	function hello($name,$senha){
		return 'Hello ' . $name . ', sua senha й: ' . $senha;
	}
	
	
	function SetAtualizaQuadro($insRX,$insCodCid,$insDataRetorno,$insTipo,$insProduto){
		global $ora_user,$ora_senha,$ora_sid;
		
		$sql = "begin sinaliza_manutecao_rx(:insRX,:insCodCid, :insDataRetorno, :insTipo, :insProduto); end;";

		$ora_conecta = ocilogon($ora_user,$ora_senha,$ora_sid);

		$sql = ociparse($ora_conecta,$sql);
		
		OCIBindByName($sql, ":insRX", $insRX);
		OCIBindByName($sql, ":insCodCid", $insCodCid);
		OCIBindByName($sql, ":insDataRetorno", $insDataRetorno);
		OCIBindByName($sql, ":insTipo", $insTipo);	
		OCIBindByName($sql, ":insProduto", $insProduto);
	
		$rst = ociexecute($sql,OCI_DEFAULT);
		
		$committed = OCICommit($ora_conecta);
		
		ocilogoff($ora_conecta);	
		
		if (!$rst){
			return 0;
		}else{
			return 1;
		}
	}	
	
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>