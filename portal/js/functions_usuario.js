$(function(){
    
    $('#logar').validate({ 
        rules: {  
            login:{
                required:true
            },
            senha: {
                required: true
            } 
        },
        messages: {   
            login: {
                required: 'Preencha o Login!'
            },  
            senha: {
                required: 'Preencha a Senha!'
            }
        }, 
        submitHandler: function( form ){  
            var dados = $( form ).serialize();  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/UsuarioController.php",  
                data: dados,  
                success: function( data )  
                {  
                    if(data==="1"){
                        window.parent.location='mudar_senha.php';   
                    }
                    if(data==="ok"){
                        window.parent.location='cliente_manter.php';
                    }else{ 
                       
                        $("#result").addClass('alert');   
                        $("#result").html(data);   
                    }  
                }  
            });  
            return false;  
        }
    });  
   
   
    $("#voltar").click(function(){
           var novaURL = "usuario_manter.php ";
            $(window.document.location).attr('href',novaURL);
       
    });
    $("#cancelar").click(function(){
         $.ajax({  
                type: "POST",  
                url: "includes/controller/UsuarioController.php",  
                data: {acao:"inicio"},
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                   
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });
    $(".editar").click(function(){
      
        var id=$(this).val();
        
       $.ajax({  
                type: "POST",  
                url: "includes/controller/UsuarioController.php",  
                data: {id:id,acao:"editar"},
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                   
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });
   
    //$("#data").mask("99/99/9999");
    $('#data').datepicker();
    
    $("div.holder").jPages({
        containerID : "usuarios",
        previous : "←",
        next : "→",
        perPage : 6,
        delay : 6
    });
   
//Envio de comando pesquisar///////////////////////////////

  $('#search').validate({ 
           
      
            
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/UsuarioController.php",  
                data: dados,
                beforeSend: function(){
                    $('#tabela').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                  
                    $("#tabela").html(data);
                        
                }  
            });  
  
            return false;  
        }
           
            
    }); 


/////////////////////////////////////////////////
                   
                                           
    $('#form_cadastra').validate({ 
           
        rules: {  
            nome_usuario:{
                required:true
            },
            login_usuario:{
                required:true
            },
            email:{
                required:true,
                email:true
            },
             
            senha: {
                required: true
            } 
        },
        messages: {  
               
            nome_usuario: {
                required: 'Preencha o nome do usuario!'
            },  
             login_usuario:{
              required: 'Preencha o Login' 
          
             
             }, 
             email:{
              required: 'Preencha o Email',
              email: 'E-mail inválido!'
             }, 
                
           senha: {
                required: 'Preencha a Senha!'
            }               
  
        }, 
            
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/UsuarioController.php",  
                data: dados,
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                    if(data=="nok"){
                     $('#resultado').addClass('alert alert-danger');   
                    $('#resultado').html("Erro - Login já existe!");       
                        
                    
                    }else{
                    
                    $('#resultado').addClass('alert alert-success');   
                    $('#resultado').html("Cadastro realizado com sucesso! <button type='button' class='close' data-dismiss='alert'>×</button>");   
                    $("#nome_usuario").val('');
                    $("#login_usuario").val('');
                    $("#senha").val('');
                    $("#email").val('');
                    
                    
                    $("#tabela").load("/controller/UsuarioController.php?acao=buscar");
                    }
                }  
            });  
  
            return false;  
        }
           
            
    });  
        					
    $('#form_editar').validate({ 
           
        rules: {  
            nome_editar:{
                required:true
            },
           
          login_editar:{
                required:true
            },
            email_editar:{
                required:true,
                email:true
            }
             
            
        },
        messages: {  
               
            nome_editar: {
                required: 'Preencha o nome do usuario!'
            },  
            
           login_editar:{
              required: 'Preencha o Login'   
             }, 
             email_editar:{
              required: 'Preencha o Email',
              email: 'E-mail inválido!'
             } 
                
                      
  
        }, 
            
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/UsuarioController.php",  
                data: dados,
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                    $('#resultado').addClass('alert alert-success');   
                    $('#resultado').html(data);   
                    $('#voltar').html("<button class='btn' id='voltar'><i class='icon-arrow-left'></i>Voltar</button>");   
                    
                        
                }  
            });  
  
            return false;  
        }
           
            
    });  
        		
})