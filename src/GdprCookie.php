<?php

namespace Atlanticmoon\GdprCookie;

use GdprCookie\GdbrCookieBarException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GdprCookie
{

	public $config        = [];
	private $decisionMade = false;
	private $choices      = [];

	public function __construct()
	{
		$this->config = config("gdprcookie");
		$this->decisionMade = self::getCookie('gdprCookieHidden') == 'true';
		$this->choices      = $this->getChoices();
	}

	public function getDecisionMode(){
		return $this->decisionMade;
	}

	public function getChoices()
	{
		if (self::getCookie('gdprCookie') !== false) {
			$cookie = self::getCookie('gdprCookie');
			$cookie = self::decrypt($cookie);
			return $cookie;
		}

		$return = [];
		foreach ($this->enabledCookies() as $name => $label) {
			$return[$name] = $this->config['unsetDefault'];
		}
		return $return;
	}

	public static function encrypt($value)
	{
		$value  = json_encode($value);
		$return = base64_encode($value);
		return $return;
	}

	public static function decrypt($value)
	{
		$value  = base64_decode($value);
		$value  = str_replace('\"', '"', $value);
		$return = json_decode($value, true);
		return $return;
	}

	public function isAllowed($name)
	{
		$choices = $this->getChoices();
		return isset($choices[$name]) && $choices[$name] == 'allowed';
	}

	public function isCookieEnabled($name)
	{
		$check = $this->config['cookies'][$name];
		return is_array($check) && isset($check['enabled']) && $check['enabled'];
	}

	public function getConfig($name, $attribute)
	{
		$cookies = $this->config["cookies"];
		$selectedCookie = null;
		foreach($cookies as $key => $cookie){
			if($key == $name){
				$selectedCookie = $cookie;
			}
		}
		foreach($selectedCookie as $attr => $value){
			if($attr == $attribute) return $value;
		}

		return false;
	}

	public function getCookiesHTML($position = 'footer')
	{
		$return = [];

		// Get embed codes
		foreach ($this->config['cookies'] as $configKey => $configValue) {
			if (!is_array($configValue) || !$configValue['enabled'] || !$this->isAllowed($configKey) || $configValue['position'] != $position) {
				continue;
			}
			$return[] = $this->getOutputHTML('gdprCookie::Cookies.'.$configValue['path'].'.output',true);
		}

		return implode("\n", $return);
	}

	public function getOutputHTML($filename, $isBlade = false)
	{
		if($isBlade){
			if(!View::exists($filename)){
				return "";
			}
			$gdprCookieConfig = Config::get('gdprcookie');
			$alreadyConsentedWithCookies = (Cookie::get($gdprCookieConfig['cookie_name']) === true);
			return View::make($filename,['gdprCookieConfig' => $gdprCookieConfig, 'alreadyConsentedWithCookies' => $alreadyConsentedWithCookies])->render();
		}else{
			if (!file_exists(__DIR__.'/output/'.$filename.'.php')) {
				return "";
			}

			ob_start();
			include __DIR__.'/output/'.$filename.'.php';
			return trim(ob_get_clean());
		}

	}

	public function enabledCookies()
	{
		$return = [];
		foreach ($this->config['cookies'] as $name => $value) {
			if (!$this->isCookieEnabled($name)) {
				continue;
			}
			$return[$name] = $value['label'];
		}
		return $return;
	}

	public function disabledCookies()
	{
		$return = [];
		foreach ($this->config['cookies'] as $name => $value) {
			if (!$this->isCookieEnabled($name) || !is_array($value) || $this->isAllowed($name)) {
				continue;
			}
			$return[$name] = $value['label'];
		}
		return $return;
	}

	public static function setCookie(
		$name,
		$value,
		$lifetime = 30,
		$lifetimePeriod = 'days',
		$domain = '/',
		$secure = false
	) {
		// Validate parameters
		self::validateSetCookieParams($name, $value, $lifetime, $domain, $secure);

		// Calculate expiry
		$expiry = strtotime('+'.$lifetime.' '.$lifetimePeriod);

		// Set cookie
		return setcookie($name, $value, $expiry, $domain, $secure);
	}

	public static function validateSetCookieParams($name, $value, $lifetime, $domain, $secure)
	{
		// Types of parameters to check
		$paramTypes = [
			// Type => Array of variables
			'string' => [$name, $value, $domain],
			'int'    => [$lifetime],
			'bool'   => [$secure],
		];

		// Validate basic parameters
		$validParams = self::basicValidationChecks($paramTypes);

		// Ensure parameters are still valid
		if (!$validParams) {
			// Failed parameter check
			header('HTTP/1.0 403 Forbidden');
			throw new \Exception("Incorrect parameter passed to Cookie::set");
		}

		return true;
	}

	public static function basicValidationChecks($paramTypes)
	{
		foreach ($paramTypes as $type => $variables) {
			$functionName = 'is_'.$type;
			foreach ($variables as $variable) {
				if (!$functionName($variable)) {
					return false;
				}
			}
		}
		return true;
	}

	public function clearCookieGroup($groupName)
	{
		$cookieConfig = $this->config['cookies'][$groupName];
		$cookiePath = $cookieConfig['path'];
		if (! (file_exists(__DIR__.'/Resources/Views/Cookies/'.$cookiePath.'/cookies.php') || file_exists(base_path('resource').'/views/vendor/gdprCookie/Cookies/'.$cookiePath.'/cookies.php') ) ) {
			return false;
		}
		
		if(file_exists(base_path('resource').'/views/vendor/gdprCookie/Cookies/'.$cookiePath.'/cookies.php')){
			$clearCookies = include base_path('resource').'/views/vendor/gdprCookie/Cookies/'.$cookiePath.'/cookies.php';
		}else{
			$clearCookies = include __DIR__.'/Resources/Views/Cookies/'.$cookiePath.'/cookies.php';
		}

		$defaults = [
			'path'   => '/',
			'domain' => $_SERVER['HTTP_HOST'],
		];

		if (isset($clearCookies['defaults'])) {
			$defaults = array_merge($defaults, $clearCookies['defaults']);
			unset($clearCookies['defaults']);
		}

		$return = [];

		foreach ($clearCookies as $cookie) {
			$cookie['path'] = isset($cookie['path']) ? $cookie['path'] : $defaults['path'];
			$cookie['domain'] = isset($cookie['domain']) ? $cookie['domain'] : $defaults['domain'];
			self::destroyCookie($cookie['name'], $cookie['path'], $cookie['domain']);
			$return[] = $cookie;
		}

		return $return;
	}

	public static function getCookie($name)
	{
		// If cookie exists - return it, otherwise return false
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
	}

	public static function destroyCookie($name, $path = '', $domain = '')
	{
		// Set cookie expiration to 1 hour ago
		return setcookie($name, '', time() - 3600, $path, $domain);
	}


	// ------

	/**
	 * Check if the GdprCookie is enabled
	 * @return boolean
	 */
	public function isEnabled()
	{
		if ($this->enabled === null) {
			$config = $this->app['config'];
			$configEnabled = value($config->get('gdprcookie.enabled'));

			if ($configEnabled === null) {
				$configEnabled = $config->get('app.gdprcookie');
			}

			$this->enabled = $configEnabled && !$this->app->runningInConsole() && !$this->app->environment('testing');
		}

		return $this->enabled;
	}

	/**
	 * Enable the GdprCookie and boot, if not already booted.
	 */
	public function enable()
	{
		$this->enabled = true;

		if (!$this->booted) {
			$this->boot();
		}
	}

	/**
	 * Disable the GdprCookie
	 */
	public function disable()
	{
		$this->enabled = false;
	}

	protected function isLumen()
	{
		return false;
	}

	/**
	 * Boot the GdprCookie (add collectors, renderer and listener)
	 */
	public function boot()
	{
		if ($this->booted) {
			return;
		}

		/** @var \Atlanticmoon\GdprCookie\GdprCookie $gdprcookie */
		$gdprcookie = $this;

		/** @var Application $app */
		$app = $this->app;


		/*$renderer = $this->getJavascriptRenderer();
		$renderer->setIncludeVendors($this->app['config']->get('debugbar.include_vendors', true));
		$renderer->setBindAjaxHandlerToXHR($app['config']->get('debugbar.capture_ajax', true));*/

		$this->booted = true;
	}


}
