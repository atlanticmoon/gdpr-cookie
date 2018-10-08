<?php

namespace Atlanticmoon\GdprCookie;

use Atlanticmoon\GdprCookie\GdprCookie;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class GdprCookieServiceProvider extends ServiceProvider
{
	protected $namespace='Atlanticmoon\GdprCookie';
	
	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{

		$this->publishes([
			__DIR__.'/../config/gdprcookie.php' => config_path('gdprcookie.php'),
		], 'config');
		$this->publishes([
			__DIR__.'/Resources/Views' => base_path('resources/views/vendor/gdprCookie'),
		], 'views');
		$this->publishes([
			__DIR__.'/Resources/Lang' => base_path('resources/lang/vendor/gdprCookie'),
		], 'lang');

		$this->app->register('Atlanticmoon\GdprCookie\Providers\GdprCookieRouteProvider');

		$this->loadViewsFrom(__DIR__.'/Resources/Views/', 'gdprCookie');

		$this->mergeConfigFrom(__DIR__.'/../config/gdprcookie.php', 'gdprcookie');

		$this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'gdprCookie');

		$this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
			$encryptCookies->disableFor(config('gdprcookie.cookie_name'));
		});

		$gdprCookie = new GdprCookie();
		$decisionMade = $gdprCookie->getDecisionMode();
		$gdprCookieConfig = Config::get('gdprcookie');
		$alreadyConsentedWithCookies = (Cookie::get($gdprCookieConfig['cookie_name']) === true);

		$this->app['view']->composer('gdprCookie::style', function (View $view) use ($alreadyConsentedWithCookies,$gdprCookieConfig) {
			$view->with(
				compact(
					'alreadyConsentedWithCookies',
					'gdprCookieConfig'
				));
		});

		$this->app['view']->composer('gdprCookie::cookies_in_top', function (View $view) use ($alreadyConsentedWithCookies,$gdprCookie,$decisionMade,$gdprCookieConfig) {
			$view->with(
				compact(
					'alreadyConsentedWithCookies',
					'gdprCookie',
					'decisionMade',
					'gdprCookieConfig'
				));
		});
		
		$this->app['view']->composer('gdprCookie::index', function (View $view) use ($alreadyConsentedWithCookies,$gdprCookie,$decisionMade,$gdprCookieConfig) {
			$view->with(
				compact(
					'alreadyConsentedWithCookies',
					'gdprCookie',
					'decisionMade',
					'gdprCookieConfig'
				));
		});

	}

	/**
	 * Register the application services.
	 */
	public function register()
	{

	}

	


}
