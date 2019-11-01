<?php

//Aqui importamos todas as classes que poder�o ser usadas baseado nas solicita��es que forem feitas.
require_once "../model/bean/Usuario.class.php"; // Classe Bean
require_once "../model/dao/UsuarioDAO.class.php"; // Classe DAO
require_once "../view/UsuarioView.class.php"; //Classe View
//Armazena na vari�vel $acao o que o sistema esta requisitando (cadastrar, autenticar, excluir, etc)

if(isset($_REQUEST["login"])){
    $acao = 'login';
}

if (isset($_POST['acao'])) {
    $acao = $_POST["acao"];
} else {
    $acao = $_GET["acao"];
}

//Baseado no que foi solicitado, chama na classe DAO o m�todo respons�vel por tal tarefa, e depois manda pra View a resposta, para ser exibida de alguma forma ao usu�rio
switch ($acao) {
case 'login':{

    $usuario = new Usuario();
    $usuario->setLogin($_REQUEST["login"]);
    
         
     $usuarioDAO = new UsuarioDAO();
     $usuarioView = new UsuarioView();
     $resultado = $usuarioDAO->verificaLogin($usuario);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->respostaVerificaLogin($resultado);
   
  
}break;

case 'buscar_gerente_projeto':{
  
    $usuario = new Usuario();
    $usuario->setId($_POST['id']);
     
     $usuarioDAO = new UsuarioDAO();
     $usuarioView = new UsuarioView();
     $resultado = $usuarioDAO->buscaNomeGerenteProjeto($usuario);
     $usuarioView->imprimeNomeGerente($resultado);

           
  
}break;
    case 'autenticar': {

            // Se for autenticar, ent�o dever�o ser informados login e senha.
            //Primeiro instanciamos um objeto da classe Bean, para setar os valores informados no formul�rio
            $usuario = new Usuario();

            /* Agora setamos para a Bean os valores informados,pois ser�o validados na camada DAO, que 
              ir� verificar a consistencia dos dados em um Banco de Dados: MySQL, XML, ou qualquer outra base de dados; e depois retornar para a controller o resultado. */
          
           // $usuario->setLogin(strtoupper($_REQUEST["login"]));
        //    $usuario->setSenha($_REQUEST["senha"]);

            /* Agora vamos instanciar um objeto da classe DAO e um da View, e passaremos para a View o que for retornado pela DAO */
            $usuarioDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();
            $usuario->setLogin($_POST['login']);
            $usuario->setSenha($_POST['senha']);

           
           
            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuarioDAO->autenticaUsuario($usuario);
            
            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->respostaAutenticacao($resultado);

        }
        break;
    case 'buscar': {

            // Se for autenticar, ent�o dever�o ser informados login e senha.
            //Primeiro instanciamos um objeto da classe Bean, para setar os valores informados no formul�rio
            //$usuario = new Usuario();	

            /* Agora vamos instanciar um objeto da classe DAO e um da View, e passaremos para a View o que for retornado pela DAO */
            $usuarioDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();

            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuarioDAO->listaUsuario();

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->atualizaTabela($resultado);
        }
        break;

    case 'cadastrar': {
            $time = time();
            $usuario = new Usuario();
            $usuario->setNome($_POST['nome_usuario']);
            $usuario->setAtivo($_POST['ativo']);
            $usuario->setEmail($_POST['email']);
            $usuario->setLogin(trim($_POST['login_usuario']));
            $usuario->setPerfil($_POST['perfil']);
            $usuario->setSenha($_POST['senha']);
            $usuario->setUltimaModificacao($time);

            /* Agora vamos instanciar um objeto da classe DAO e um da View, e passaremos para a View o que for retornado pela DAO */
            $usuariosDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();

            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuariosDAO->cadastraUsuario($usuario);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->resultadoInserir($resultado);
        }
        break;
        
    case 'editar_usuario': {
          
            $usuario = new Usuario();
            $usuario->setId($_POST['id']);
            $usuario->setNome($_POST['nome_editar']);
            $usuario->setAtivo($_POST['ativo']);
            $usuario->setEmail($_POST['email_editar']);
            $usuario->setLogin($_POST['login_editar']);
            $usuario->setPerfil($_POST['perfil']);
            $usuario->setSenha($_POST['senha']);
          

            /* Agora vamos instanciar um objeto da classe DAO e um da View, e passaremos para a View o que for retornado pela DAO */
            $usuariosDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();

            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuariosDAO->editaUsuario($usuario);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->resultadoEditar($resultado);
        }
        break;

    case 'editar': {
            $usuario = new Usuario();
            $usuario->setId($_POST['id']);
            $usuariosDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();

            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuariosDAO->buscaUsuario($usuario);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->editarVisualizar($resultado);
        }
        break;
   
    case 'inicio': {
            $usuariosDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();

            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuariosDAO->listaUsuario();

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            
        }
        break;
    case 'pesquisar': {
            $usuario = new Usuario();
            $usuario->setNome($_POST['pesquisa_usuario']);
            $usuariosDAO = new UsuarioDAO();
            $usuarioView = new UsuarioView();

            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
            $resultado = $usuariosDAO->pesquisarUsuario($usuario);

            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
            $usuarioView->retornoPesquisar($resultado);
        }
        break;

    case 'excluir': {
            //Aqui faz as valida��es necess�rias e requisita o m�todo da classe DAO respons�vel por excluir o usu�rio.
        }

    default: return null; //Por padr�o, esse switch n�o retorna nada.
}
?>