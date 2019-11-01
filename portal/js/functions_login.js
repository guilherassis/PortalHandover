$(function(){
     $('#logar').validate({ 
           
            rules: {  
                login:{required:true
            
           
            },
                senha: { required: true
                } 
            },
            messages: {  
               
              login: { required: 'Preencha o Login!'
              
             
                },  
                
               senha: { required: 'Preencha a Senha!'
                  }
                
  
            }, 
            
            submitHandler: function( form ){  
             // alert("teste")
                var dados = $( form ).serialize();  
 
                $.ajax({  
                    type: "POST",  
                    url: "includes/controller/UsuarioController.php",  
                    data: dados,  
                    success: function( data )  
                    {  
                        if(data=="ok"){
                        	
                       window.parent.location='painel.php';
                   }else{ 
                       
                     $("#result").addClass('alert');   
                     $("#result").html(data);   
                    }  
                    }  
                });  
  
                return false;  
            }
           
            
        });  
   
        
    
    
})