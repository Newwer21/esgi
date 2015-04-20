<?php 
	session_start();

	error_reporting(E_ALL);
  ini_set("display_errors", 1);

  require "facebook/autoload.php";

	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookSession;
	use Facebook\GraphUser;
	use Facebook\FacebookRequest;
	use Facebook\FacebookRequestException;

	const APP_ID = "1581981972065213";
	const APP_SECRET = "bb83e05a20109eed97532c6328a24e4e";

    FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);

    $helper = new FacebookRedirectLoginHelper('https://esgi.herokuapp.com/');

    if( isset($_SESSION) &&  isset($_SESSION['fb_token']))
    {
        $session  = new FacebookSession($_SESSION['fb_token']);
    }
    else
    {
        $session = $helper->getSessionFromRedirect();
    }   

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Titre de ma page</title>   
      <meta name="description" content="description de ma page">
     
  </head>
  <body>
       <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '<?php echo APP_ID;?>',
            xfbml      : true,
            version    : 'v2.3'
          });
          
          function onLogin(response) {
            if (response.status == 'connected') {
              FB.api('/me?fields=first_name', function(data) {
                var welcomeBlock = document.getElementById('fb-welcome');
                welcomeBlock.innerHTML = 'Hello, ' + data.first_name + '!';
              });
            }
          }

          FB.getLoginStatus(function(response) {
            // Check login status on load, and if the user is
            // already logged in, go directly to the welcome message.
            if (response.status == 'connected') {
              onLogin(response);
            } else {
              // Otherwise, show Login dialog first.
              FB.login(function(response) {
                onLogin(response);
              }, {scope: 'user_friends, email'});
            }
          });
        };


        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "//connect.facebook.net/fr_FR/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
      </script>

      <h1 id="fb-welcome"></h1>
      <h1>Mon application facebook</h1>

      <?php

        if($session)
        {
          
          $token = (string) $session->getAccessToken();
          $_SESSION['fb_token'] = $token;

          //Prepare
          $request = new FacebookRequest($session, 'GET', '/me');
          //execute
          $response = $request->execute();
          //transform la data graphObject
          $user = $response->getGraphObject("Facebook\GraphUser");
          echo "<pre>";
          print_r($user);
          echo "</pre>";

          echo 'Nom : ' . $user->getName();

          $request = new FacebookRequest(
            $session,
            'GET',
            '/{user-id}/photos'
          );
          $response = $request->execute();
          $graphObject = $response->getGraphObject();

          var_dump($graphObject);
      

        }else{
          $loginUrl = $helper->getLoginUrl();
          echo "<a href='".$loginUrl."'>Se connecter</a>";
        } 

      ?>
  </body>
</html>