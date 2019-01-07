	//datos de prueba
	var color = 1;
	var datos = [{diente:1,cara:1,estado:8,tipo:1},
				 {diente:2,cara:2,estado:2,tipo:1},
				 {diente:2,cara:5,estado:1,tipo:1},
				 {diente:3,cara:2,estado:6,tipo:1},
				 {diente:4,cara:2,estado:4,tipo:1}];

	$(document).ready(function(){

		$('#diente_grande polygon').on('click',function(){				// HAGO CLICK EN LAS CARAS DEL DIENTE
			var desabilitado = $(this).attr('class');	// CARGO EL VALOR DE LA CLASS DEL DIENTE
			if (desabilitado != 'desabilitado' ) {		
				pintar(color,this)						// SI EL VALOR DE CLASS NO ES DESABILITADO LO PINTAMOS
			}		
		});
		$('polygon').on('click',function(){
/* 			console.log("hola mundo");
			alert("ventana"); */
		});
		$('input:radio').change(function(){				// CAMBIO DE TIPO DE ODONTOGRAMA - DESIDUA - DESIDUA MIXTA - NIÑO
			var tipo = $(this).attr('value');			// CARGO EL VALOR DE VALUE PARA CAMBIAR EL TIPO DE ODONTOGRAMA
			cambiarOdontograma(tipo);			
		});
		$('.color').click(function(){					// DOY CLICK EN LAS OPCIONES DE TRATAMIENTOS
			color = $(this).attr('value');				// CARGO EL COLOR DONDE DI CLICK 
		});
		$('#ver').click(function(){							// DOY CLICK EN EL BOTON VER
			var saltarEachCirculo = null;					// FLAG PARA ENCONTRAR DIBUJOS CON CIRCULOS
			var saltarEachPoligono = null;					// FLAG PARA ENCONTRAR DIBUJOS CON POLIGONOS
			limpiar();										// LIMPIAMOS TODO EL ODONTOGRAMA
			cambiarOdontograma(datos[0].tipo)	
			for (var i = 0; i < datos.length; i++) {		// CARGAMOS LOS DATOS EN EL ODONTOGRAMA --- VARIABLE [DATOS] DEL INICIO
				if (datos[0].tipo == 1) {
					$('#Permanente').prop('checked',true);
				}
				else if (datos[0].tipo == 2) {
					$('#Niños').prop('checked',true);
				}
				else
				{
					$('#Mixta').prop('checked',true);
				}			
				saltarEachCirculo = false;
				saltarEachPoligono = false;
				if (datos[i].estado == 3 || datos[i].estado ==  8) {		// SI EL DIENTE TIENE ENDODONCIA O CORONA
					$('#'+datos[i].diente +' circle').each(function(){
						if (saltarEachCirculo == false) {
							pintar(datos[i].estado,this);
							saltarEachCirculo = true;
						}
					});
				}
				else if (datos[i].estado == 4 || datos[i].estado ==  6) 	// SI EL DIENTE ES AUSENTE O IMPLANTE
				{
					$('#'+datos[i].diente +' polygon').each(function(){
						if (saltarEachPoligono == false) {
							pintar(datos[i].estado,this);
							saltarEachPoligono = true;
						}
					});	
				}
				else
				{
					$('#'+datos[i].diente +' polygon').each(function(){		// CUALQUIER OTRO ESTADO DEL DIENTE

						if (datos[i].cara == $(this).attr('value')) {
							pintar(datos[i].estado,this);
						}
					});	
				}			
			}				
	});
	// FUNCTION PARA AGREGAR AL ODONTOGRAMA 
	$('#agregar').click(function(){
		datos = [];
		$('svg').each(function(){
			var dienteD = $(this).attr('id');
			entrarEach = false;
			$(this).find('.marcado').each(function(){
				var caraD = $(this).attr('value');
				var estadoD = $(this).attr('estado');
				var tipoD = $('input:radio[name=tipo]:checked').val();
				if ((estadoD == 3 || estadoD == 4 || estadoD == 6 || estadoD == 8)) {
					datos.push({diente:dienteD,cara:caraD,estado:estadoD,tipo:tipoD});
					return false;
				}
				else 
				{
					datos.push({diente:dienteD,cara:caraD,estado:estadoD,tipo:tipoD});
				}
				
			});
		});
	});
	$('#limpiar').click(function(){
		limpiar();
	});
	//cambiarOdontograma($('input:radio[name=tipo]:checked').val());
	cambiarOdontograma(1);
	});
	// FIN DE LA CARGA INICIAL - DOCUMENT READY
	
	// ACTIVA Y DESACTIVA LOS DIENTES SEGUN EL TIPO DE ODONTOGRAMA
	function activar_Desactivar_Dientes(lado,ad,valor) // ad => 1 habilitado 0 deshabilitado 
	{
		if (ad == 1 && valor < 6) {
			$(lado).attr('class','diente');
		}
		else if (ad == 0 && valor < 6) {
			$(lado).attr('class','desabilitado');
		}
	}
	// CAMBIAMOS EL TIPO DE ODONTOGRAMA PARA HABILITAR Y DESHABILITAR LOS DIENTES
	function cambiarOdontograma(tipo)
	{	
		var valor=null;
		if (tipo == 1) {			// DENTADURA PERMANENTE
			$('.permanente polygon').each(function(){
				valor = $(this).attr('value');
				activar_Desactivar_Dientes(this,1,valor);
				quitarEspecial(this);
			});
			$('.nino polygon').each(function(){
				valor = $(this).attr('value');
				activar_Desactivar_Dientes(this,0,valor);
				quitarEspecial(this);
			});
		}
		else if (tipo == 2) {		// DENTADURA NIÑO
			$('.permanente polygon').each(function(){
				valor = $(this).attr('value');
				activar_Desactivar_Dientes(this,0,valor);
				quitarEspecial(this);
			});
			$('.nino polygon').each(function(){
				valor = $(this).attr('value');
				activar_Desactivar_Dientes(this,1,valor);
				quitarEspecial(this);
			});
		}
		else if (tipo == 3) {		// DENTADURA MIXTA
			$('.permanente').each(function(){
				var id = $(this).attr('id');
				if ((id > 3 && id < 14) ||  (id > 19 && id < 30) ) {
					$(this).find('polygon').each(function(){
						valor = $(this).attr('value');
						activar_Desactivar_Dientes(this,0,valor);	
						quitarEspecial(this);						
					});
				}
				else
				{
					$(this).find('polygon').each(function(){
						valor = $(this).attr('value');
						activar_Desactivar_Dientes(this,1,valor);	
						quitarEspecial(this);						
					});
				}	
			});
			$('.nino polygon').each(function(){
				valor = $(this).attr('value');
				activar_Desactivar_Dientes(this,1,valor);
				quitarEspecial(this);
			});
		}		
	}
	// FUNCTION PARA LIMPIAR TODOS LOS DIENTES
	function limpiar(){
		$('svg').each(function(){
			$(this).find('.marcado').each(function(){
				var estado = $(this).attr('estado');

				if (estado != 3 && estado != 4 && estado != 6 && estado != 8) {
					$(this).attr('class','diente');
				}
				else if(estado == 3) {
					$(this).attr('class','endodoncia');
				}
				else if(estado == 4) {
					$(this).attr('class','ausente');
				}
				else if(estado == 6) {
					$(this).attr('class','implante');
				}
				else if(estado == 8) {
					$(this).attr('class','corona');
				}
			});
		});
	}
	// QUITAMOS AUSENTE - IMPLANTE - CORONA - ENDODONCIA (APLICADO A TODAS LAS CARAS)
	function quitarEspecial(objeto)
	{
		$(objeto).parent().find('polygon').each(function(){
				if ($(this).attr('value') >= 6 && $(this).attr('value') <= 7  ) {
					$(this).attr('class','ausente');
				}
				else if ($(this).attr('value') == 10) {
					$(this).attr('class','implante');
				}
		});	
		$(objeto).parent().find('circle').each(function(){
				if ($(this).attr('value') == 8 ) {
					$(this).attr('class','corona');
				}
				else if ($(this).attr('value') == 9) {
					$(this).attr('class','endodoncia');
				}				
		});
	}
	// LIMPIAMOS TODOS LOS LADOS DEL DIENTE
	function limpiarLados(objeto)		// DESDE CARA 1 HASTA CARA 5
	{
		$(objeto).parent().find('polygon').each(function(){
				if ($(this).attr('value') < 6 ) {
					$(this).attr({class:'diente',
								  estado:0});
				}
			});	
	}
	// PINTAMOS LOS DIENTES 
	function pintar(color,objeto){
		if (color == 1) {												// --- AMALGAMA ---
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).attr({class:'marcadoRojo marcado',				// PINTAR COLOR ROJO
							estado:color});		}
		else if(color == 2){											// --- CARIES ---
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).attr({class:'marcadoAmarillo marcado',			// PINTAR COLOR AMARILLO
							estado:color});
		}
		else if(color == 3){											// --- ENDODONCIA --- 
			limpiarLados(objeto);										// LIMPIAMOS TODOS LOS LADOS
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).parent().find('.endodoncia').each(function(){
				$(this).attr({class:'marcadoNaranja marcado',			// PINTAR COLOR NARANJA
							estado:color});
			});
		}
		else if(color == 4){											// --- AUSENTE ---
			limpiarLados(objeto);										// LIMPIAMOS TODOS LOS LADOS
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).parent().find('.ausente').each(function(){
				$(this).attr({class:'marcadoTomate marcado',			// PINTAR TOMATE
							estado:color});
			});

		}
		else if(color == 5){											// --- RESINA ---
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).attr({class:'marcadoMarron marcado',				// PINTAR COLOR MARRON
							estado:color});

		}
		else if(color == 6){											// --- IMPLANTE ---
			limpiarLados(objeto);										// LIMPIAMOS TODOS LOS LADOS	
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).parent().find('.implante').each(function(){
				$(this).attr({class:'marcadoMorado marcado',			// PINTAR COLOR MORADO
							estado:color});
			});
		}
		else if(color == 7){											// --- SELLANTE ---
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).attr({class:'marcadoVerde marcado',				// PINTAR COLOR VERDE
							estado:color});
		}
		else if(color == 8){											// --- CORONA ---
			limpiarLados(objeto);										// LIMPIAMOS TODOS LOS LADOS
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).parent().find('.corona').each(function(){
				$(this).attr({class:'marcadoAzul marcado',				// PINTAR COLOR AZUL
							estado:color});
			});
		}
		else if(color == 9){											// --- NORMAL ---
			quitarEspecial(objeto);										// QUITAMOS ESPECIALES
			$(objeto).attr({class:'diente',								// PINTAR COLOR NEGRO
							estado:color});
		}
	}


