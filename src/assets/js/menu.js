
//********MENÚ*********//
$(document).ready(function(){
	$("#todos_los_productos").click(function(e){
  		$("#principal").fadeIn('400');
		$("#principal").load('system/principal.php',function(){			
		});
          
	});

	$("#cat_productos").click(function(e){
  		$("#principal").fadeIn('400');
		$("#principal").load('system/01.cat_productos.php',function(){			
		});
          
	});

	$("#cat_categorias").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/02.cat_categorias.php',function(){
		});
	});

	$("#filtro_categorias").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/04.filtro_productos.php',function(){
		});
	});

	$("#carrito_compras").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/05.carrito_compras.php',function(){
		});
	});

	$("#mis_pedidos").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/06.mis_pedidos.php',function(){
		});
	});

	$("#datos_personales").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/07.datos_personales.php',function(){
		});
	});

	$("#header_mi_perfil").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/07.datos_personales.php');
	});
	$("#header_mis_pedidos").click(function(e){
		$("#principal").fadeIn('400');
		$("#principal").load('system/06.mis_pedidos.php');
	});

	$("#dashboard_ventas").click(function(e){ $("#principal").fadeIn('400'); $("#principal").load('system/08.dashboard_ventas.php'); });
	$("#administrar_pedidos").click(function(e){ $("#principal").fadeIn('400'); $("#principal").load('system/09.admin_pedidos.php'); });
	$("#control_stock").click(function(e){ $("#principal").fadeIn('400'); $("#principal").load('system/10.control_stock.php'); });

});

/*-------------------------C E R R A R     S E S I O N------------------------*/
	$("#cerrar_sesion").click(function() {
		$.ajax({
			url: 'actions/18.logout.php',
			type: 'POST',
			dataType: 'html',
			data: {sesion: 'close'}
		  })	
		.done(function(response) {	
			window.location.href = "./login.php";
		})
		.fail(function(xhr, desc, err) {
                  console.log(xhr);
                  console.log("Details: " + desc + "\nError:" + err);
		})
		.always(function() {
			console.log("complete");
		});	
		
	});

	$("#dashboard_sistema").click(function(e){ $("#principal").fadeIn('400'); $("#principal").load('system/11.dashboard_sistema.php'); });
	$("#gestion_usuarios").click(function(e){ $("#principal").fadeIn('400'); $("#principal").load('system/12.gestion_usuarios.php'); });
	$("#catalogo_roles").click(function(e){ $("#principal").fadeIn('400'); $("#principal").load('system/13.catalogo_roles.php'); });

/*--------------------------------------------*/
