@if($gdprCookieConfig['enabled'] && ! $alreadyConsentedWithCookies)

    <div class="scw-cookie{!! $decisionMade ? ' scw-cookie-out' : ''; !!}">
        <div class="scw-cookie-panel-toggle scw-cookie-panel-toggle-{!! $gdprCookieConfig['panelTogglePosition']; !!}"
             onclick="scwCookiePanelToggle()"
        >
            <span class="icon icon-cookie"></span>
        </div>
        <div class="scw-cookie-content">
            <div class="scw-cookie-message">
                @lang('gdprCookie::texts.message')
            </div>
            <div class="scw-cookie-decision">
                <div class="scw-cookie-btn" onclick="scwCookieHide()">OK</div>
                <div class="scw-cookie-settings scw-cookie-tooltip-trigger"
                     onclick="scwCookieDetails()"
                     data-label="{{ Lang::get('gdprCookie::texts.cookie_settings') }}"
                >
                    <span class="icon icon-settings"></span>
                </div>
                @if(isset($gdprCookieConfig['cookiePolicyUrl']) && !empty($gdprCookieConfig['cookiePolicyUrl']))
                    <div class="scw-cookie-policy scw-cookie-tooltip-trigger" data-label="{{ Lang::get('gdprCookie::texts.cookie_policy') }}">
                        <a href="{!!$gdprCookieConfig['cookiePolicyUrl']  !!}">
                            <span class="icon icon-policy"></span>
                        </a>
                    </div>
                @elseif(isset($gdprCookieConfig['cookiePolicyRouteAs']) && !empty($gdprCookieConfig['cookiePolicyRouteAs']))
                    <div class="scw-cookie-policy scw-cookie-tooltip-trigger" data-label="{{ Lang::get('gdprCookie::texts.cookie_policy') }}">
                        <a href="{!! route($gdprCookieConfig['cookiePolicyRouteAs'])  !!}">
                            <span class="icon icon-policy"></span>
                        </a>
                    </div>
                @endif
            </div>
            <div class="scw-cookie-details">
                <div class="scw-cookie-details-title">@lang('gdprCookie::texts.manage_your_cookies')</div>
                <div class="scw-cookie-toggle">
                    <div class="scw-cookie-name">@lang('gdprCookie::texts.essential_cookie')</div>
                    <label class="scw-cookie-switch checked disabled">
                        <input type="checkbox" name="essential" checked="checked" disabled="disabled">
                        <div></div>
                    </label>
                </div>
                @foreach ($gdprCookie->enabledCookies() as $name => $label)
                    <div class="scw-cookie-toggle">
                        <div class="scw-cookie-name" onclick="scwCookieToggle(this)">{!! $label; !!}</div>
                        <label class="scw-cookie-switch{!! $gdprCookie->isAllowed($name) ? ' checked' : ''; !!}">
                            <input type="checkbox"
                                   name="{!! $name; !!}"
                                    {!! $gdprCookie->isAllowed($name) ? 'checked="checked"' : ''; !!}
                            >
                            <div></div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script type="text/javascript">
        !function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}return function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}(function(){})});
    </script>
    <script type="text/javascript">
        if (!jQuery('.scw-cookie').hasClass('scw-cookie-out')) {
            jQuery(document).find('body').addClass('scw-cookie-in');
        }

        function scwCookieHide()
        {
            jQuery.post(
                '/atlanticmoon/gdprcookie/ajax',
                {
                    action : 'hide'
                }
            ).done(function(data){
                if (data.hasOwnProperty('success') && data.success) {
                    jQuery('.scw-cookie').addClass('scw-cookie-slide-out');
                    jQuery(document).find('body').removeClass('scw-cookie-in');
                }

                if (jQuery('.scw-cookie').hasClass('changed')) {
                    location.reload();
                }
            });
        }

        function scwCookieDetails()
        {
            jQuery('.scw-cookie-details').slideToggle();
        }

        function scwCookieToggle(element)
        {
            jQuery(element).closest('.scw-cookie-toggle').find('input[type="checkbox"]').click();
        }

        function scwCookiePanelToggle()
        {
            jQuery('.scw-cookie').removeClass('scw-cookie-out');
            if (jQuery(document).find('body').hasClass('scw-cookie-in')) {
                jQuery('.scw-cookie').addClass('scw-cookie-slide-out');
                jQuery(document).find('body').removeClass('scw-cookie-in');
            } else {
                jQuery('.scw-cookie').removeClass('scw-cookie-slide-out');
                jQuery(document).find('body').addClass('scw-cookie-in');
            }
        }

        jQuery(document).ready(function($){
            $('.scw-cookie-switch input').each(function(){
                if ($(this).prop('checked')) {
                    $(this).closest('.scw-cookie-switch').addClass('checked');
                } else {
                    $(this).closest('.scw-cookie-switch').removeClass('checked');
                }
            });
        });
        jQuery(document).on('change', '.scw-cookie-toggle input[type="checkbox"]', function(){
            jQuery(this).closest('.scw-cookie').addClass('changed');
            jQuery(this).closest('.scw-cookie-switch').toggleClass('checked');
            jQuery.post(
                '/atlanticmoon/gdprcookie/ajax',
                {
                    action : 'toggle',
                    name   : jQuery(this).attr('name'),
                    value  : jQuery(this).prop('checked')
                }
            ).done(function(data){
                if (data.hasOwnProperty('removeCookies')) {
                    jQuery.each(data.removeCookies, function(key, cookie){
                        Cookies.remove(cookie.name);
                        Cookies.remove(cookie.name, { domain: cookie.domain });
                        Cookies.remove(cookie.name, { path: cookie.path });
                        Cookies.remove(cookie.name, { domain: cookie.domain, path: cookie.path });
                    });
                }
            });
        });

        jQuery(document).ready(function($){
            $('.scw-cookie-tooltip-trigger').hover(function(){
                var label = $(this).attr('data-label');
                $(this).append('<span class="scw-cookie-tooltip">'+label+'</span>');
            }, function(){
                $(this).find('.scw-cookie-tooltip').remove();
            });
        });

        jQuery(document).ready(function($){
            jQuery.post(
                '/atlanticmoon/gdprcookie/ajax',
                {
                    action : 'load',
                }
            ).done(function(data){
                if (data.hasOwnProperty('removeCookies')) {
                    jQuery.each(data.removeCookies, function(key, cookie){
                        Cookies.remove(cookie.name);
                        Cookies.remove(cookie.name, { domain: cookie.domain });
                        Cookies.remove(cookie.name, { path: cookie.path });
                        Cookies.remove(cookie.name, { domain: cookie.domain, path: cookie.path });
                    });
                }
            });
        });

    </script>

    {!! $gdprCookie->getCookiesHTML() !!}

@endif
