<?php

class RelatoriosView {

	function imprimeGraficoDemanda($dados){
	
		
	}
	
	function imprimeTabelaExecucao($resultado, $json){
		
		echo"<script>
				$(document).ready(function () {
	 
				$('#container').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: 'Quantidade de demandas por Status X Pessoa'
	        },
	       
	        xAxis: {
	            categories: [
	                'Validação',
	                'Construção',
	                'Teste',
	                'Implantação',
	                'Val. Produção',
	                'Reteste'
	            ],
	            crosshair: true
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Total de Demandas'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
	            pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
	                '<td style=\"padding:0\"><b>{point.y} </b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: [$json]
	    });
	});
				</script>";
		
		
		echo "<table id='datatable' class='table table-bordered'>
    <thead>
        <tr>
            <th>Executor</th>
			<th>Validação</th>
			<th>Construção</th>
			<th>Teste</th>
				<th>Implatação</th>
				<th>Val. Produção</th>
				<th>Reteste</th>
         </tr>
    </thead>
    <tbody>
        ";
           for($i=0;$i<count($resultado);$i++){
           	echo"<tr>
           			<td>".$resultado[$i][0]."</td>
           			<td>".$resultado[$i][1]."</td>
           			<td>".$resultado[$i][2]."</td>
           			<td>".$resultado[$i][3]."</td>
           			<td>".$resultado[$i][4]."</td>
           			<td>".$resultado[$i][5]."</td>
           			<td>".$resultado[$i][6]."</td>
           	</tr>";
           }
        echo"
    </tbody>
</table>
        		
        		
        			
    		";
        		
        
		
	}
	
	
	function imprimeRelatorioSLA($resultado,$periodo) {
		require '../model/dao/CadastrarDAO.class.php';
		require 'CadastrarView.class.php';
		$cadastrarDAO = new CadastrarDAO();
		$cadastrarView = new CadastrarView();
		$totalValidacao=0;
		$totalConstrucao=0;
		$totalTeste=0;
		$totalImplatacao=0;
		$totalValProd=0;
		$totalReteste=0;
		
		$total_demandas=mysql_num_rows($resultado);
		if($total_demandas==0){
			echo "<p class='label label-important' >Sua Pesquisa não retornou resultados!</p>";
		}
		else{
		
		while($sla=mysql_fetch_array($resultado)){
			$totalValidacao=$totalValidacao+$cadastrarDAO->calcularValidacao($sla['id']);
			$totalConstrucao=$totalConstrucao+$cadastrarDAO->calcularConstrucao($sla['id']);
			$totalTeste= $totalTeste+$cadastrarDAO->calcularTeste($sla['id']);
			$totalImplatacao=$totalImplatacao + $cadastrarDAO->calcularImplatacao($sla['id']);
			$totalValProd = $totalValProd + $cadastrarDAO->calcularValidacaoProducao($sla['id']);
			$totalReteste = $totalReteste + $cadastrarDAO->calcularReteste($sla['id']);
		}
		
		
		
		echo"
    	<br>
    	<br>
    			<p  class = 'label label-info'>Relatório de SLA no período ".$periodo." </p>
		    			<br>
    		<table class='table' id='datatable'>
    			<tr><td><b>Status</b></td> <td><b>Total de Tempo</b></td><td><b>Média de Tempo</b></td></tr>
				<tr><td>Validação</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalValidacao)."</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalValidacao/$total_demandas)."</td>
				<tr><td>Construção</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalConstrucao)."</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalConstrucao/$total_demandas)."</td>
    			<tr><td>Teste</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalTeste)."</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalTeste/$total_demandas)."</td>		
				<tr><td>Implantação</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalImplatacao)."</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalImplatacao/$total_demandas)."</td>
				<tr><td>Validação em produção</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalValProd)."</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalValProd/$total_demandas)."</td>
				<tr><td>Reteste</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalReteste)."</td><td>".$cadastrarView->impremeHoraMinutoSegundo($totalReteste/$total_demandas)."</td>
		</table>";
    					
		}
		
	}
	
	function imprimeRelatorioProjeto($resultado,$periodo) {
		 
		//require '../model/dao/RelatoriosDAO.class.php';
		$relatorioDAO = new RelatoriosDAO();
		 
		$total_demandas=mysql_num_rows($resultado);
		if($total_demandas==0){
			echo "<p class='label label-important' >Sua Pesquisa não retornou resultados!</p>";
		}
		else{
			
			echo "<script src='js/functions_relatorio.js'></script>
					<br>
    			<p  class = 'label label-info'>Relatório de demandas no período ".$periodo." </p> 
    					<br>
					";
			
			while($projeto = mysql_fetch_array($resultado)){
				
			$validacao = mysql_fetch_row($relatorioDAO->gerarRelatorioProjValidada($projeto['proj']));
			$construcao = mysql_fetch_row($relatorioDAO->gerarRelatorioProjConstruida($projeto['proj']));
			$teste = mysql_fetch_row($relatorioDAO->gerarRelatorioProjTestada($projeto['proj']));
			$implantada = mysql_fetch_row($relatorioDAO->gerarRelatorioProjImplantada($projeto['proj']));
			$valProd = mysql_fetch_row($relatorioDAO->gerarRelatorioProjValProd($projeto['proj']));
			$pctTotal = ($validacao[0]+$construcao[0]+$teste[0]+$implantada[0]+$valProd[0])/5;
			$total = mysql_fetch_row($relatorioDAO->gerarRelatorioProjTotalDemandas($projeto['proj']));
			
			echo'
			
    
    	<div class="square_white">
			
    
    			<a  title="Detalhar Projeto" class="btn" data-toggle="collapse" data-target="#'.$projeto['proj'].'"><i  class="icon-list"></i></a><b> Projeto '.$projeto['proj'].' </b> - Conclusão do projeto: <b>'.number_format($pctTotal,2).'% </b> - Total de ofertas:<b> '.$total[0].'</b>
			
    			<div id="'.$projeto['proj'].'" class="collapse ">
    
    			<br>
    	
    		<span class="span2"> Validação: '.number_format($validacao[0],2).'%
    				
    				<div class="progress progress-info">
  <div class="bar" style="width: '.number_format($validacao[0],2).'%"></div>
</div>
    				</span>
    				
      <span class="span2">Construção: '.number_format($construcao[0],2).'%
      		<div class="progress progress-info">
  			<div class="bar" style="width: '.number_format($construcao[0],2).'%"></div>
			</div>
      		</span>
      <span class="span2">Teste: '.number_format($teste[0],2).'%
      		<div class="progress progress-info">
  			<div class="bar" style="width: '.number_format($teste[0],2).'%"></div>
			</div>
      		</span>
      <span class="span2">Implantação: '.number_format($implantada[0],2).'% 
      		<div class="progress progress-info">
  			<div class="bar" style="width: '.number_format($implantada[0],2).'%"></div>
			</div>
      		
      		</span>
      <span class="span2">Val. produção: '.number_format($valProd[0],2).'%
      		
      		<div class="progress progress-info">
  			<div class="bar" style="width: '.number_format($valProd[0],2).'%"></div>
			</div>
      		
      		</span>
    			
    			<br>
			
    	</div>
			
    			</div>';
			
		} // fim do while
		
		
		} // fim do else
		
	}
	
	
    
    function imprimeRelatorioDemanda($resultado,$periodo) {
    	
    	require '../model/dao/CadastrarDAO.class.php';
    	$cadastrarDAO = new CadastrarDAO();
    	require '../view/CadastrarView.class.php';
    	$cadastrarView = new CadastrarView();
    	
    	$total_demandas=mysql_num_rows($resultado);
    	if($total_demandas==0){
    		echo "<p class='label label-important' >Sua Pesquisa não retornou resultados!</p>";
    	}
    	else{
    	
echo"
    			<script src='js/functions_cadastrar.js'></script>
    	<br>
    	<br>
    			<p  class = 'label label-info'>Relatório de demandas no período ".$periodo." </p> 
    					<br>
    					<span class='label label-warning'>Total de demandas no período:</span> <span class='badge badge-inverse'>".$total_demandas."</span>
    	<br>
    	<br>
    							<div id = 'tabela'>
    	<table class='table table-bordered'>
    	<thead>
    	<tr>
    	<th>Código</th>
    	<th>Responsável</th>
    	<th>Status</th>
    	<th>Data Início</th>
    	<th>Data Estimada</th>
    	<th>Data Final</th>
    	<th>Tipo</th>
    	<th>Ação</th>
    	 
    	</tr>
    	</thead>
    	<tbody id='clientes'>";
    	
    	 
    	while ($demandas = mysql_fetch_array($resultado)) {
    	if ($demandas['tipo'] == '1') {
    			$tipo = 'Ofertas';
    	} else {
    			$tipo = 'Mailling';
    	}
    			echo"<tr>
    			<td title='" . $demandas['nome'] . "'>
    			" . $demandas['codigo'] . "
    					 
    					</td>
    					<td>";
    					if($demandas['responsavel']!=0){
    							echo $cadastrarDAO->buscaNomeResponsavel( $demandas['responsavel']);
    	}
    									echo "</td>
    									<td>" .$cadastrarDAO->buscaNomeStatus( $demandas['status'] ). "</td>
    											<td>" .$cadastrarView->converterData($demandas['data_inicio']). "</td>
    													<td>" .$cadastrarView->converterData($demandas['data_exp']). "</td>";
    									if($demandas['data_fim']!="0000-00-00"){
    													echo"<td>" .$cadastrarView->converterData($demandas['data_fim']). "</td>";
    									}else{echo"<td></td>";}
    									echo"				<td>
    													" . $tipo. "
    													 
    													</td>
    													<td>
    													<button class='btn detalhar' id='detalhar' title='Detalhar'  value='" . $demandas['id'] . "' href='#'> <i class='icon-home'></i></button>
    													<button class='btn editar' id='editar' title='Editar'  value='" . $demandas['id'] . "' href='#'> <i class='icon-pencil'></i></button>
    	
    													 
    													</td>
    													</tr>
    	
    													";
        }
        echo"  </tbody>
    													</table>
    	
    													</div>";
     
         
    	}
        
    }
    
    
    function relatorioSLA() {
    
    	echo "<script src='js/functions_relatorio.js'></script>
    			<script src='js/bootstrap-datepicker.js'></script>
    			<link rel='stylesheet' href='css/datepicker.css'>
    		<p class = 'label label-info'>Filtros de pesquisa</p>
    		<br>
    			
    			<form id='form_demanda' name='form_demanda' action='#' method='post' class='navbar-search pull-left'>
 
    Periodo: <input type='text' class='span2' value='' id='dpd1' name='dpd1'/>
    			
     <input type='text' class='span2' value='' id='dpd2' name='dpd2'/>	
    			
    			
    		<button class='btn'  type='submit' title='Gerar Relatorio'	><i class='icon-search' ></i></button>
    			<button class='btn'  type='reset' title='Limpar datas'><i class='icon-trash' ></i></button>
    			<input type='hidden' name='acao' value='relatorio_sla'/>
</form>
    			
    			</div>
    			<br><br><br><br>
    		
    			<div id='resultado'></div>
    			
    			";
    
    	echo'
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-body">
          <img src="img/ajax-loader.gif"/>
        </div>
       
      </div>
    </div>
  </div>

    			
    			
    			';
    		 
    	
    
    }
    
    function relatorioDemanda() {
    
    	echo "<script src='js/functions_relatorio.js'></script>
    			<script src='js/bootstrap-datepicker.js'></script>
    			<link rel='stylesheet' href='css/datepicker.css'>
    			<br>
    		<p class = 'label label-info'>Filtros de pesquisa</p>
    		<br>
    			
    			<form id='form_demanda' name='form_demanda' action='#' method='post' class='navbar-search pull-left'>
 
    Periodo: <input type='text' class='span2' value='' id='dpd1' name='dpd1'/>
    			
     <input type='text' class='span2' value='' id='dpd2' name='dpd2'/>	
    			
    			
    		<button class='btn'  type='submit' title='Gerar Relatorio'	><i class='icon-search' ></i></button>
    			<button class='btn'  type='reset' title='Limpar datas'><i class='icon-trash' ></i></button>
    			<input type='hidden' name='acao' value='relatorio_demanda'/>
</form>
    			
    			</div>
    			<br><br><br><br>
    			
    			 
    			
    			<div id='resultado'></div>
    
    			";
    	
    	echo'<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <img src="img/ajax-loader.gif"/>
      </div>
      
    </div>
  </div>';
    
    
    		 
    	
    
    }
    
    
    function relatorioProjeto() {
    
    	echo "<script src='js/functions_relatorio.js'></script>
    			<script src='js/bootstrap-datepicker.js'></script>
    			<link rel='stylesheet' href='css/datepicker.css'>
    			<br>
    		<p class = 'label label-info'>Filtros de pesquisa</p>
    		<br>
 
    			<form id='form_demanda' name='form_projeto' action='#' method='post' class='navbar-search pull-left'>
    
    Periodo: <input type='text' class='span2' value='' id='dpd1' name='dpd1'/>
    
     <input type='text' class='span2' value='' id='dpd2' name='dpd2'/>
    
    
    		<button class='btn'  type='submit' title='Gerar Relatorio'	><i class='icon-search' ></i></button>
    			<button class='btn'  type='reset' title='Limpar datas'><i class='icon-trash' ></i></button>
    			<input type='hidden' name='acao' value='relatorio_projeto'/>
</form>
    
    			</div>
    			<br><br><br><br>
        	<div id='resultado'></div>
    			";
    	
    	
    	
    	echo'<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <img src="img/ajax-loader.gif"/>
      </div>
    
    </div>
  </div>';
    
    
    	 
    	 
    
    }
    
    
    function relatorioExecucao() {
   ;
    	echo "<script src='js/functions_relatorio.js'></script>
    			<script src='js/bootstrap-datepicker.js'></script>
    			<link rel='stylesheet' href='css/datepicker.css'>
    			<br>
    		<p class = 'label label-info'>Relatório de Execução - Filtros de pesquisa</p>
    		<br>
    
    			<form id='form_execucao' name='form_execucao' action='#' method='post' class='navbar-search pull-left'>
    
    Periodo: <input type='text' class='span2' value='' id='dpd1' name='dpd1'/>
    
     <input type='text' class='span2' value='' id='dpd2' name='dpd2'/>
    
    
    		<button class='btn'  type='submit' title='Gerar Relatorio'	><i class='icon-search' ></i></button>
    			<button class='btn'  type='reset' title='Limpar datas'><i class='icon-trash' ></i></button>
    			<input type='hidden' name='acao' value='relatorio_execucao'/>
</form>
    
    			</div>
    			<br><br><br><br>
    			<div id='container' style='min-width: 310px; height: 400px; margin: 0 auto'></div>
    			<br><br>
    			<div id='resultado' style='height: 400px; '></div>
    			
        		</div>
    			";
    	 
    	 
    	 
    	echo'<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <img src="img/ajax-loader.gif"/>
      </div>
    
    </div>
  </div>';
    
    	echo"
    	
<script src='js/highcharts.js'></script>
    		<script src='https://code.highcharts.com/highcharts-3d.js'></script>
<script src='js/modules/exporting.js'></script>";
    	
    
    
    
    }
    
    
    
    function relatorioGrafico() {
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	echo "<script src='js/functions_relatorio.js'></script>
    			<script src='js/bootstrap-datepicker.js'></script>
    			<link rel='stylesheet' href='css/datepicker.css'>
    			<br>
    		<p class = 'label label-info'>Filtros de pesquisa</p>
    		<br>
    
    		
    Selecione o ano: <select name='ano' id='ano'>
    		";
    			
    	for($ano=2015;$ano<date("Y")+1;$ano++){
    		
    		echo "<option value='$ano'>$ano</option>";
    	}
    	
    	echo"		</select>
    
    
    
    
    		<button class='btn'   title='Gerar Relatorio' id='enviar_status'	><i class='icon-search' ></i></button>
    			<button class='btn'  type='reset' title='Limpar datas'><i class='icon-trash' ></i></button>
    		

    
    			</div>
    			<br><br><br><br>
    
    
    
    			<div id='grafico_demandas' ></div>
    			<div id='grafico_pizza' style='min-width: 310px; height: 400px; margin: 0 auto'></div>
    
    			";
    	 
    	echo'<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <img src="img/ajax-loader.gif"/>
      </div>
    
    </div>
  </div>';
    
    echo"
		
<script src='js/highcharts.js'></script>
    		<script src='https://code.highcharts.com/highcharts-3d.js'></script>
<script src='js/modules/exporting.js'></script>";
    
   
    
    }
    

}

?>