<?php require_once 'includes/view/html_body.php';
$html= new HtmlBody();
$html->htmlHeader();
?>
<script src="js/functions_login.js"></script>
<center>
         <div id="lo">
             <img src="img/cadeado.png" width="98" height="114" style="float: left; padding-left: 10px; padding-top:35px"/> 
             <br>
   
                          <form  method="post" id="logar" >
                    <table align="center">
                        <tr>
                            <td align="right">Login:</td>
                        <td>
                    <input type="text" class="input-medium" name="login" id="login"/></td></tr>
                        <tr>
                            <td align="right">
                    Senha:</td>
                            <td>
                    <input type="password" class="input-medium"  name="senha" id="senha"/></td>
                            <tr align="center">
                                <td  colspan="2">
                    <input type="hidden" name="acao" value="autenticar" />
                                    <input type="submit" value="Logar"  class="btn btn-success"/><input style="margin-left: 8px" type="reset" class="btn btn-warning"value="Limpar"/>
                                </td></tr></table>
                              
               <br/> 
               
               <br/><?php
        if(isset($_SESSION['erro'])){
          
            if($_SESSION['erro']==2){
           echo"<div class='alert alert-error'>";
            echo"<button class='close' data-dismiss='alert'>X</button>Você não tem permissão para essa página<br>";           
            echo"</div>";   
            unset($_SESSION["erro"]);
            unset($_SESSION["erro"]);
            session_write_close(); 
            
        }
        
          
        }
       
        ?> 
               <div id="result" ></div>
            </form>
         
           
            </div>
        
    </center>
            <br>
            <br>
            <br>





<?php
$html->htmlFooter();
?>