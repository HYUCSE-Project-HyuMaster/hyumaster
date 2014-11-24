$(document).ready(function() {

	//Facebook Login 코드 시작
	$('#loginbutton').on({
		click: function() {
			FB.login(function(response){
		 		FB.getLoginStatus(function(response) {
					if (response.status === 'connected')
					{
						var request_data={
							'AccessToken': response.authResponse.accessToken
						};

						$.ajax({
							url: '/modules/login.php',
							data: request_data,
							type: 'POST',
							success: function(response){
								if(response.result==='success')
								{
									alert(response.server_message);
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
	var y=$(window).height()-50;

	var oHanyangUnivPoint = new nhn.api.map.LatLng(37.5575910, 127.0466885);
	var defaultLevel = 12;
	var oMap = new nhn.api.map.Map(document.getElementById('map'), { 
					point : oHanyangUnivPoint,
					zoom : defaultLevel,
					enableWheelZoom : true,
					enableDragPan : true,
					enableDblClickZoom : false,
					mapMode : 0,
					activateTrafficMap : false,
					activateBicycleMap : false,
					minMaxLevel : [ 11, 14 ],
					size : new nhn.api.map.Size(x,y),
			});
	var oSlider = new nhn.api.map.ZoomControl();
	oMap.addControl(oSlider);
	oSlider.setPosition({
		top : 10,
		left : 10
	});
	
	var oSize = new nhn.api.map.Size(19, 32);
	var oOffset = new nhn.api.map.Size(14, 37);
	var oIcon = new nhn.api.map.Icon('http://hyumaster.inoutsw.com/images/initial.png', oSize, oOffset);
	
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

			var request_data={
				'PostData': oTarget.getTitle()
			};

			$.ajax({
				url: '/modules/markerinfo.php',
				data: request_data,
				type: 'POST',
				success: function(response){
					if(response.result==='success')
					{
						$('#MarkerName').text(response.Name);
						
						switch(response.Property)
						{
							case 'talk':
								$('#MarkerType').text('그냥 잡담');
								break;

							case 'inform':
								$('#MarkerType').text('정보 제공');
								break;

							case 'warning':
								$('#MarkerType').text('긴급 정보 / 분실물');
								break;

							case 'initial':
								$('#MarkerType').text('건물 정보');
								break;

							default:
								$('#MarkerType').text('Unknown Marker');
								break;
						}
						
						$('#MarkerContent').html(response.Content);
						$('#MarkerTime').html(response.Time);

						$('#CurrentMarkerInfo').modal({
							keyboard: true
						});
					}
					else if(response.result==='fail')
					{
						alert(response.server_message);
					}
				}
			});

			return;
		}

		if(NewMarkerAddMode==true)
		{
			$('#NewMarkerDiv').modal({
				keyboard: true
			});

			$('#NewMarkerPosition').val(oPoint.toString());
			NewMarkerPosition=oPoint.toString();

			NewMarkerAddMode=false;
			$('#AddNewMarker').html('새로운 마커 만들기');
		}
	});

	//Marker Setup Function Definition Start
	var group1=new nhn.api.map.GroupOverlay();
	oMap.addOverlay(group1);
	var group2=new nhn.api.map.GroupOverlay();
	oMap.addOverlay(group2);
	function setMarker(latitude, longitude, name, Property, Icon)
	{
		var oMarker = new nhn.api.map.Marker(Icon, { title: name});
		var oPoint = new nhn.api.map.LatLng(latitude, longitude);
		oMarker.setPoint(oPoint);
		if(Property=='inform'||Property=='warning'||Property=='talk') group1.addOverlay(oMarker);
		else group2.addOverlay(oMarker);
		//oMap.addOverlay(oMarker);
	}
	group1.setVisible(true);
    group2.setVisible(true);
	//Marker Setup Function Definition End

	//Marker Visibility
	var zoomcheck=false;
	oMap.attach('zoom', function (oCustomEvent) {
        	 if(oMap.getLevel()==11)
        	 {
        			group1.setVisible(false);
        			group2.setVisible(true);
        			
        			if(zoomcheck==false)
        			{
        				alert('지도 축소 한계치입니다.\n\n[이벤트 안내]\n수요일까지 쓸모있는 정보를 제일 많이 올린 3분에게 문화상품권 1마원권, 그 다음 4분에게 문화상품권 5천원권 증정!');
        				zoomcheck=true;
        			}
        	 }
        	 if(oMap.getLevel()==12)
        	 {
        			group1.setVisible(true);
        			group2.setVisible(true);

        			zoomcheck=false;
        	 }
        	 if(oMap.getLevel()==13)
        	 {
        			group1.setVisible(true);
        			group2.setVisible(true);

        			zoomcheck=false;
        	 }
        	 if(oMap.getLevel()==14)
        	 {
        			group1.setVisible(true);
        			group2.setVisible(true);

        			zoomcheck=false;
        	 }
    });


	//Custom Marker Setup start
	var infoIcon = new nhn.api.map.Icon('http://hyumaster.inoutsw.com/images/sns/JungBoJaeGong.png', new nhn.api.map.Size(32, 37), oOffset);
	var talkIcon = new nhn.api.map.Icon('http://hyumaster.inoutsw.com/images/sns/DaeHwa.png', new nhn.api.map.Size(32, 37), oOffset);
	var warnIcon = new nhn.api.map.Icon('http://hyumaster.inoutsw.com/images/sns/warning.png', new nhn.api.map.Size(32, 37), oOffset);
	//Custom Marker Setup end
	
	//Initial Marker Setup Start
	$.ajax({
		url: '/modules/markerload.php',
		success: function(response){
			if(response.result==='success')
			{
				$.each(response, function(key, obj){
					if(key==='result')
						return false;

					var latitude = parseFloat(obj.latitude);
					var longitude = parseFloat(obj.longitude);
					var Name = obj.Name;
					var Property = obj.Property;

					switch(Property)
					{
						case 'inform':
							setMarker(latitude, longitude, Name, Property, infoIcon);
							break;

						case 'talk':
							setMarker(latitude, longitude, Name, Property, talkIcon);
							break;

						case 'warning':
							setMarker(latitude, longitude, Name, Property, warnIcon);
							break;

						case 'initial':
							setMarker(latitude, longitude, Name, Property, oIcon);
							break;

						default:
							setMarker(latitude, longitude, Name, Property, oIcon);
							break;
					}
				});
			}
			else if(response.result==='fail')
			{
				alert(response.server_message);
			}
		}
	});
	//Initial Marker Setup End

	//NewMarker Add Request Code Start
	var NewMarkerAddMode = false;
	var NewMarkerPosition = null;
	var NewMarkerProperty = null;

	$('#AddNewMarker').click(function() {
		alert('마커 추가를 원하는 지점을 클릭해주세요!');
		NewMarkerAddMode = true;
		NewMarkerProperty = 'talk';
		$('#NewMarkerTalk').attr('class','btn btn-primary');
		$('#NewMarkerInform').attr('class','btn btn-default');
		$('#NewMarkerLost').attr('class','btn btn-default');
		$('#AddNewMarker').html('');
	});

	$('#NewMarkerTalk').click(function() {
		NewMarkerProperty = 'talk';
		$(this).attr('class','btn btn-primary');
		$('#NewMarkerInform').attr('class','btn btn-default');
		$('#NewMarkerLost').attr('class','btn btn-default');
	});

	$('#NewMarkerInform').click(function() {
		NewMarkerProperty = 'inform';
		$('#NewMarkerTalk').attr('class','btn btn-default');
		$(this).attr('class','btn btn-info');
		$('#NewMarkerLost').attr('class','btn btn-default');
	});

	$('#NewMarkerLost').click(function() {
		NewMarkerProperty = 'warning';
		$('#NewMarkerTalk').attr('class','btn btn-default');
		$('#NewMarkerInform').attr('class','btn btn-default');
		$(this).attr('class','btn btn-danger');
	});

	$('#AddNewMarkerSubmit').click(function() {
		$('#NewMarkerDiv').modal('hide');

		var request_data={
			'Coordinate': NewMarkerPosition,
			'Title': $('#NewMarkerTitle').val(),
			'Content': $('#NewMarkerContent').val(),
			'Property': NewMarkerProperty
		};

		$.ajax({
			url: '/modules/newmarker.php',
			data: request_data,
			type: 'POST',
			success: function(response){
				if(response.result==='success')
				{
					alert(response.server_message);
					$('#NewMarkerTitle').val('');
					$('#NewMarkerContent').val('');
					document.location.href='/';
				}
				else if(response.result==='fail')
				{
					alert(response.server_message);
				}
			}
		});
	});
	//NewMarker Add Request Code End

	//Naver Map API Script End
});
