<?php
include ('./config.php');
$x = $y = 0;
if(is_numeric($_GET['x'])) $x = $_GET['x'];
if(is_numeric($_GET['y'])) $y = $_GET['y'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>OpenAPI Map Test - 지도의 이동,확대, 축소 및 중심점 이동</title>
<!-- prevent IE6 flickering -->
<script type="text/javascript">
        try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}
</script>
<SCRIPT LANGUAGE="JavaScript" src="http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=<?php echo $dbsettings['map_key']; ?>"></SCRIPT> 
</head>
<body style='padding:0;margin:0;'>
<div id="testMap" style="width:510px; height:525px;" ></div>
<SCRIPT LANGUAGE="JavaScript">
                        var oPoint = new nhn.api.map.TM128(<?php echo $x; ?>, <?php echo $y; ?>);
                        nhn.api.map.setDefaultPoint('TM128');
                        oMap = new nhn.api.map.Map('testMap', {
                                                point : oPoint,
                                                zoom : 13, // - 초기 줌 레벨은 6으로 둔다.
                                                enableWheelZoom : true,
                                                enableDragPan : true,
                                                enableDblClickZoom : false,
                                                mapMode : 0,
                                                activateTrafficMap : false,
                                                activateBicycleMap : false,
                                                minMaxLevel : [ 9, 14 ],
                                                size : new nhn.api.map.Size(510, 525)
                                        });

                        var mapZoom = new nhn.api.map.ZoomControl(); // - 줌 컨트롤 선언
                        mapZoom.setPosition({right:40, top:40}); // - 줌 컨트롤 위치 지정
                        oMap.addControl(mapZoom); // - 줌 컨트롤 추가.

                        var defaultBounds = oMap.getBound();
                        var defaultCenter = oMap.getCenter();
                        var defaultLevel = oMap.getLevel();
                        var defaultMapMode = oMap.getMapMode();
                        
                        var oSize = new nhn.api.map.Size(28, 37);
                        var oOffset = new nhn.api.map.Size(14, 37);

                        var oIcon = new nhn.api.map.Icon('http://static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);

                        // 마커 찍기
                        var oMarker1 = new nhn.api.map.Marker(oIcon, { title : '진행 장소' });  //마커 생성
                        oMarker1.setPoint(oPoint); //마커 표시할 좌표 선택
                        oMap.addOverlay(oMarker1); //마커를 지도위에 표현

                        //라벨 넣기
                        var oLabel1 = new nhn.api.map.MarkerLabel(); // - 마커 라벨 선언.
                        oMap.addOverlay(oLabel1); // - 마커 라벨 지도에 추가. 기본은 라벨이 보이지 않는 상태로 추가됨.
                        oLabel1.setVisible(true, oMarker1); // 마커 라벨 보이기

</SCRIPT> 
</body>
</html>
