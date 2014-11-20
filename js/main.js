$(document).ready(function() {

	//Facebook Login 코드 시작
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
	//Facebook Login 코드 끝


	//Logout 코드 시작
	$('#logoutbutton').on({
		click: function() {
			document.location.href='/modules/logout.php';
		}
	});
	//Logout 코드 끝


	//Naver Map API Script Start
	var x=$(window).width();
	var y=$(window).height()-51;

	var oHanyangUnivPoint = new nhn.api.map.LatLng(37.5575910, 127.0466885);
	var defaultLevel = 11;
	var oMap = new nhn.api.map.Map(document.getElementById('map'), { 
					point : oHanyangUnivPoint,
					zoom : defaultLevel,
					enableWheelZoom : true,
					enableDragPan : true,
					enableDblClickZoom : true,
					mapMode : 0,
					activateTrafficMap : false,
					activateBicycleMap : false,
					minMaxLevel : [ 9, 14 ],
					size : new nhn.api.map.Size(x,y)
			});
	var oSlider = new nhn.api.map.ZoomControl();
	oMap.addControl(oSlider);
	oSlider.setPosition({
		top : 10,
		left : 10
	});
	
	var oSize = new nhn.api.map.Size(28, 37);
	var oOffset = new nhn.api.map.Size(14, 37);
	var oIcon = new nhn.api.map.Icon('//static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);
	
	var oInfoWnd = new nhn.api.map.InfoWindow();
	oInfoWnd.setVisible(false);
	oMap.addOverlay(oInfoWnd);
	
	oInfoWnd.setPosition({
		top : 20,
		left :20
	});
	
	var oLabel = new nhn.api.map.MarkerLabel(); // - 마커 라벨 선언.
	oMap.addOverlay(oLabel); // - 마커 라벨 지도에 추가. 기본은 라벨이 보이지 않는 상태로 추가됨.
	oInfoWnd.attach('changeVisible', function(oCustomEvent) {
		if (oCustomEvent.visible) {
			oLabel.setVisible(false);
		}
	});
	
	var oPolyline = new nhn.api.map.Polyline([], {
		strokeColor : '#f00', // - 선의 색깔
		strokeWidth : 5, // - 선의 두께
		strokeOpacity : 0.5 // - 선의 투명도
	}); // - polyline 선언, 첫번째 인자는 선이 그려질 점의 위치. 현재는 없음.
	oMap.addOverlay(oPolyline); // - 지도에 선을 추가함.

	oMap.attach('mouseenter', function(oCustomEvent) {
		var oTarget = oCustomEvent.target;
		// 마커위에 마우스 올라간거면
		if (oTarget instanceof nhn.api.map.Marker) {
			var oMarker = oTarget;
			oLabel.setVisible(true, oMarker); // - 특정 마커를 지정하여 해당 마커의 title을 보여준다.
		}
	});

	oMap.attach('mouseleave', function(oCustomEvent) {
		var oTarget = oCustomEvent.target;
		// 마커위에서 마우스 나간거면
		if (oTarget instanceof nhn.api.map.Marker) {
			oLabel.setVisible(false);
		}
	});

	oMap.attach('click', function(oCustomEvent) {
		var oPoint = oCustomEvent.point;
		var oTarget = oCustomEvent.target;
		oInfoWnd.setVisible(false);
		// 마커 클릭하면
		if (oTarget instanceof nhn.api.map.Marker) {
			// 겹침 마커 클릭한거면
			if (oCustomEvent.clickCoveredMarker) {
				return;
			}
			// - InfoWindow 에 들어갈 내용은 setContent 로 자유롭게 넣을 수 있습니다. 외부 css를 이용할 수 있으며, 
			// - 외부 css에 선언된 class를 이용하면 해당 class의 스타일을 바로 적용할 수 있습니다.
			// - 단, DIV 의 position style 은 absolute 가 되면 안되며, 
			// - absolute 의 경우 autoPosition 이 동작하지 않습니다.
			/*
			oInfoWnd.setContent('<DIV style="border-top:1px solid; border-bottom:2px groove black; border-left:1px solid; border-right:2px groove black;margin-bottom:1px;color:black;background-color:white; width:auto; height:auto;">'+
				'<span style="color: #000000 !important;display: inline-block;font-size: 12px !important;font-weight: bold !important;letter-spacing: -1px !important;white-space: nowrap !important; padding: 2px 5px 2px 2px !important">' + 
				'Hello World <br /> ' + oTarget.getPoint()
				+'<span></div>');
			*/
			oInfoWnd.setContent('<div style="width: 200px; height: 100px; background-color: white; border: 1px solid black">TEST</div>');
			oInfoWnd.setPoint(oTarget.getPoint());
			oInfoWnd.setPosition({right : 15, top : 30});
			oInfoWnd.setVisible(true);
			oInfoWnd.autoPosition();
			return;
		}
		/*
		var oMarker = new nhn.api.map.Marker(oIcon, { title : '마커 : ' + oPoint.toString() });
		oMarker.setPoint(oPoint);
		oMap.addOverlay(oMarker);
		var aPoints = oPolyline.getPoints(); // - 현재 폴리라인을 이루는 점을 가져와서 배열에 저장.
		aPoints.push(oPoint); // - 추가하고자 하는 점을 추가하여 배열로 저장함.
		oPolyline.setPoints(aPoints); // - 해당 폴리라인에 배열에 저장된 점을 추가함
		*/
	});

	//Initial Marker Setup Start
	function setMarker(latitude, longitude, name)
	{
		var oMarker = new nhn.api.map.Marker(oIcon, { title: name});
		var oPoint = new nhn.api.map.LatLng(latitude, longitude);
		oMarker.setPoint(oPoint);
		oMap.addOverlay(oMarker);
	}
	
	setMarker(37.5586678, 127.0423971, '의대');
	setMarker(37.5584197, 127.0434912, '인문관');
	setMarker(37.558795, 127.0442962, '자과대');
	setMarker(37.5580927, 127.0451949, '사범대');
	setMarker(37.5575795, 127.0441677, '학생회관');
	setMarker(37.5573469, 127.044613, '사과대');
	setMarker(37.5573419, 127.045649, '중도');
	setMarker(37.5560417, 127.043868, '애지문');
	setMarker(37.5566057, 127.0445473, '신본관');
	setMarker(37.556063, 127.0447431, '구본관');
	setMarker(37.5543599, 127.044176, '토목관');
	setMarker(37.5555586, 127.0453088, '노천');
	setMarker(37.5556885, 127.0462704, '2공');
	setMarker(37.556611, 127.0459115, '싸군');
	setMarker(37.5565579, 127.0456967, '1공');
	setMarker(37.556655, 127.0468114, '생과대');
	setMarker(37.5564528, 127.0481373, '법대');
	setMarker(37.5567861, 127.0487942, '경금대');
	setMarker(37.5565724, 127.0499707, '올림픽체육관');
	setMarker(37.5558851, 127.0493578, 'ITBT');
	setMarker(37.5554683, 127.0476054, '대운동장');
	setMarker(37.5547195, 127.0474345, 'FTC');
	setMarker(37.5548497, 127.0461396, '공업센터');
	setMarker(37.5545576, 127.0451938, '신소재');
	setMarker(37.5577022, 127.0467541, 'HIT');
	setMarker(37.5576011, 127.0486138, '행원파크');
	setMarker(37.5581749, 127.0482933, '경영대');
	setMarker(37.5564702, 127.0439899, '한양플라자');
	//Initial Marker Setup End

	//Naver Map API Script End

});