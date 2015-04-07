<?php 
	session_start();

	require('facebook/autoload.php');

	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookSession;

	const APP_ID = 1581981972065213;
	const APP_SECRET = bb83e05a20109eed97532c6328a24e4e;

	FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">

	<title>Faceboook App</title>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '<?php echo APP_ID; ?>',
	      xfbml      : true,
	      version    : 'v2.3'
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

<?php 

	$redirectUrl = 'https://esgi.herokuapp.com/';

	$helper = new FacebookRedirectLoginHelper($redirectUrl);
	$loginUrl = $helper->getLoginUrl(['email, user_birthday']);

	echo '<a href="'.$loginUrl.'">Se connecter</a>';
	// phpinfo();

	if (isset($_SESSION) && isset($_SESSION['fb_token']))
	{
		echo 'session par FacebookSession';
		$session = new FacebookSession($_SESSION['fb_token']);
	}
	else
	{
		echo 'session par $helper';
		$session = $helper->getSessionFromRedirect();
	}
	
	var_dump($session);

	if ($session) {
		var_dump($session);
		// try {
			
		// 	$user_profile = ( new FacebookRequest($session, 'GET', '/me',)->execute()->getGraphObject( GraphUser::className() ) );

		// 	echo "Nom : " . $user_profile->getName();
			
		// } catch (Exception $e) {
			
		// 	echo 'Exception... Code: ' . $e->getCode();
		// 	echo ' avec message: ' . $e->getMessage();
			
		// }
	}


	// var_dump($loginUrl);



?>


</body>
</html>