<?php

namespace Atlanticmoon\GdprCookie\Providers;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class GdprCookieRouteProvider extends RouteServiceProvider{
	protected $namespace = 'Atlanticmoon\GdprCookie\Controllers';

	public function boot(){
		parent::boot();
	}

	public function map()
	{
		$this->mapApiRoutes();

		$this->mapWebRoutes();
	}


	protected function mapApiRoutes()
	{
		/*Route::prefix('atlanticmoon\gdprCookie\api')
		     ->middleware('api')
		     ->namespace($this->namespace)
		     ->group(__DIR__ . '\Routes\api.php');*/
		Route::middleware('api')
		     //->namespace($this->namespace)
		     ->group(__DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR.'Routes'.DIRECTORY_SEPARATOR.'api.php');
		
	}

	protected function mapWebRoutes()
	{
		/*Route::prefix('atlanticmoon\gdprCookie')
		     ->middleware('web')
		     ->namespace($this->namespace)
		     ->group(__DIR__ . '\Routes\web.php');*/
		Route::middleware('web')
		     //->namespace($this->namespace)
			->group(__DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR .'Routes'.DIRECTORY_SEPARATOR.'api.php');
	}
}
