$(document).ready(function () {
	 
	function InitHighChart(ano)
	{
		$("#chart").html("Wait, Loading graph...");
		 var data = new Date(),
		   mes = data.getMonth(),
		  mes_ant = mes-0.5,
		  mes_pos = mes+0.5;
		var options = {
			chart: {
				renderTo: "grafico_demandas",
				type: 'column',
				margin: 75,
	            options3d: {
	                enabled: true,
	                alpha: 10,
	                beta: 25,
	                depth: 70
	            }
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				column: {
	                depth: 25
	            }
	        },
			title: {
				text: "Total de Ofertas/Mailling por Mês",
				x: -20
			},
			xAxis: {
				categories: [{}],
				plotBands: [{ // visualize the weekend
	                from: mes_ant,
	                to: mes_pos,
	                color: 'rgba(68, 170, 213, .2)'
	            }],
	            crosshair: true
			},
			yAxis: {
	            title: {
	                text: 'Total de Demandas'
	            }
	        },
			tooltip: {
	            formatter: function() {
	                var s = "<b>"+ this.x +"</b>";
	                
	                $.each(this.points, function(i, point) {
	                    s += "<br/>"+point.series.name+": "+point.y;
	                });
	                
	                return s;
	            },
	            shared: true
	        },
			series: [{color: 'rgba(13,159,140,1)',},{color: 'rgba(209,104,43,1)',}]
		};
		
		$.ajax({
			url: "includes/controller/RelatoriosController.php",
			data: {ano:ano,acao:"relatorio_grafico"},
			type:"post",
			dataType: "json",
			 beforeSend: function(){
             	$("#myModal").modal(5000);
             },
			success: function(data){
				$("#myModal").modal("hide");
				$("#grafico_demandas").addClass("well graficos");
				options.xAxis.categories = data.categories;
				options.series[0].name = "Ofertas";
				options.series[0].data = data.impression;
				options.series[1].name = "Mailling";
				options.series[1].data = data.clicks;
				var chart = new Highcharts.Chart(options);			
			}
		});
		
	}
	
	
	

	
	function IniChartHorasStatus(){
		var options = {
		 chart: {
			 renderTo: "grafico_pizza",
	            type: 'areaspline'
	        },
	        title: {
	            text: 'Horas/Mês por Status'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'left',
	            verticalAlign: 'top',
	            x: 100,
	            y: 30,
	            floating: true,
	            borderWidth: 1,
	            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
	        },
	        xAxis: {
	            categories: [
	                'Jan', 'Feb', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
	            ],
	            plotBands: [{ // visualize the weekend
	                from: 4.5,
	                to: 5.5,
	                color: 'rgba(68, 170, 213, .2)'
	            }]
	        },
	        yAxis: {
	            title: {
	                text: 'Horas'
	            }
	        },
	        tooltip: {
	            shared: true,
	            valueSuffix: ' Horas'
	        },
	        credits: {
	            enabled: false
	        },
	        plotOptions: {
	            areaspline: {
	                fillOpacity: 0.5
	            }
	        },
	        series: [{
	            name: 'Validação',
	            data: [30, 40, 30, 50, 40, 70, 30]
	        }, {
	            name: 'Construção',
	            data: [10, 30, 40, 30, 30, 50, 40]
	        },{
	            name: 'Teste',
	            data: [340, 200, 400, 300, 300, 500, 400]
	        },{
	            name: 'Implatação',
	            data: [1, 3, 4, 3, 3, 5, 4]
	        },{
	            name: 'Val. Prod',
	            data: [1, 3, 4, 3, 3, 5, 4]
	        },{
	            name: 'Reteste',
	            data: [1, 3, 4, 3, 3, 5, 4]
	        }
	                
	                ]
		
		};
		var chart = new Highcharts.Chart(options);	
	}

	
	$("#enviar_status").click(function(){
		var ano = $("#ano").val();
		InitHighChart(ano);
		IniChartHorasStatus();
});
	
	//var nowTemp = new Date();
	//var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	 var now = "2015,10,01";
	var checkin = $('#dpd1').datepicker({
	  onRender: function(date) {
	    return date.valueOf() < now.valueOf() ? 'disabled' : '';
	  }
	}).on('changeDate', function(ev) {
	  if (ev.date.valueOf() > checkout.date.valueOf()) {
	    var newDate = new Date(ev.date)
	    newDate.setDate(newDate.getDate() + 1);
	    checkout.setValue(newDate);
	  }
	  checkin.hide();
	  $('#dpd2')[0].focus();
	}).data('datepicker');
	var checkout = $('#dpd2').datepicker({
	  onRender: function(date) {
	    return date.valueOf() > checkin.date.valueOf() ? 'disabled' : '';
	  }
	}).on('changeDate', function(ev) {
	  checkout.hide();
	}).data('datepicker');
	
	$("#dpd1").mask("99/99/9999");
	$("#dpd2").mask("99/99/9999");
	
$('#form_projeto').validate({ 
        
        rules: {  
        	 dpd1: {
                 required: true
             } ,
            
        	
            dpd2:{
                required:true
            }
        },
        messages: {  
               
        	dpd1: {
                required: 'Preencha o Início'
            },
            
            dpd2: {
                required: 'Preencha o Fim!'
            }               
  
        }, 
            
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/RelatoriosController.php",  
                data: dados,
                beforeSend: function(){
                	$("#myModal").modal(5000);
                },
                success: function(data)  
                {  
                	$("#myModal").modal("hide");
                	
                    $('#resultado').html(data);   
                    $('#voltar').html("<button class='btn' id='voltar'><i class='icon-arrow-left'></i>Voltar</button>");   
                    
                        
                }  
            });  
  
            return false;  
        }
           
            
    });  
	
	
	
	$('#form_demanda').validate({ 
        
        rules: {  
        	 dpd1: {
                 required: true
             } ,
            
        	
            dpd2:{
                required:true
            }
        },
        messages: {  
               
        	dpd1: {
                required: 'Preencha o Início'
            },
            
            dpd2: {
                required: 'Preencha o Fim!'
            }               
  
        }, 
            
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/RelatoriosController.php",  
                data: dados,
                beforeSend: function(){
                	$("#myModal").modal(5000);
                },
                success: function(data)  
                {  
                	$("#myModal").modal("hide");
                    $('#resultado').html(data);   
                    $('#voltar').html("<button class='btn' id='voltar'><i class='icon-arrow-left'></i>Voltar</button>");   
                    
                        
                }  
            });  
  
            return false;  
        }
           
            
    });  
	
$('#form_execucao').validate({ 
        
        rules: {  
        	 dpd1: {
                 required: true
             } ,
            
        	
            dpd2:{
                required:true
            }
        },
        messages: {  
               
        	dpd1: {
                required: 'Preencha o Início'
            },
            
            dpd2: {
                required: 'Preencha o Fim!'
            }               
  
        }, 
            
        submitHandler: function( form ){  
               
            var dados = $( form ).serialize();  
  
            $.ajax({  
                type: "POST",  
                url: "includes/controller/RelatoriosController.php",  
                data: dados,
                beforeSend: function(){
                	$("#myModal").modal(5000);
                },
                success: function(data)  
                {  
                	
                	$("#myModal").modal("hide");
                    $('#resultado').html(data);  
                    chartExecucao(dados)
                  //  $('#voltar').html("<button class='btn' id='voltar'><i class='icon-arrow-left'></i>Voltar</button>");   
                    
                        
                }  
            });  
            return false;  
        }
           
            
    });  
	


	$('[data-toggle="popover"]').popover();
	
	
	
	
	$('input[type=radio][name=tipo]').change(function() {
	
		
        if (this.value == '2') {
            $(".cenarios").hide();
        }
        else if (this.value == '1') {
        	 $(".cenarios").show();
        }
    });
	

	
	
	
	
	
	
	
	$("#codigo").mask("99999?-99999");

	$("#codigo_editar").mask("99999?-99999");
	
	$('#cenarios').mask("99");
	$('#cenarios_editar').mask("99");
	
    $("#voltar").click(function(){
           var novaURL = "painel.php ";
            $(window.document.location).attr('href',novaURL);
       
    });
    $("#cancelar").click(function(){
         $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
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
                url: "includes/controller/CadastrarController.php",  
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
   
    
    $(".detalhar").click(function(){
        
        var id=$(this).val();
          
       $.ajax({  
                type: "POST",  
                url: "includes/controller/CadastrarController.php",  
                data: {id:id,acao:"detalhar"},
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
        containerID : "clientes",
        previous : "←",
        next : "→",
        perPage : 6,
        delay : 6
    });
   
                  
    
});
        
         