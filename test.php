<!DOCTYPE html>

<html>

<head>
	<title>Map API test</title>
	<meta charset='utf-8'>
	<meta name='description' content='HyuMaster'>
	<meta name='author' content='한기훈'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
	<script src='/js/jquery-2.1.1.min.js'></script>
	<script src='//openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=311f555d1d9250996c08b0f69e8aee28'></script>
</head>

<body>
	<script>

		nhn.api.map.Map(map : "Test", {
			point : Coord, // 지도 중심점의 좌표
			zoom : 5, // 지도의 축척 레벨
			boundary : ['1','2'],// 지도 생성 시 주어진 array 에 있는 점이 모두 보일 수 있도록 지도를 초기화한다.
			boundaryOffset : 5, // boundary로 지도를 초기화 할 때 지도 전체에서 제외되는 영역의 크기.
			enableWheelZoom : true, // 마우스 휠 동작으로 지도를 확대/축소할지 여부
			enableDragPan : true, // 마우스로 끌어서 지도를 이동할지 여부
			enableDblClickZoom : true, // 더블클릭으로 지도를 확대할지 여부
			mapMode : 0, // 지도 모드(0 : 일반 지도, 1 : 겹침 지도, 2 : 위성 지도)
			activateTrafficMap : false, // 실시간 교통 활성화 여부
			activateBicycleMap : false, // 자전거 지도 활성화 여부
			minMaxLevel : ['1','8'] // 지도의 최소/최대 축척 레벨
			size : Size, // 지도의 크기
			detectCoveredMarker : true, // 겹쳐 있는 마커를 클릭했을 때 겹친 마커 목록 표시 여부
		});
	</script>
</body>

</html>