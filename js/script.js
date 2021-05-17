$(document).ready(function() { 

	// fade in body 

	$("body").css("display","none").fadeIn("slow");


  // submit form

  $("#submitForm").submit(function(){ 
  	var form = $(this); 
    var error = false; // no errors
    
    console.log('ffffff');

		form.find('input').each( function(){
			if ($(this).val() == '') {
				alert('Field "'+$(this).attr('name')+'" is empty!');
				// openModal();
				// document.getElementById('alert-text').innerHTML = 'Field "'+$(this).attr('name')+'" is empty!';
        error = true; // error
        
        console.log('error');
			}
		});

		if (!error) { 
      console.log('ffff');
			var data = form.serialize(); 
			$.ajax({ 
				type: 'POST',
				url: 'contact.php', 
				dataType: 'json',
				data: data, 
				beforeSend: function(data) { 
					form.find('button[type="submit"]').attr('disabled', 'disabled'); 
				},
				success: function(data){ 
					if (data['error']) { 
						alert(data['error']); 
					} else { 
		       			// alert('Your email has been sent! Thank you!'); 
		       			openModal();
		       			form[0].reset(); // cleaning form fields
		       		}
		       	},
		       	error: function (xhr, ajaxOptions, thrownError) { 
		            alert(xhr.status); // response from server
		            alert(thrownError); // error text
		          },
		       complete: function(data) { // event in any case
		       	form.find('button[type="submit"]').prop('disabled', false); 
		       }

		     });
		}
		return false; // disable standart submit behaviour
	});


	// open modal window

	function openModal(){
		$('#overlay').fadeIn(400,
			function(){
				$('#alert-message-block') 
				.css('display', 'flex')
				.animate({opacity: 1, top: '50%'}, 200);
			});
	}

	// close modal window
	
	$('#modal_close, #overlay').click( function(){
		$('#alert-message-block')
		.animate({opacity: 0, top: '45%'}, 200,
			function(){
				$(this).css('display', 'none');
				$('#overlay').fadeOut(400);
			}
			);
	});


});