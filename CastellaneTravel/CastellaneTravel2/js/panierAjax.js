$(function() {
	$('#prod1').click(function() {
		
		var nameobject = "toto";
		var priceobject = "12";

		$.ajax({
			method: "POST",
			url: "../include/panier.php",
			data:{ 
				nameobject: nameobject,
				priceobject: priceobject
			},
			dataType: "html"
		});
		$('#object').append("<p>" + nameobject +  "</p>"); // on ajoute le message dans la zone prévue
		$('#price').append("<p>" + priceobject +  "</p>"); // on ajoute le message dans la zone prévue
		
	});  
});
