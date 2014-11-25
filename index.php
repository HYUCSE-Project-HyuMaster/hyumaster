<!DOCTYPE html>

<html>

<head>
	<title>HyuMaster</title>
	<meta charset='utf-8'>
	<meta name='description' content='한양대 테크노경영학 프로젝트 HyuMaster'>
	<meta name='author' content='한기훈'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
	<script src='/js/jquery-2.1.1.min.js'></script>
	<script src='/js/bootstrap.min.js'></script>
	<link href='/css/bootstrap.min.css' rel='stylesheet' media='screen'>
	<link href='/css/bootstrap-theme.min.css' rel='stylesheet' media='screen'>
	<link href='/css/main.css' rel='stylesheet' media='screen'>
	<link rel="shortcut icon" href="/images/favicon.ico">
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
				<a class='navbar-brand' href='/'><strong>HYU Master</strong>&nbsp;&nbsp;<div class="fb-like" data-href="http://hyumaster.inoutsw.com/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div></a>
			</div>
			<!--제목 부분 종료-->

			<!--네비게이션 바(메뉴) 부분 시작-->
			<div class='navbar-collapse collapse'>
				<ul class='nav navbar-nav'>
					<?php
						if(isset($_SESSION['login_state']) && $_SESSION['login_state']==true)
						{
							echo "
									<li><a href='#' id='AddNewMarker'>새로운 마커 만들기</a></li>
							";
						}
					?>
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
					<div class='modal fade' id='NewMarkerDiv' role='dialog' aria-hidden='true'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
									<h4 class='modal-title'>새로운 정보 등록</h4>
								</div>
								<div class='modal-body'>
									<form role='form'>
										<div class='form-group'>
											<label>위치 좌표</label>
											<input type='text' class='form-control' id='NewMarkerPosition' readOnly>
										</div>

										<div class='form-group'>
											<label>제목 입력</label>
											<input type='text' class='form-control' id='NewMarkerTitle' placeholder='제목 입력'>
										</div>

										<div class='form-group'>
											<label>유형 선택</label></br>
											<div class='btn-group'>
											  <button type='button' id='NewMarkerTalk' class='btn btn-default'>잡담</button>
											  <button type='button' id='NewMarkerInform' class='btn btn-default'>정보 제공</button>
											  <button type='button' id='NewMarkerLost' class='btn btn-default'>긴급 제보 / 분실물</button>
											</div>
										</div>

										<div class='form-group'>
											<label>내용 입력</label>
											<textarea class='form-control' id='NewMarkerContent' rows='4' placeholder='[잡담]은 1일, [정보 제공]은 5일, [긴급 제보/분실물]은 7일 동안 유지됩니다.'></textarea>
										</div>
									</form>
								</div>
								<div class='modal-footer'>
									<button type='button' class='btn btn-default' data-dismiss='modal'>닫기</button>
									<button type='button' class='btn btn-success' id='AddNewMarkerSubmit'>마커 생성</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
				";
			}
		?>

		<div class='modal fade' id='CurrentMarkerInfo' role='dialog' aria-hidden='true'>
			<div class='modal-dialog'>
				<div class='modal-content'>

					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
						<h4 class='modal-title'><strong>정보</strong></h4>
					</div>

					<div class='modal-body'>
						<form role='form'>
							<div class='form-group'>
								<label><strong><font color='#000000'>제목</font></strong></label>
								<div id='MarkerName'></div>
							</div>

							<hr>

							<div class='form-group'>
								<label><strong><font color='#0100FF'>등록시간</font></strong></label>
								<div id='MarkerTime'></div>
							</div>

							<hr>

							<div class='form-group'>
								<label><strong><font color='#ED4C00'>유형</font></strong></label>
								<div id='MarkerType'></div>
							</div>

							<hr>
							
							<div class='form-group'>
								<label><strong><font color='#47C83E'>내용</font></strong></label>
								<div id='MarkerContent'></div>
							</div>
						</form>
					</div>

					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>닫기</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 휴마스터하단광고 -->
		<style>
			.adsbygoogle {
				display: inline-block;
				width: 100%;
				height: 50px;
			}
		</style>
		<ins class="adsbygoogle" data-ad-client="ca-pub-8652224314979074" data-ad-slot="4989212707"></ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
	</div>

</body>

</html>