$(document).ready(function() {
	$('#loginbutton').on({
		click: function() {
			FB.login(function(response){
		 		FB.getLoginStatus(function(response) {
					if (response.status === 'connected')
					{
						var request_data={
							'Auth_Type': 'Facebook',
							'AccessToken': response.authResponse.accessToken
						};

						$.ajax({
							url: '/modules/login.php',
							data: request_data,
							type: 'POST',
							success: function(response){
								if(response.result==='success')
								{
									alert('success');
									document.location.href='/';
								}
								else if(response.result==='fail')
								{
									alert(response.server_message);
								}
							}
						});
					}
				});
		 	});
		}
	});

	$('#logoutbutton').on({
		click: function() {
			document.location.href='/modules/logout.php';
		}
	});
});