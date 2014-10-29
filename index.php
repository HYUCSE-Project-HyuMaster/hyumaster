<!DOCTYPE html>

<html>

<head>
	<title>HyuMaster</title>
	<meta charset='utf-8'>
	<meta name='description' content='HyuMaster'>
	<meta name='author' content='한기훈'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<script src='/js/jquery-2.1.1.min.js'></script>
	<script src='/js/main.js'></script>
	<script src='/js/bootstrap.min.js'></script>
	<link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	<link href="/css/main.css" rel="stylesheet" media="screen">
	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '972582816088954',
				xfbml      : true,
				version    : 'v2.1'
			});
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
</head>

<body>
	<div id='fb-root'></div>
	
	<?php
		phpinfo();
	?>

</body>

</html>