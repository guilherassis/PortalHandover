<?php

class RelatoriosDAO {
	
	function buscaResponsavelHistorico(){
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
		$sq_relatorio = mysql_query("SELECT DISTINCT h.responsavel, u.nome
FROM historico h, usuario u
where h.responsavel = u.id and u.nome!='Aguardando'
order by u.nome");
		
		//SELECT DISTINCT MONTH(data_inicio) AS mes, COUNT(*) AS contagem FROM demanda WHERE data_inicio like('2015%') GROUP BY mes ORDER BY mes
		
		return $sq_relatorio;
		
		$conn->FechaConexao();
		
	}
	function buscaStatusResponsavel($data_inicio,$data_fim,$id_resposavel){
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
        
		date_default_timezone_set('America/Sao_Paulo');
		$inicio = date('Y/m/d', strtotime($data_inicio));
		$fim= date('Y/m/d', strtotime($data_fim));
		$sq_relatorio = mysql_query("select h.status
from demanda dem, (select distinct hist.id_demanda, hist.status, usu.nome
                   from historico hist, usuario usu
                   where usu.id=hist.responsavel and hist.responsavel=".$id_resposavel."
                    ) h
where dem.id=h.id_demanda
and dem.data_inicio between '".$inicio."' and '".$fim."' ");
	
		
		
		
		return $sq_relatorio;
	
		$conn->FechaConexao();
	
	
	}
	
	
	
	function buscaTotalOfertaMes($ano){
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
		$sq_relatorio = mysql_query("SELECT DISTINCT MONTH(data_inicio) AS mes, COUNT(*) AS contagem FROM demanda WHERE data_inicio like('".$ano."%') and tipo=1 GROUP BY mes ORDER BY mes");
		
		//SELECT DISTINCT MONTH(data_inicio) AS mes, COUNT(*) AS contagem FROM demanda WHERE data_inicio like('2015%') GROUP BY mes ORDER BY mes
		
		return $sq_relatorio;
		
		$conn->FechaConexao();
		
		
	}
	
	function buscaTotalMaillingMes($ano){
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
		$sq_relatorio = mysql_query("SELECT DISTINCT MONTH(data_inicio) AS mes, COUNT(*) AS contagem FROM demanda WHERE data_inicio like('".$ano."%') and tipo=2 GROUP BY mes ORDER BY mes");
	
		//SELECT DISTINCT MONTH(data_inicio) AS mes, COUNT(*) AS contagem FROM demanda WHERE data_inicio like('2015%') GROUP BY mes ORDER BY mes
	
		return $sq_relatorio;
	
		$conn->FechaConexao();
	
	
	}
	
	function buscaProjetos($consulta){
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
		$sq_relatorio = mysql_query("SELECT substring(codigo, 1,5) as proj FROM `demanda` WHERE data_inicio between '".$consulta->getDataInicio()."' and '".$consulta->getDataFim()."' group by proj");
		
		//echo "SELECT substring(codigo, 1,5) as proj FROM `demanda` WHERE data_inicio between '".$consulta->getDataInicio()."' and '".$consulta->getDataFim()."' group by proj";
		
		
		return $sq_relatorio;
		
		$conn->FechaConexao();
	
	}
	
	function gerarRelatorioProjValidada($consulta){
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
	
	$sq_relatorio = mysql_query("SELECT t.factor * count(id)   AS pct
	FROM demanda
	JOIN (SELECT 100/COUNT(*) AS factor FROM demanda where codigo like '".$consulta."%') AS t
	where codigo like '".$consulta."%' and status > 2 and status<>11");
	
		
	return $sq_relatorio;
	
	$conn->FechaConexao();
}

function gerarRelatorioProjTotalDemandas($consulta){
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

	$sq_relatorio = mysql_query("SELECT count(*) from demanda
	where codigo like '".$consulta."%'");

	
	
	return $sq_relatorio;

	$conn->FechaConexao();
}

function gerarRelatorioProjConstruida($consulta){
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

	$sq_relatorio = mysql_query("SELECT t.factor * count(id)   AS pct
	FROM demanda
	JOIN (SELECT 100/COUNT(*) AS factor FROM demanda where codigo like '".$consulta."%') AS t
	where codigo like '".$consulta."%' and status>4 and status<>11 and status<>12");

	return $sq_relatorio;

	$conn->FechaConexao();
}


function gerarRelatorioProjTestada($consulta){
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

	$sq_relatorio = mysql_query("SELECT t.factor * count(id)   AS pct
	FROM demanda
	JOIN (SELECT 100/COUNT(*) AS factor FROM demanda where codigo like '".$consulta."%') AS t
	where codigo like '".$consulta."%' and status>6 and status<>11 and status<>12 and status<>13");

		
	return $sq_relatorio;

	$conn->FechaConexao();
}

function gerarRelatorioProjImplantada($consulta){
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

	$sq_relatorio = mysql_query("SELECT t.factor * count(id)   AS pct
	FROM demanda
	JOIN (SELECT 100/COUNT(*) AS factor FROM demanda where codigo like '".$consulta."%') AS t
	where codigo like '".$consulta."%' and status>8 and status<>11 and status<>12 and status<>13 and status<>14");

	return $sq_relatorio;

	$conn->FechaConexao();
}

function gerarRelatorioProjValProd($consulta){
	require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();

	$sq_relatorio = mysql_query("SELECT t.factor * count(id)   AS pct
	FROM demanda
	JOIN (SELECT 100/COUNT(*) AS factor FROM demanda where codigo like '".$consulta."%') AS t
	where codigo like '".$consulta."%' and status=9");

	return $sq_relatorio;

	$conn->FechaConexao();
}


	function gerarRelatorioDemanda($consulta){
		
		require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
		$sq_relatorio = mysql_query("SELECT * FROM demanda where data_inicio between '".$consulta->getDataInicio()."' and '".$consulta->getDataFim()."'");
			//echo "SELECT * FROM demanda where data_inicio between '".$consulta->getDataInicio()."' and '".$consulta->getDataFim()."'";
		return $sq_relatorio;	
		
		$conn->FechaConexao();
		}
		
		
		
		function gerarRelatorioSLA($consulta){
		
			require_once 'Conection.class.php';
		
		$conn = new Conection();
        $conn->AbreConexao();
		
			$sq_relatorio = mysql_query("SELECT id FROM demanda where data_inicio between '".$consulta->getDataInicio()."' and '".$consulta->getDataFim()."' and finalizada=1 and tipo=1");
			//echo "SELECT id FROM demanda where data_inicio between '".$consulta->getDataInicio()."' and '".$consulta->getDataFim()."' and finalizada=1";
			return $sq_relatorio;
		
			$conn->FechaConexao();
		}
		
	
	
	
    

}

?>
