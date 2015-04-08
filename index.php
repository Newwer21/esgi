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

    $helper = new FacebookRedirectLoginHelper('https://projetesgi1.herokuapp.com/');

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
            appId      : '<?php echo APPID;?>',
            xfbml      : true,
            version    : 'v2.3'
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


      <h1>Mon application facebook</h1>

      <div
        class="fb-like"
        data-share="true"
        data-width="450"
        data-show-faces="true">
      </div>
      <br>
      <div class="fb-comments" data-href="http://skrzypczyk.fr" data-numposts="5" data-colorscheme="light"></div>
      <br>

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
      

        }else{
          $loginUrl = $helper->getLoginUrl();
          echo "<a href='".$loginUrl."'>Se connecter</a>";
        }

          

      ?>
  </body>
</html>