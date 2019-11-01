/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
   	
	$('[data-toggle="popover"]').popover();
	
	
	
	
	
	var status = $("#status").val();
	var sub_status = $("#sub_status").val();
	
	
	
	
		
	$("#enviar_status").click(function(){
		
		var id_responsavel=$("#responsavel").val();
		 var id_status=$('#status').val();
		 var id_demanda = $('#id_demanda').val();
		 var id_sub = $('#sub').val();
		 $("#enviar_status").prop( "disabled", true );
	       $.ajax({  
	                type: "POST",  
	                url: "includes/controller/CadastrarController.php",  
	                data: {id_demanda:id_demanda,id_responsavel: id_responsavel, id_status: id_status, id_sub:id_sub, acao:"alterar_status"},
	                beforeSend: function(){
	                	$("resultado_status").html("<img src='img/loading.gif'/>");
	                },
	                success: function(data)  
	                {  
	                	
	                	$("#resultado_status").addClass('label label-success span3');
	                    $("#resultado_status").html(data);
	                        
	                }  
	            });  
     
 });
	
	$("#enviar_sub_status").click(function(){
		
		var id_responsavel=$("#responsavel").val();
		 var id_status=$('#status').val();
		 var id_demanda = $('#id_demanda').val();
		 var id_sub = $('#sub').val();
		 $("#enviar_sub_status").prop( "disabled", true );
	       $.ajax({  
	                type: "POST",  
	                url: "includes/controller/CadastrarController.php",  
	                data: {id_responsavel: id_responsavel,id_demanda:id_demanda, id_status: id_status, id_sub:id_sub, acao:"alterar_status"},
	                beforeSend: function(){
	                	$("resultado_sub_status").html("<img src='img/loading.gif'/>");
	                },
	                success: function(data)  
	                {  
	                	
	                	$("#resultado_status").addClass('label label-success span3');
	                    $("#resultado_status").html(data);
	                        
	                }  
	            });  
    
});
	
	
	$("#codigo").mask("99999?-99999");

	$("#codigo_editar").mask("99999?-99999");
	
	$('#cenarios').mask("9?9");
	$('#cenarios_editar').mask("9?9");
	
    $("#voltar").click(function(){
           var novaURL = "painel.php";
            $(window.document.location).attr('href',novaURL);
       
    });
    
    $("#cancelar").click(function(){
         $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {acao:"cancelar"},
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
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"editar"},
                beforeSend: function(){
                	$("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                	$("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });

  
    $("#enviar_requisitosFrente_editar").click(function(){
        
        var frenteTrabalho=$("#frenteTrabalho").val();
         var requisitosFuncionais=$('#requisitosFuncionais').val();
         var id = $('#id').val();
      //$("#enviar_requisitosFrente_editar").prop( "disabled", true );
                    $.ajax({  
                    type: "POST",  
                    url: "includes/controller/CadastrarController.php",  
                    data: {id:id,frenteTrabalho: frenteTrabalho, requisitosFuncionais: requisitosFuncionais, acao:"alterar_RequisitosFrentes"},
                    beforeSend: function(){
                        $("resultado_status").html("<img src='img/loading.gif'/>");
                    },
                    success: function(data)  
                    {  
                        
                        $("#resultado_status").addClass('label label-success span3');
                        $("#resultado_status").html(data);
                            
                    }  
                });  
     
 });

    

     $(".frenteRequisito").click(function(){
      
        var id=$(this).val();
          
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"frenteRequisito"},
                beforeSend: function(){
                    $("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                    $("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });


     $(".frenteRequisito_editar").click(function(){
      
        var id=$(this).val();
          
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"frenteRequisito_alterar_Visualizar"},
                beforeSend: function(){
                    $("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                    $("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });

     $(".frenteRequisito_alterar_Visualizar").click(function(){
      
        var id=$(this).val();
          
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"frenteRequisito_alterar_Visualizar"},
                beforeSend: function(){
                    $("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                    $("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });

      $(".frenteRequisito_editar_Visualizar").click(function(){
      
        var id=$(this).val();
          
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"frenteRequisito_editar_Visualizar"},
                beforeSend: function(){
                    $("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                    $("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });
   
    
    $(".detalhar").click(function(){
        
        var id=$(this).val();
     //   window.parent.location='detalhar.php?id='+id;
        
        
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"detalhar"},
                beforeSend: function(){
                	$("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                	$("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });
    
$("#refresh").click(function(){
        
        var id=$(this).val();
        
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"detalhar"},
                beforeSend: function(){
                	$("#aguardaModal").modal();
                },
                success: function(data)  
                {  
                	
                	$("#aguardaModal").modal("hide");
                    $("#corpo").html(data);
                        
                }  
            });  
        
    });
    
    
    //$("#data").mask("99/99/9999");
    $('#data').datepicker();
    
    $("div.holder").jPages({
        containerID : "clientes",
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
                url: "includes/controller/CadastrarController.php",  
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
                       
                       
                       
    
  var validate=  $('#form_cliente').validate({ 
           
                    
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
        //  alert(dados);
            $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: dados,
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                
                success: function(data)  
                {  
                    $('#resultado').addClass('alert alert-success');   
                    $('#resultado').html(data);   
                    validate.resetForm();
                    $('form').get(0).reset();
                        
                }  
            });  
  
            return false;  
        }
           
            
    });  
        					
    $('#form_cliente_editar').validate({ 
           
                    
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
          //alert(dados);
            $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
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
        	


    $('#form_frenteRequisitos').validate({ 
           
                    
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
          //alert(dados);
            $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: dados,
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                    $('#resultado').addClass('alert alert-success');   
                    $('#resultado').html(data);   
                       
                    
                        
                }  
            });  
  
            return false;  
        }
           
            
    });  				
    

     $('#form_frenteRequisitos_editar').validate({ 
           
                    
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
          //alert(dados);
            $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: dados,
                beforeSend: function(){
                    $('#resultado').html("<img src='img/loading.gif'/>");
                },
                success: function(data)  
                {  
                    $('#resultado').addClass('alert alert-success');   
                    $('#resultado').html(data);   
                                       
                        
                }  
            });  
  
            return false;  
        }
           
            
    }); 
                   
    
});
        
         