Add Menu Items to Timeline Cards
================================
This code shows how to add menu items to your Glass Timeline cards, so that users
can interact with content you provide

It is intended as a complement to my tutorial:
http://20missionglass.tumblr.com/post/67676363275/add-your-service-as-a-contact

Configuration
--------------
Set up an OAuth2 Client App in the Google Code Console:
https://code.google.com/apis/console/

Once you register an app, create  you will get a client id and client secret.   

Edit your settings.php to reflect your oauth2 client app's settings.

$settings['oauth2']['oauth2_client_id'] = 'YOURCLIENTID.apps.googleusercontent.com';
$settings['oauth2']['oauth2_secret'] = 'YOURCLIENTSECRET';
$settings['oauth2']['oauth2_redirect'] = 'https://example.com/oauth2callback';

Now you should be good to go.


