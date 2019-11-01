<?php

class UsuarioView{

    function respostaVerificaLogin($valid){
        
       echo $valid; 
    }
    
    
	function respostaAutenticacao($resposta){
	
		/*Se a vari�vel $resposta estiver neste momento como TRUE, ent�o os dados est�o corretos e podemos 
		exibir uma mensagem de sucesso. Caso contr�rio, ir� cair no else, que ir� alertar que os dados s�o inv�lidos.*/
		if($resposta){
			echo 'ok';
		}
		else{
			echo 'Erro ao efetuar o login. Dados incorretos!';
		}
	}

        function imprimeNomeGerente($resultado){
            
            echo $resultado;
        }


        function imprimeSelect($resultado) {


        while ($usuario = mysql_fetch_array($resultado)) {
            echo" <option value='" . $usuario['id_usuario']."'>".$usuario['nome_usuario']."</option>";


         
        }
        
    }
    
         function imprimeSelectGerente($resultado) {


        while ($gerente = mysql_fetch_array($resultado)) {
            echo" <option value='" . $gerente['id_usuario']."'>".$gerente['nome_usuario']."</option>";


         
        }
        
    }
    
    
    function atualizaTabela($resultado){
  
        
        
        echo" 
            <script src='js/functions_usuario.js'></script>
<table class='table table-bordered'>
    
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Ativo</th>
        <th>Ação</th>
      
    </tr>
    </thead>
    <tbody id='usuarios'>";
        while ($usuarios = mysql_fetch_array($resultado)) {
            if ($usuarios['ativo'] == '1') {
                $ativo = 'Ativo';
            } else {
                $ativo = 'Inativo';
            }
            echo"<tr>        
            <td>
               " . $usuarios['nome'] . " 
                
            </td>
            <td>
               " . $ativo . " 
                
            </td>
            <td>
                <button class='btn editar' id='editar' title='Editar'  value='" . $usuarios['id'] . "' href='#'> <i class='icon-pencil'></i></button>
             
               
                    
            </td>
        </tr>         
         
";    
        
        
    }
    }
    
    
    function paginaInicial($resultado) {

       echo"


<div class='square_white'>
    <p class='label label-info fonte20'>Manter Usuários </p>
    <div class='cadastro' >

        <form action='#' method='post' name='form_cadastra' id='form_cadastra'>

            <table class='table'>
                <tr>
                    <td>Nome:</td>
                    <td><input type='text' name='nome_usuario' placeholder='Nome do Usuário' id='nome_usuario' value=''class='input-xxlarge limit'/>
                                      
                    </td>
                </tr>
                <tr>
                    <td>Login:</td>
                    <td><input type='text' name='login_usuario' placeholder='Login do usuário'id='login_usuario' value=''class='input-xxlarge limit'/>
                                     
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type='text' name='email' placeholder='Email' id='email' value=''class='input-xxlarge limit'/>
                                     
                    </td>
                </tr>
                <tr>
                    <td>Senha:</td>
                    <td><input type='password' name='senha' placeholder='Senha' id='senha' value=''class='input-xxlarge limit'/>
                                     
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <input type='radio'  name='ativo' checked value='1'  />
                        <span> Ativo </span>

                        <input type='radio' name='ativo' value='0' />
                        <span>Inativo</span>
                    </td>
                </tr>
                <tr>
                    <td>Perfil:</td>
                    <td>
                        <input type='radio'  name='perfil' checked value='1'  />
                        <span> Executa </span>

                        <input type='radio' name='perfil' value='2' />
                        <span>Gerente</span>
                        
                    </td>
                </tr>
                
                           
                            </table>

                            <div align = 'center'>

                            <table>
                            <tr>
                            <td>
                            <input type = 'hidden' name = 'acao' value = 'cadastrar'/>
                            <button type = 'submit' class = 'btn btn-success' >Cadastrar</button>
                            <input type = 'reset' class = 'btn ' value = 'Limpar'/>
                            </td>
                            </tr>
                            </table>


                            </div>


                            </form>
                            <div id = 'resultado'></div>
                            </div>
                            </div>

                            <div class = 'square_white'>
                               
                            <p class = 'label label-info'>Lista de usuários cadastrados</p>
 <form id='search' name='search' class='navbar-search pull-left'>
 <input type='hidden' name='acao' value='pesquisar'/>
     <input type='text' class='search-query span8' placeholder='Buscar Usuários' name='pesquisa_usuario'> <button class='btn' type='submit'><i class='icon-search'></i></button>
</form>
                            <div id = 'tabela'>
  
<table class='table table-bordered'>
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Ativo</th>
        <th>Ação</th>
      
    </tr>
    </thead>
    <tbody id='usuarios'>";
        while ($usuarios = mysql_fetch_array($resultado)) {
            if ($usuarios['ativo'] == '1') {
                $ativo = 'Ativo';
            } else {
                $ativo = 'Inativo';
            }
            echo"<tr>        
            <td>
               " . $usuarios['nome'] . " 
                
            </td>
            <td>
               " . $ativo . " 
                
            </td>
            <td>
                <button class='btn editar' id='editar' title='Editar'  value='" . $usuarios['id'] . "' href='#'> <i class='icon-pencil'></i></button>
             
               
                    
            </td>
        </tr>         
         
";
        }
        echo"  </tbody>
    </table>
 </div> 

<div class='holder'></div>

                            </div>
                             ";
    }

    function resultadoInserir($resultado) {
if($resultado=="nok"){
	
    echo $resultado;
}else{
        
            echo 'Cadastro realizado com sucesso! <button type="button" class="close" data-dismiss="alert">×</button>';
        
    }
    }

    function resultadoEditar($resultado) {

        if ($resultado) {
            echo 'Cadastro alterado com sucesso!';
        } else {
            echo 'Erro ao efetuar o cadastro!';
        }
    }

    function retornoPesquisar($resultado) {
echo" 
<script src='js/functions_usuario.js'></script>    
<table class='table table-bordered'>
    
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Ativo</th>
        <th>Ação</th>
      
    </tr>
    </thead>
    <tbody id='usuarios'>";
        while ($usuarios = mysql_fetch_array($resultado)) {
            if ($usuarios['ativo'] == '1') {
                $ativo = 'Ativo';
            } else {
                $ativo = 'Inativo';
            }
            echo"<tr>        
            <td>
               " . $usuarios['nome'] . " 
                
            </td>
            
            <td>
               " . $ativo . " 
                
            </td>
            <td>
                <button class='btn editar' id='editar' title='Editar'  value='" . $usuarios['id'] . "' href='#'> <i class='icon-pencil'></i></button>
             
               
                    
            </td>
        </tr>         
         
";    
        
        
    }
    }

   

    function editarVisualizar($resultado) {
       
            $usuario = mysql_fetch_array($resultado);
               $ativo = '';
        $inativo = '';
        $auditor='';
        $gerente='';
        $visitante='';
        if($usuario['perfil']=='1'){
            $auditor='checked';
        }
        if($usuario['perfil']=='2'){
            $gerente='checked';
        }
       
        
        
        if ($usuario['ativo'] == '1') {
            $ativo = 'checked';
        } else {
            $inativo = 'checked';
        }
        echo"
            <script src='js/functions_usuario.js'></script>
  <div class='square_grey'>
<p class='label label-info fonte20'>Editar Usuário</p>  

  <div id='resultado'>
 <form action='#' method='post' name='form_editar' id='form_editar'>
 
    <table class='table'>
        <tr>
            <td>Nome:</td>
            <td><input type='text' name='nome_editar' id='nome_editar' value='" . $usuario['nome'] . "' class='input-xxlarge limit'/>
               
</td>
        </tr>
         <tr>
                    <td>Login:</td>
                    <td><input type='text' name='login_editar' value='" . $usuario['login'] . "' id='login_usuario' value=''class='input-xxlarge limit'/>
                                     
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type='text' name='email_editar' value='".$usuario['email'] ."' id='email_editar' class='input-xxlarge limit'/>
                                     
                    </td>
                </tr>
                <tr>
                    <td>Senha:</td>
                    <td><input type='password' name='senha'  id='senha' class='input-xxlarge limit'/>
                                     
                    </td>
                </tr>
        <tr>
            <td>Status:</td>
            <td>
            <input type='radio'  name='ativo' value='1' " . $ativo . " />
            <span> Ativo </span>

            <input type='radio' name='ativo' value='0' " . $inativo . " />
            <span>Inativo</span>
            </td>
        </tr>
        <tr>
                    <td>Perfil:</td>
                    <td>
                        <input type='radio'  name='perfil' ".$auditor." value='1'  />
                        <span> Executa </span>

                        <input type='radio' name='perfil' ".$gerente." value='2' />
                        <span>Gerente</span>
                       
                    </td>
                </tr>
     
    </table>
 <input type='hidden' name='acao' value='editar_usuario'/>   
 <input type='hidden' name='id' value='" . $usuario['id'] . "'/>   
        <button type='submit' class='btn btn-success' id='teste'>Enviar</button>	
       <button class='btn' id='cancelar'>Cancelar</button>	
</form>
</div>
<div id='voltar'></div>
</div>";
    }
        
        
}

?>