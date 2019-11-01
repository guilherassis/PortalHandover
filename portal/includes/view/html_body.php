<?php

session_start();

class HtmlBody {

    function htmlHeaderAdmin() {
    	$pagina = $_SERVER['PHP_SELF'];
    	$pagina = explode("/", $pagina);
    	$painel="";
    	$usuario="";
    	$relatorio="";
      $extracao="";
    	$cadastrar="";
    	if($pagina[2]=="painel.php"){$painel='class="active"';}
    	if($pagina[2]=="cadastrar.php"){$cadastrar='class="active"';}
    	if($pagina[2]=="usuario_manter.php"){$usuario='class="active"';}
    	if($pagina[2]=="relatorios.php"){$relatorio='active';}
      if($pagina[2]=="extracao.php"){$extracao='active';}
        echo '
       <!DOCTYPE html>
<html lang="br">
  <head>
      <link rel="shortcut icon" type="image/x-icon" href="img/controle.png" />
    <meta charset="utf-8" />
    <center><title>PORTAL HANDOVER</title></center>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Guilherme Assis">
    
<script src="js/lib/jquery-1.9.1.js"></script>
    <script src="js/lib/ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/lib/ui/jquery.ui.datepicker-pt-BR.js"></script>
    <script type="text/javascript" src="js/lib/highlight.pack.js"></script>
    <script type="text/javascript" src="js/lib/tabifier.js"></script>
    <script src="js/lib/js.js"></script>
    <script src="js/lib/jPages.js"></script>
    <script src="js/lib/jquery.validate.js"></script>
    
    <script src="js/lib/bootstrap.js"></script>
     <script src="js/lib/jquery.maskedinput-1.3.js"></script>


    
  
    <!-- Le styles -->
     
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="css/themes/base/jquery.ui.all.css">
    <link rel="stylesheet" href="css/style.css">
   
    <link rel="stylesheet" href="css/animate.css">
        		<link rel="stylesheet" href="css/jPages.css">
    
 
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  		
        		<script>
        		$(document).ready(function () {
        		$("#cartao").click(function(){
		
		$("#modalCartao").modal();
	});		
	
$("#gerar").click(function(){
		
		var contrato = $("#contrato").val();
		var hash = $("#hash").val();
		
		$.ajax({  
            type: "POST",  
            url: "includes/controller/CadastrarController.php",  
            data: {contrato:contrato, hash:hash,acao:"gerar_hash"},
            beforeSend: function(){
            	$("#resultadoHash").html("<img src=\'img/loading.gif\'/>");
            },
            success: function(data)  
            {  
               
            	 $("#resultadoHash").addClass(\'alert\');
                $("#resultadoHash").html(data);
                
                    
            }  
        }); 
		
		});	
        		
        		
	});	
        		</script>
        		</head>

  <body>
 <!-- Modal -->
  <div id="modalCartao" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2>Gerar Hash Cartão de Crédito</h2>
  </div>
  <div class="modal-body">
    <input type="number" class="span3" id="contrato" placeholder="Número do contrato"/>
     <input type="number" class="span3" id="hash" value="1"/> 	
      		<div id="resultadoHash" class="success"></div>
  </div>
  <div class="modal-footer">
        <button class="btn btn-warning" id="gerar">Gerar Hash</button>
  </div>
</div>
  
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
      
      <div class="logo"><a href="painel.php"><img src="img/logo.png"></a> </div>

        <div class="container">
            
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="painel.php">PORTAL HANDOVER</a>
            <span class="sair"> <a style="margin-left:8px" class="btn btn-danger" title="Sair do sistema" href="sair.php" ><i class="icon-off"></i></a></span>
       <span class="sair"></span>
        		<div class="nav-collapse">
            
        		<ul class="nav navbar-nav">
            <li '.$cadastrar.' id="menu" ><a href="cadastrar.php"><i class="icon-file icon-white"></i> Cadastrar</a></li>
            <li '.$painel.' ><a href="painel.php" ><i class="icon-th-list icon-white"></i> Painel</a></li>
             
        	
       
                         <li class="dropdown '.$relatorio.'" id="menu3" >
                         <a class="dropdown-toggle " data-toggle="dropdown" href="#menu3">
                <i class="icon-download-alt icon-white"></i>  Extrações
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  
                      
                        <li ><a href="extracaoDados.php?tipo=demandas">Extração Projetos</a></li>
                        <li><a href="extracaoRequisitos.php?tipo=execucao">Extração Requisitos</a></li>

                </ul>
       

       <!--RELATORIO COMENTADO E DESTAIVADO TEMPORARIAMENTE      
  
                         <li class="dropdown '.$relatorio.'" id="menu3" >
                         <a class="dropdown-toggle " data-toggle="dropdown" href="#menu3">
                <i class="icon-list-alt icon-white"></i>  Relatórios
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  
                      
                        <li ><a href="relatorios.php?tipo=demandas">Relatórios de demandas</a></li>
                    		<li><a href="relatorios.php?tipo=SLA">Relatório de SLA</a></li>
                        
                    		<li><a href="relatorios.php?tipo=Projeto">Relatório de Status por Projeto</a></li>
                        <li><a href="relatorios.php?tipo=execucao">Relatório de Execução</a></li>

                </ul>
       --!>
  





            <li '.$usuario.'><a href="usuario_manter.php"><i class="icon-user icon-white"></i> Usuários</a></li>  

</ul>
        
          </div>
       
        </div>
      </div>
    </div>

    <div class="container">
<br>
<br>
<br>
<br>

      '; 
       
        
    }

    function htmlHeader() {

        echo '
       <!DOCTYPE html>
<html lang="br">
  <head>
      <link rel="shortcut icon" type="image/x-icon" href="img/algar.pngx" />
    <meta charset="utf-8">
    <title>PORTAL HANDOVER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Guilherme Assis">
    <script src="js/lib/jquery-1.9.0.js"></script>
    <script src="js/lib/ui/jquery.ui.core.js"></script>
    <script src="js/lib/ui/jquery.ui.widget.js"></script>
    <script src="js/lib/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="js/lib/highlight.pack.js"></script>
    <script type="text/javascript" src="js/lib/tabifier.js"></script>
    <script src="js/lib/js.js"></script>
    <script src="js/lib/jPages.js"></script>
    <script src="js/lib/jquery.validate.js"></script>
    <script src="js/lib/jquery.limit.js"></script>
    <script src="js/lib/bootstrap.js"></script>
     <script src="js/lib/jquery.maskedinput-1.3.js"></script>
<script src="js/lib/colorbox/colorbox/jquery.colorbox.js"></script>



    
  
    <!-- Le styles -->
     
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="css/themes/base/jquery.ui.all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jPages.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/github.css">
  <link rel="stylesheet" href="js/lib/colorbox/example5/colorbox.css" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
  


    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
      
      <div class="logo"><a href="painel.php"><img src="img/logo.png"></a> </div>

        <div class="container">
            
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
         <a class="brand" href="painel.php">PORTAL HANDOVER</a>
        <div class="nav-collapse">
            <ul class="nav">
            

</ul>
        
          </div>
       
        </div>
      </div>
    </div>

    <div class="container">
<br>
<br>
<br>
<br>

      ';
       
    }

    function htmlFooter() {
       
        echo '<footer>
           <hr/>
    <p style=" text-align: center">Transição para Produção</p>
</footer>

</div> <!-- /container -->

<!-- Le javascript
================================================== -->
        		
        		
        		
<!-- Placed at the end of the document so the pages load faster -->



</body>
</html>';
    }

}

?>
