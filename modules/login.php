<?php
	require('./initialize.php');
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
?>