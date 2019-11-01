<?php
class UsuarioDAO{
 

    function autenticaUsuario($usuario){
        require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();
        
        session_start();
         
    $conn->AbreConexao();
        //$sql = "select login,senha,id,perfil,nome from usuario where login='".$usuario->getLogin()."' and ativo=1 ";
        $sq_login= mysql_query("select login,senha,id,perfil,nome from handover_usuario where login='".$usuario->getLogin()."' and ativo=1 ");
       // echo "select login,senha,id,perfil,nome from usuario where login='".$usuario->getLogin()."' and ativo=1 ";
        
        //$sq_Demanda = mysql_query("UPDATE `handover_cacheusuario` SET `cacheUsuario`= '".$usuario->getLogin()."' WHERE 1");


        $login= mysql_fetch_assoc($sq_login) or die("Usuario Incorreto!!!");
        //echo $login['senha'] ;
        $senha_md5=  md5($usuario->getSenha());

              
        
        $login2 = strtoupper($login['login']);
       
        $login3 = strtoupper($usuario->getLogin());
        
    
        
        
        if( $login3 ==  $login2 && $senha_md5 == $login['senha']){
        //echo"teste";
            
        
                $_SESSION['login']=$login;
                $_SESSION['username']=$login3;
                

                
                    return true;
        }
        else{
                   
            return false;
        }
        $conn->FechaConexao();
    }
        
         function preencheSelectUsuario() {
            
         require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();

        $sq_clientes = mysql_query("SELECT id_usuario, nome_usuario FROM handover_usuario where ativo=1 ORDER BY nome_usuario");

        return $sq_clientes;
        $conn->FechaConexao();
    }

    function buscaNomeUsuario($id) {

        require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();

        $sq_nome_usuario = mysql_query("SELECT nome_usuario FROM handover_usuario where id_usuario=" . $id);
        $nome_usuario = mysql_fetch_assoc($sq_nome_usuario);
//echo $nome_usuario;
        return $nome_usuario;
        $conn->FechaConexao();
    }
    

    

    function cadastraUsuario($usuario) {
        require_once("../model/bean/Usuario.class.php");
       require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();
 $sq_dem=mysql_query("SELECT COUNT(login) FROM handover_usuario where login='".$usuario->getLogin()."'");
 //echo "SELECT COUNT(login) FROM usuario where login='".$usuario->getLogin()."'";
    $login= mysql_fetch_row($sq_dem);

    if($login[0]>0){

        $valid='nok';
        return $valid;
    }else{
        $sq_inserir = mysql_query("INSERT INTO handover_usuario (nome, ativo, senha, email, perfil, login) VALUES ('" . $usuario->getNome() . "'," . $usuario->getAtivo() . ",'" . $usuario->getSenha() . "','" . $usuario->getEmail() . "', " . $usuario->getPerfil() . ",' " . $usuario->getLogin() . "')");

        if ($sq_inserir) {
            
            return TRUE;
        } else {
            //echo"INSERT INTO cliente (nome_cliente, ativo, usuario, descricao, ultima_alteracao) VALUES ('".$cliente->getNome()."',".$cliente->getAtivo().", '".$cliente->getUsuario()."', '".$cliente->getDescricao()."', ".$cliente->getUltimaModicacao().")";
            return FALSE;
        }
       $conn->FechaConexao();
    }
    }

    function editaUsuario($usuario) {
    require_once("../model/bean/Usuario.class.php");
    require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();
///echo "UPDATE cliente SET nome_cliente='".$cliente->getNome()."',ativo=".$cliente->getAtivo().", id_usuario='".$cliente->getUsuario()."', descricao='".$cliente->getDescricao()."', ultima_alteracao=".$cliente->getUltimaModicacao()." WHERE id_cliente=".$cliente->getId()."<br>";

      if($usuario->getSenha()==""){
          $sq_inserir = mysql_query("UPDATE handover_usuario SET nome='" . $usuario->getNome() . "',ativo=" . $usuario->getAtivo() . ", login='" . $usuario->getLogin() . "', email='" . $usuario->getEmail() . "', perfil=" . $usuario->getPerfil() . " WHERE id=" . $usuario->getId());

      }else{

        $sq_inserir = mysql_query("UPDATE handover_usuario SET nome='" . $usuario->getNome() . "',ativo=" . $usuario->getAtivo() . ", senha='" . md5($usuario->getSenha()) . "', login='" . $usuario->getLogin() . "', email='" . $usuario->getEmail() . "', perfil=" . $usuario->getPerfil() ." WHERE id=" . $usuario->getId());
      }
        if ($sq_inserir) {
            return TRUE;
        } else {
   // echo "UPDATE usuario SET nome='" . $usuario->getNome() . "',ativo=" . $usuario->getAtivo() . ", senha='" . md5($usuario->getSenha()) . "', login='" . $usuario->getLogin() . "', email='" . $usuario->getEmail() . "', perfil=" . $usuario->getPerfil() ." WHERE id_usuario=" . $usuario->getId();

            return FALSE;
        }
        $conn->FechaConexao();
    }

    function buscaUsuario($id) {
        require_once("../model/bean/Usuario.class.php");
       
       require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();

        $sq_clientes = mysql_query("SELECT * FROM handover_usuario WHERE id=" . $id->getId());


        return $sq_clientes;
        $conn->FechaConexao();
    }
    
    
    function pesquisarUsuario($id) {
        require_once("../model/bean/Usuario.class.php");
        require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();
    
        $sq_clientes = mysql_query("SELECT * FROM handover_usuario WHERE nome like '" . $id->getNome()."%'");
    
    
        return $sq_clientes;
        
        $conn->FechaConexao();
    }
        
    function listaUsuario() {
        
        require "includes/model/dao/Conection.class.php";
        
        $conn = new Conection();
         $conn->AbreConexao();

      $sq_Demanda = mysql_query("SELECT * FROM handover_usuario") or die("teste usuario");
        
         return $sq_Demanda;
         
        $conn->FechaConexao();
    }


     function usuarioResponsavel($id) {
        
   
        
        $conn = new Conection();
         $conn->AbreConexao();
        
         //echo "SELECT * FROM `handover_demandas` WHERE status = '1' or status = '2'  and responsavel =".$id;
        $sq_Demanda = mysql_query("SELECT * FROM `handover_demandas` WHERE status = '1' or status = '2'  and responsavel =".$id);

        echo $sq_Demanda;

        
        return $sq_Demanda;
        $conn->FechaConexao();
        
    }

    function pegarUsuario($login) {

       
        
        $conn = new Conection();
         $conn->AbreConexao();            
        
        echo "SELECT id FROM `handover_usuario` WHERE login =".$login;
        $sq_Demanda = mysql_query("SELECT id FROM `handover_usuario` WHERE login =".$login);
                
       
        
        return $sq_Demanda;
        $conn->FechaConexao();
        
    }

    function fixarUsuario($usuario) {

     
       require_once 'Conection.class.php';
        
        $conn = new Conection();
        $conn->AbreConexao();       
        
        
        $sq_Demanda = mysql_query("UPDATE `handover_cacheusuario` SET `cacheUsuario`='".$usuario->getLogin()."' WHERE 1");
                
       
        
        return $sq_Demanda;
        $conn->FechaConexao();


        }

    function buscarUsucarioCache() {

       require "includes/model/dao/Conection.class.php";
        
        $conn = new Conection();
         $conn->AbreConexao();            
        
        //echo "SELECT `cacheUsuario` FROM `handover_cacheusuario` WHERE 1";
        $sq_Demanda = mysql_query("SELECT `cacheUsuario` FROM `handover_cacheusuario` WHERE 1");
                
       
        
        return $sq_Demanda;
        $conn->FechaConexao();


        }





}

?>