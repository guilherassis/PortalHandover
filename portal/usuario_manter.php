<?php
require_once 'includes/view/html_body.php';
require_once 'includes/controller/ValidaLogin.class.php';
$html = new HtmlBody();
$html->htmlHeaderAdmin();
$validar = new ValidaLogin();
$validar->ValdidarLogin();

?>
 
<script src="js/functions_usuario.js"></script>

<div id='corpo'>
                            <?php
                            
                            require_once "includes/model/dao/UsuarioDAO.class.php" ; // Classe DAO
                            require_once "includes/view/UsuarioView.class.php" ; //Classe View
                            
                            $usuarioDAO = new UsuarioDAO();
                            
                            $usuarioView = new UsuarioView();
                           
                            //Passaremos para o m�todo de autentica��o da DAO um objeto da classe Usu�rio. Armazenaremos na vari�vel $resultado o que este m�todo retornar. 
                       $resultado = $usuarioDAO->listaUsuario();
                       
                            //Agora chamamos um m�todo da View passando para o mesmo o que foi retornado pela DAO.
                            $usuarioView->paginaInicial($resultado);
                            ?>

                </div>            


<?php
$html->htmlFooter();
?>