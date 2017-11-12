<div id="fb-root"></div>
<script>
	 (function(d, s, id) {
	 	console.log(d);
	 	console.log(s);
	 	console.log(id);
		  var js, fjs = d.getElementsByTagName(s)[0];
		  //console.log(fjs);
		  //console.log( (d.getElementById(id)) );
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.8&appId=225197927866923";
		  fjs.parentNode.insertBefore(js, fjs);


		}
		(document, 'script', 'facebook-jssdk')  //(d,s,id)

		FB.ui( {
                method: 'share',
                name: "Facebook API: Tracking Shares using the JavaScript SDK",
                href: "https://test.com",
                picture: "https://test.com",
                caption: "Tracking Facebook Shares on your website or application is a useful way of seeing how popular your articles are with your readers. In order to tracking Shares, you must used the Facebook JavaScript SDK."
            }, function( response ) {
                if ( response !== null) {
                    console.log( response );
                    // ajax call to save response


                }
            } );


	);
</script>







<button class="my_own" type="button" onclick="share();">Share on Facebook</button>
  

  <script src="//connect.facebook.net/es_LA/sdk.js"></script>
    <button class='share-btn'>click</button>
    <script>
        function fb_share() {
            FB.init({
                appId      : '225197927866923',
                xfbml      : true,
                version    : 'v2.8',
                //app_secret: 'a70e2ca4f131a55252c29642ea7b1f81',
            });
            FB.ui( {
                method: 'share',
                name: "Facebook API: Tracking Shares using the JavaScript SDK",
                href: "https://test.com",
                picture: "https://test.com",
                caption: "Tracking Facebook Shares on your website or application is a useful way of seeing how popular your articles are with your readers. In order to tracking Shares, you must used the Facebook JavaScript SDK."
            }, function( response ) {
                if ( response !== null) {
                    console.log( response );
                    // ajax call to save response


                }
            } );


        }
        $(document).ready(function(){
            $('.share-btn').on( 'click', fb_share );
        });
    </script>