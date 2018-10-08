<?php

return [
// This is the configuration file for GDPR Cookie
// ###############################################

/*
  * Use this setting to enable the cookie consent dialog.
  */
'enabled' => env('GDPR_COOKIE_ENABLED', true),
/*
 * The name of the cookie in which we store if the user
 * has agreed to accept the conditions.
 */
'cookie_name' => 'laravel_gdpr_cookie',

// Route for the internal cookie policy link to go to (comment cookiePolicyUrl if use this param)
"cookiePolicyRouteAs" => "user/cookie",
	
// URL for the external cookie policy link to go to (comment cookiePolicyRouteAs if use this param)
//"cookiePolicyUrl" => "/cookie-policy",

// Location for the toggle button to display on the bottom of the window
// Options: left, center, right
"panelTogglePosition" => "right",

// On page load will cookies be allowed or blocked
// Options: allowed, blocked
"unsetDefault" => "allowed",

// Inividual cookie code configs
// ###############################################


"cookies" => 
	[
		"Google_Analytics" =>[
			// ---------------------
			// Google Analytics - https://analytics.google.com
			//"group" => "Analytical cookies", //(feature not used)
			
			// Is this cookie to be used on your site?
			// Options: true, false
			"enabled" => false,
			
			// position to load script, footer load script before </body> tag - top load script after <body> tag
			// Options: footer, top
			"position" => "footer",
	
			// Label for this cookie within the popup -> cookie settings area
			"label" => "Google Analytics",
			
			// Pathname of the cookie blade: e.g. Google_Analytics (find files in gdprCookie/Cookies/Google_Analytics)
			"path" => "Google_Analytics",
	
			// Google tracking ID: e.g. UA-1234567-8
			"code" => ""
		],
		"Tawk" => [
			// ---------------------
			// Tawk.to - https://www.tawk.to
			//"group" => "Functional cookies",//(feature not used)
				
			// Is this cookie to be used on your site?
			// Options: true, false
			"enabled" => false,

			// position to load script, footer load script before </body> tag - top load script after <body> tag
			// Options: footer, top
			"position" => "footer",
			
			// Label for this cookie within the popup -> cookie settings area
			"label" => "Tawk.to - Live chat",

			// Pathname of the cookie blade: e.g. Tawk.to (find files in gdprCookie/Cookies/Tawk.to)
			"path" => "Tawk.to",

			// Site code: e.g. 12345a6b789cdef01g234567
			"code" => ""
		],
		"Smartsupp" => [
			// ---------------------
			// Smartsupp - https://www.smartsupp.com
			// Is this cookie to be used on your site?
			//"group" => "Functional cookies",//(feature not used)
			
			// Options: true, false
			"enabled" => false,

			// position to load script, footer load script before </body> tag - top load script after <body> tag
			// Options: footer, top
			"position" => "footer",
			
			// Label for this cookie within the popup -> cookie settings area
			"label" => "Smartsupp - Live chat",

			// Pathname of the cookie blade: e.g. Smartsupp (find files in gdprCookie/Cookies/Smartsupp)
			"path" => "Smartsupp",

			// Site code: e.g. ab12c34defghi5j6k789l0m1234n567890o12345
			"code" => ""
		],
		"Hotjar" => [
			// ---------------------
			// Hotjar - https://www.hotjar.com
			//"group" => "Analytical cookies",//(feature not used)
			
			// Is this cookie to be used on your site?
			// Options: true, false
			"enabled" => false,

			// position to load script, footer load script before </body> tag - top load script after <body> tag
			// Options: footer, top
			"position" => "footer",

			// Label for this cookie within the popup -> cookie settings area
			"label" => "Hotjar - Website heatmaps",

			// Pathname of the cookie blade: e.g. Hotjar (find files in gdprCookie/Cookies/Hotjar)
			"path" => "Hotjar",

			// Site code: e.g. 123456
			"code" => ""
		],
		"Facebook" =>[
			// ---------------------
			// Facebook - https://analytics.google.com
			"group" => "Analytical cookies",//(feature not used)
			
			// Is this cookie to be used on your site?
			// Options: true, false
			"enabled" => false,

			// position to load script, footer load script before </body> tag - top load script after <body> tag
			// Options: footer, top
			// Default: footer
			"position" => "top",

			// Label for this cookie within the popup -> cookie settings area
			"label" => "Facebook",

			// Pathname of the cookie blade: e.g. Facebook (find files in gdprCookie/Cookies/Facebook)
			"path" => "Facebook",

			// Api version used by Facebook app
			"api_version" => "v3.1",

			// Facebook App ID: e.g. 12345678912345678
			"code" => ""
			
		],
	],

	
];
