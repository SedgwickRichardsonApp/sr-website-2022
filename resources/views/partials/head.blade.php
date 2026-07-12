<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <? $siteURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

  //  if ( WP_ENV == 'staging' ) {
    if ( strpos($siteURL, 'staging-srwebsite.kinsta.cloud') == true ) { ?>

        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl+ '&gtm_auth=ndk6E3zu1jn95KdsuNdrqg&gtm_preview=env-5&gtm_cookies_win=x';f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-5586GN3');</script>


    <? // } else if ( WP_ENV == 'production' ) {
      } else if ( strpos($siteURL, 'sedgwick-richardson.com') == true ) { ?>

        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl+ '&gtm_auth=tAJIWN880UXTzmC1VzjhWw&gtm_preview=env-2&gtm_cookies_win=x';f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-5586GN3');
        </script>

    
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-71728129-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-71728129-1');
        </script>
        <!-- End Global site tag (gtag.js) - Google Analytics -->

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5VNGJTGNGG"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-5VNGJTGNGG');
        </script>

        <!-- Global site tag (gtag.js) - Google Ads: 928441790 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-928441790"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'AW-928441790');
        </script>

        <script>
          window.addEventListener("load", function(event) {
              document.querySelectorAll("a[href*='mailto:infohk@sedgwick-richardson.com']").forEach(function(e){
                  e.addEventListener('click',function(){
                      gtag('event', 'conversion', {
                          send_to: "AW-928441790/W8uICLfh564DEL7L27oD",
                      });
                      gtag('event', "Click", {
                          'event_category': 'Contact Email HK',
                      });
                  });
              });
          });
        </script>

        <script>
          var total_time
          window.addEventListener('load',function()
          {
            if(window.location.href.includes('')){
              setInterval(function() {  
                if(localStorage.getItem('total_time')!=null){      
                  total_time = localStorage.getItem('total_time')
                  total_time++
                  localStorage.setItem('total_time', total_time)
                  if(total_time == 60){
                    gtag('event', 'conversion', {'send_to': 'AW-928441790/ajKMCK_fm4cYEL7L27oD'});
                  }
                } else {
                  total_time = 0
                  localStorage.setItem('total_time', total_time)
                }
              }, 1000)
            }
          })
        </script>

        <script>
          window.addEventListener("load", function(event) {
              document.querySelectorAll("a[href*='mailto:infohk@sedgwick-richardson.com']").forEach(function(e){
                e.addEventListener('click',function(){
                  gtag('event', 'conversion', {
                  send_to: "AW-928441790/W8uICLfh564DEL7L27oD",
                });
                gtag('event', "Click", {
                  'event_category': 'Contact Email HK',
                });
              });
            });
          });
        </script>
  
        <script>
            window.addEventListener("load", function(event) {
              document.querySelectorAll("a[href*='mailto:infosg@sedgwick-richardson.com']").forEach(function(e){
                e.addEventListener('click',function(){
                  gtag('event', 'conversion', {
                  send_to: "AW-928441790/aH17CL_5jrwDEL7L27oD",
                });
            
                gtag('event', "Click", {
                  'event_category': 'Contact Email SG',
                  });
                });
              });
            });
        </script>
    <? } ?>

  @php wp_head() @endphp
</head>
