<?php
	require('./vendor/autoload.php');

	use Facebook\FacebookOtherException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookSignedRequestFromInputHelper;
	use Facebook\GraphPage;
	use Facebook\FacebookAuthorizationException;
	use Facebook\FacebookPageTabHelper;
	use Facebook\FacebookResponse;
	use Facebook\FacebookThrottleException;
	use Facebook\GraphSessionInfo;
	use Facebook\FacebookCanvasLoginHelper;
	use Facebook\FacebookPermissionException;
	use Facebook\FacebookSDKException;
	use Facebook\GraphAlbum;
	use Facebook\GraphUser;
	use Facebook\FacebookClientException;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookServerException;
	use Facebook\GraphLocation;
	use Facebook\GraphUserPage;
	use Facebook\FacebookJavaScriptLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookSession;
	use Facebook\GraphObject;

	//로그인 상태 체크입니다.
	require('./initialize.php');

	if(isset($_SESSION['UserID']) && isset($_SESSION['GroupDB']))
	{
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
		exit;
	}
	else
	{
		session_unset();
		session_destroy();
	}
	//여기까지가 로그인 상태 체크 코드입니다.

	//여기서부터 Facebook 인증 과정 코드입니다.
	header('Content-Type: application/json');

	require('./initialize.php');
	FacebookSession::setDefaultApplication('972582816088954', '648f2d3ba8d255b6e56ce869625e697f');
	$session = new FacebookSession($_POST['AccessToken']);

	try {
		$session->validate();
	} catch (FacebookRequestException $ex) {
		// Session not valid, Graph API returned an exception with the reason.

		$response=array('result'=>'fail', 'server_message'=>$ex->getMessage());
		echo json_encode($response);

		session_unset();
		session_destroy();

		exit;
	} catch (\Exception $ex) {
		// Graph API returned info, but it may mismatch the current app or have expired.

		$response=array('result'=>'fail', 'server_message'=>$ex->getMessage());
		echo json_encode($response);

		session_unset();
		session_destroy();
		exit;
	}

	$UserID="";
	$UserName="";

	if($session) {
		try {
	    	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());

	    	$UserName=$user_profile->getName();
	    	$UserID=$user_profile->getId();
  		}
  		catch(FacebookRequestException $e)
  		{
  			$message='Exception occured, code: ' . $e->getCode() . ' with message: ' . $e->getMessage();
  			$response=array('result'=>'fail', 'server_message'=>$message);
			echo json_encode($response);

   			session_unset();
			session_destroy();
			exit;
		}   
	}
	//여기까지가 Facebook인증과정 코드입니다.
	$_SESSION['login_state']=false;


	//DB 연걸 부분입니다.
	require './db_connect.php';

	$querystr=sprintf("SELECT * FROM UserList WHERE UserID='%s';", $mysql_link->real_escape_string($UserID));
	$result=$mysql_link->query($querystr);
	if(!$result)
	{
		$response=array('result'=>'fail', 'server_message'=>'Database Query Error');
		echo json_encode($response);

		session_unset();
		session_destroy();

		exit;
	}

	if($result->num_rows == 0)
	{
		$querystr=sprintf("INSERT INTO UserList SET UserID='%s', UserName='%s', State='1';", $mysql_link->real_escape_string($UserID), $mysql_link->real_escape_string($UserName));
		$result=$mysql_link->query($querystr);

		if(!$result)
		{
			$response=array('result'=>'fail', 'server_message'=>'Authentication Error');
			echo json_encode($response);

			session_unset();
			session_destroy();

			exit;
		}
		else
		{
			$response=array('result'=>'fail', 'server_message'=>'최초 접속이시네요! 등록이 완료되었습니다. 로그인 버튼을 다시 눌러주세요.');
			echo json_encode($response);

			session_unset();
			session_destroy();

			exit;
		}
	}

	$result->data_seek(0);
	$result_data=$result->fetch_array(MYSQLI_ASSOC);

	if($result_data['State']==0)
	{
		$response=array('result'=>'fail', 'server_message'=>'로그인이 거부되었습니다. 운영자에게 문의하세요.');
		echo json_encode($response);

		session_unset();
		session_destroy();

		exit;
	}

	$_SESSION['UserID']=$result_data['UserID'];
	$_SESSION['UserName']=$result_data['UserName'];
	$_SESSION['UserIP']=$_SERVER['REMOTE_ADDR'];
	$_SESSION['UserAgent']=$_SERVER['HTTP_USER_AGENT'];

	$mysql_link->close();
	//여기까지가 DB연결 부분입니다.

	$_SESSION['login_state']=true;
	$message=$UserName."님 환영합니다.\n\n";
	$message.="[이벤트 안내]\n";
	$message.="수요일까지 쓸모있는 정보를 제일 많이 올린 3분에게 문화상품권 1마원권, 그 다음 4분에게 문화상품권 5천원권 증정!";
	$response=array('result'=>'success', 'server_message'=>$message);
	echo json_encode($response);
?>