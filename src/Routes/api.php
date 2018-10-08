<?php

Route::middleware('api')->post('/atlanticmoon/gdprcookie/ajax', 'Atlanticmoon\GdprCookie\Controllers\ApiController@cookieApiAction');
