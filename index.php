<!DOCTYPE html>

<html>

<head>
	<title>HyuMaster</title>
	<meta charset='utf-8'>
	<meta name='description' content='HyuMaster'>
	<meta name='author' content='한기훈'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
	<script src='/js/jquery-2.1.1.min.js'></script>
	<script src='/js/main.js'></script>
	<script src='/js/bootstrap.min.js'></script>
	<link href='/css/bootstrap.min.css' rel='stylesheet' media='screen'>
	<link href='/css/bootstrap-theme.min.css' rel='stylesheet' media='screen'>
	<link href='/css/main.css' rel='stylesheet' media='screen'>
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
			js.src = '//connect.facebook.net/ko_KR/sdk.js';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<?php
		require('./modules/initialize.php');
	?>
</head>

<body>
	<div id='fb-root'></div>

	<div id='emptyspace'></div>

	<div class='navbar navbar-default navbar-fixed-top'>
		<div class='container'>
			<div class='navbar-header'>
				<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>
				<a class='navbar-brand' href='#'>HyuMaster</a>
			</div>
			<div class='navbar-collapse collapse'>
				<ul class='nav navbar-nav'>
					<li class='active'><a href='#'>Home</a></li>
					<li><a href='#'>Preparing..</a></li>
					<li><a href='#'>Preparing..</a></li>
					<li class='dropdown'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Dropdown <b class='caret'></b></a>
					<ul class='dropdown-menu'>
						<li><a href='#'>Action</a></li>
						<li><a href='#'>Another action</a></li>
						<li><a href='#'>Something else here</a></li>
						<li class='divider'></li>
						<li class='dropdown-header'>Nav header</li>
						<li><a href='#'>Separated link</a></li>
						<li><a href='#'>One more separated link</a></li>
					</ul>
					</li>
				</ul>
				<ul class='nav navbar-nav navbar-right'>
					<li><a href='#'>Test1</a></li>
					<li><a href='#'>Test2</a></li>
					<?php
						if(isset($_SESSION['login_state']) && $_SESSION['login_state']==true)
							echo "<li class='active'><a href='#' id='loginbutton'>로그아웃</a></li>";
						else
							echo "<li class='active'><a href='#' id='loginbutton'>로그인</a></li>";
					?>
				</ul>
			</div>
		</div>
	</div>

	<div class='container'>

		<div class='jumbotron'>
			<h1>HyuMaster now in construction</h1>
		</div>

	</div>

</body>

</html>