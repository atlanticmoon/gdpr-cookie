@if($gdprCookieConfig['enabled'] && ! $alreadyConsentedWithCookies)
    <!-- Facebook SDK -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ $gdprCookieConfig['cookies']['Facebook']['code'] }}',
                cookie     : true,
                xfbml      : true,
                version    : '{{ $gdprCookieConfig['cookies']['Facebook']['api_version'] }}'
            });
    
            FB.AppEvents.logPageView();
        };
    
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/{{ (App::getLocale() !== 'en') ? App::getLocale()."_".strtoupper(App::getLocale()): 'en_US' }}/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@else
    <!-- FIX Facebook SDK -->
    <script>
        var FB = {
            AppEvents : {
                logPageView : function(){},
                logEvent : function(){}
            }
        };
    </script>
@endif
