<?php namespace Atlanticmoon\GdprCookie\Controllers;

use Atlanticmoon\GdprCookie\GdprCookie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiController extends BaseController
{
	public function __construct(Request $request) {

		parent::__construct($request);
		
	}
	
	public function cookieApiAction(Request $request){
		if (!$request->has('action')) {
			return (new JsonResponse(["error" => "Action not specified"], 403));
		}
		
		$action = $request->get("action");

		switch ($action) {
			case 'hide':
				// Set cookie
				GdprCookie::setCookie('gdprCookieHidden', 'true', 52, 'weeks');
				header('Content-Type: application/json');
				return (new JsonResponse(['success' => true]));

			case 'toggle':
				$gdprCookie = new GdprCookie();
				$return    = [];

				// Update if cookie allowed or not
				$choices = $gdprCookie->getCookie('gdprCookie');
				if ($choices == false) {
					$choices = [];
					$enabledCookies = $gdprCookie->enabledCookies();
					foreach ($enabledCookies as $name => $label) {
						$choices[$name] = $gdprCookie->config['unsetDefault'];
					}
					$gdprCookie->setCookie('gdprCookie', $gdprCookie->encrypt($choices), 52, 'weeks');
				} else {
					$choices = $gdprCookie->decrypt($choices);
				}
				$choices[$_POST['name']] = $_POST['value'] == 'true' ? 'allowed' : 'blocked';

				// Remove cookies if now disabled
				if ($choices[$_POST['name']] == 'blocked') {
					$removeCookies = $gdprCookie->clearCookieGroup($_POST['name']);
					$return['removeCookies'] = $removeCookies;
				}

				$choices = $gdprCookie->encrypt($choices);
				$gdprCookie->setCookie('gdprCookie', $choices, 52, 'weeks');
				return (new JsonResponse(['success' => true, 'data' => $return]));

			case 'load':
				$gdprCookie = new GdprCookie();
				$return    = [];

				$removeCookies = [];

				foreach ($gdprCookie->disabledCookies() as $cookie => $label) {
					$removeCookies = array_merge($removeCookies, $gdprCookie->clearCookieGroup($cookie));
				}
				$return['removeCookies'] = $removeCookies;
				return (new JsonResponse(['success' => true, 'data' => $return]));

			default:
				return (new JsonResponse(["error" => "Action not recognised"], 403));
				
		}
	}
}
