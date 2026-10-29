
//********MENÚ*********//
$(document).ready(function(){
	$("#todos_los_productos").click(function(e){
  		$("#principal").fadeIn('400');
		$("#principal").load('system/principal.php',function(){			
		});
          
	});

	$("#cat_productos").click(function(e){
  		$("#principal").fadeIn('400');
		$("#principal").load('system/cat_productos.php',function(){			
		});
          
	});

});

/*-------------------------C E R R A R     S E S I O N------------------------*/
	$("#cerrar_sesion").click(function() {
		$.ajax({
			url: '_actions/cerrar_sesion.php',
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

/*--------------------------------------------*/
