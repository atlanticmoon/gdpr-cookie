@if($gdprCookieConfig['enabled'] && ! $alreadyConsentedWithCookies)

   <style type="text/css">
       /* GdprCookie */
       body.scw-cookie-in {
           margin-bottom: 70px !important;
       }
       .scw-cookie-panel-toggle,
       .scw-cookie-settings,
       .scw-cookie-policy,
       .scw-cookie-btn,
       .scw-cookie-settings .icon,
       .scw-cookie-switch {
           transition: all .3s ease;
       }

       .icon {
           background-image: url(data:image/png;base64,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);
           background-repeat: no-repeat;
           background-size: auto 100%;
           height: 25px;
           width: 25px;
           display: inline-block;
       }
       .icon.icon-cookie   { background-position: 0 0;     }
       .icon.icon-policy   { background-position: -25px 0; }
       .icon.icon-settings { background-position: -50px 0; }

       .scw-cookie-panel-toggle {
           background: inherit;
           border-top: solid 3px #FFFFFF;
           cursor: pointer;
           padding: 10px;
           position: absolute;
           transform: translateY(-100%);
       }
       .scw-cookie-panel-toggle::before {
           background: #2D3436;
           content: 'Cookies on / off';
           float: left;
           height: 20px;
           line-height: 25px;
           margin-right: 0;
           opacity: 0;
           overflow: hidden;
           position: relative;
           text-align: center;
           transition: all 0.3s ease;
           visibility: hidden;
           width: 0;
       }
       .scw-cookie-panel-toggle:hover::before {
           opacity: 1;
           visibility: visible;
           margin-right: 10px;
           width: 140px;
       }
       .scw-cookie-panel-toggle-left   { left: 10px; }
       .scw-cookie-panel-toggle-center { left: calc(50% - 22.5px); }
       .scw-cookie-panel-toggle-right  { right: 10px; }
       .scw-cookie-panel-toggle:hover {
           border-top-color: #20BF6B;
       }
       .scw-cookie {
           background: #2D3436;
           bottom: 0;
           color: #FFFFFF;
           font-family: Arial;
           font-size: 14px;
           left: 0;
           position: fixed;
           width: 100%;
           z-index: 9999999999;
       }
       .scw-cookie:not(.scw-cookie-out) {
           animation: slideIn .5s ease-in-out;
       }
       .scw-cookie.scw-cookie-out {
           transform: translateY(100%);
       }
       .scw-cookie.scw-cookie-slide-out {
           animation: slideOut .5s ease-in-out;
           transform: translateY(100%);
       }
       .scw-cookie-content {
           margin: 0 auto;
           max-width: 90%;
           padding: 20px;
           width: 1170px;
       }
       .scw-cookie-content::after {
           clear: both;
           content: '';
           display: block;
       }
       .scw-cookie-message {
           float: left;
           line-height: 30px;
           width: 70%;
       }
       .scw-cookie-decision {
           text-align: right;
           float: left;
           width: 30%;
       }
       .scw-cookie-btn {
           background: #20BF6B;
           cursor: pointer;
           display: inline-block;
           line-height: 30px;
           text-align: center;
           width: 40px;
       }
       .scw-cookie-btn:hover {
           background: #169853;
       }
       .scw-cookie-settings,
       .scw-cookie-policy {
           display: inline-block;
           line-height: 30px;
           margin-left: 13px;
           text-align: center;
           width: 20px;
       }
       .scw-cookie-settings .icon,
       .scw-cookie-policy .icon {
           margin-top: -5px;
           opacity: .7;
           position: relative;
           top: 7px;
       }
       .scw-cookie-settings:hover .icon,
       .scw-cookie-policy:hover .icon {
           opacity: 1;
       }
       .scw-cookie-settings {
           cursor: pointer;
       }
       .scw-cookie-details {
           clear: both;
           display: none;
           padding-top: 15px;
       }
       .scw-cookie-details::after {
           clear: both;
           content: '';
           display: block;
       }
       .scw-cookie-details-title {
           font-weight: bold;
       }
       .scw-cookie-toggle {
           border: solid 1px;
           box-sizing: border-box;
           float: left;
           margin-top: 10px;
           padding: 5px;
           width: calc(50% - 5px);
       }
       .scw-cookie-toggle:nth-child(even) {
           margin-right: 5px;
       }
       .scw-cookie-toggle:nth-child(odd) {
           margin-left: 5px;
       }
       .scw-cookie-name {
           cursor: pointer;
           float: left;
           line-height: 23px;
           padding-left: 15px;
           width: 80%;
       }
       .scw-cookie-toggle input[type="checkbox"] {
           cursor: pointer;
           float: left;
           height: 25px;
           margin: 0;
           width: 20%;
       }

       .scw-cookie-tooltip-trigger {
           position: relative;
       }
       .scw-cookie-tooltip {
           animation: fadeIn .5s ease-in-out;
           background: #fff;
           border: solid 1px #000;
           color: #000;
           font-size: 11px;
           left: 50%;
           line-height: 23px;
           padding: 0 10px;
           position: absolute;
           top: 0;
           transform: translate(-50%, -100%);
           width: 100px;
       }

       /* Animations */
       @-webkit-keyframes fadeIn {
           from { opacity: 0; visibility: hidden; }
           to   { opacity: 1; visibility: visible; }
       }
       @keyframes fadeIn {
           from { opacity: 0; visibility: hidden; }
           to   { opacity: 1; visibility: visible; }
       }
       @-webkit-keyframes slideIn {
           from { transform: translateY(100%); }
           to   { transform: translateY(0%); }
       }
       @keyframes slideIn {
           from { transform: translateY(100%); }
           to   { transform: translateY(0%); }
       }
       @-webkit-keyframes slideOut {
           from { transform: translateY(0%); }
           to   { transform: translateY(100%); }
       }
       @keyframes slideOut {
           from { transform: translateY(0%); }
           to   { transform: translateY(100%); }
       }


       .scw-cookie-switch {
           background: #BDB9A6;
           border-radius: 1em;
           cursor: pointer;
           display: inline-block;
           font-size: 20px;
           height: .8em;
           margin: 0;
           position: relative;
           top: 4px;
           width: 2em;
       }
       .scw-cookie-switch.checked {
           background: #20BF6B;
       }
       .scw-cookie-switch.disabled {
           cursor: not-allowed;
           opacity: .5;
       }
       .scw-cookie-switch input {
           position: absolute;
           opacity: 0;
       }
       .scw-cookie-switch div {
           background: #FFFFFF;
           border-radius: .8em;
           box-shadow: 0 0.1em 0.3em rgba(0,0,0,0.3);
           height: .8em;
           width: 1em;

           -webkit-transition: all 300ms;
           -moz-transition: all 300ms;
           transition: all 300ms;
       }

       .scw-cookie-switch input:checked + div {
           -webkit-transform:  translate3d(100%, 0, 0);
           -moz-transform:     translate3d(100%, 0, 0);
           transform: translate3d(100%, 0, 0);
       }
   </style>

@endif
