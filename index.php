<!DOCTYPE html>

<html>

<head>
	<title>HyuMaster</title>
	<meta charset='utf-8'>
	<meta name='description' content='HyuMaster'>
	<meta name='author' content='한기훈'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
	<script src='/js/jquery-2.1.1.min.js'></script>
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
	<script src='//openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=311f555d1d9250996c08b0f69e8aee28'></script>
	<script src='/js/main.js'></script>
	<?php
		require('./modules/initialize.php');
	?>
</head>

<body>
	<div id='fb-root'></div>

	<!--상단바 부분 시작-->
	<div class='navbar navbar-default navbar-fixed-top'>
		<div class='container'>

			<!--제목 부분 시작-->
			<div class='navbar-header'>
				<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>
				<a class='navbar-brand' href='/'><strong>HYU Master</strong></a>
			</div>
			<!--제목 부분 종료-->

			<!--네비게이션 바(메뉴) 부분 시작-->
			<div class='navbar-collapse collapse'>
				<ul class='nav navbar-nav'>
					<!--임시 삭제 부분
					<li class='active'><a href='#'>Home</a></li>
					-->
					<li class='dropdown'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Menu <b class='caret'></b></a>
					<ul class='dropdown-menu'>
						<li><a href='#' data-toggle="modal" data-target="#myModal">Action</a></li>
						<li class='divider'></li>
						<li class='dropdown-header'>Nav header</li>
						<li><a href='#'>Separated link</a></li>
					</ul>
					</li>
				</ul>
				<ul class='nav navbar-nav navbar-right'>
					<?php
						if(isset($_SESSION['login_state']) && $_SESSION['login_state']==true)
							echo "<li class='active'><a href='#' id='logoutbutton'>로그아웃</a></li>";
						else
							echo "<li class='active'><a href='#' id='loginbutton'>로그인</a></li>";
					?>
				</ul>
			</div>
			<!--네비게이션 바(메뉴) 부분 종료-->

		</div>
	</div>
	<!--상단바 부분 종료-->

	<!--빈 공간-->
	<div id='emptyspace'></div>

	<!--지도 삽입 부분 시작-->
	<div id='map'></div>
	<!--지도 삽입 부분 종료-->

	<div class='container'>
		<?php
			if(isset($_SESSION['login_state']) && $_SESSION['login_state']==true)
			{
				echo "
					<!--마커 생성 요청용 화면-->
					<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
									<h4 class='modal-title'>Marker 추가 요청</h4>
								</div>
								<div class='modal-body'>
									<form role='form'>
										<div class='form-group'>
											<label>마커 위치 좌표</label>
											<input type='text' class='form-control' id='NewMarkerPosition' readOnly>
										</div>

										<div class='form-group'>
											<label>마커 이름</label>
											<input type='text' class='form-control' id='NewMarkerTitle' placeholder='제목 입력'>
										</div>

										<div class='form-group'>
											<label>마커 정보</label>
											<textarea class='form-control' id='NewMarkerContent' rows='3' placeholder='내용 입력'>
										</div>

										<button type='submit' class='btn btn-default'>Submit</button>
									</form>
								</div>
								<div class='modal-footer'>
									<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
									<button type='button' class='btn btn-primary'>Submit</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
				";
			}
		?>
	</div>

</body>

</html>
