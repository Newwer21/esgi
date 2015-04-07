<?php 
	session_start();

	require('facebook/autoload.php');

	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookSession;

	const APP_ID = 1581981972065213;
	const APP_SECRET = bb83e05a20109eed97532c6328a24e4e;

	FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);

	$helper = new FacebookRedirectLoginHelper($redirectUrl);

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

	$loginUrl = $helper->getLoginUrl(['email, user_birthday']);

	// phpinfo();

	echo '<a href="'.$loginUrl.'">Se connecter</a>';

	$session = $helper->getSessionFromRedirect();

?>


</body>
</html>