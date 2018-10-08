<?php

namespace Atlanticmoon\GdprCookie\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cookie;

class GdprCookieMiddleware
{
	/** @var \Illuminate\Contracts\Foundation\Application */
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function handle($request, Closure $next)
	{
		$response = $next($request);

		if (! $response instanceof Response) {
			return $response;
		}

		if (! $this->containsBodyTag($response)) {
			return $response;
		}

		return $this->addGdprCookieScriptToResponse($response);
	}

	protected function containsBodyTag(Response $response)
	{
		return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
	}

	/**
	 * @param \Illuminate\Http\Response $response
	 *
	 * @return Response
	 */
	protected function addGdprCookieScriptToResponse(Response $response)
	{
		$content = $response->getContent();
		
		// append style in /head
		$closingHeadTagPosition = $this->getLastClosingHeadTagPosition($content);
		
		$content_head_replaced = ''
		                         .substr($content, 0, $closingHeadTagPosition)
		                         .view('gdprCookie::style')->render()
		                         .substr($content, $closingHeadTagPosition);
		
		$content = $content_head_replaced;
		
		// append code in body
		$bodyMatch = $this->getMatchBodyTagPosition($content);

		$content = $bodyMatch[0] . $bodyMatch[1] . view('gdprCookie::cookies_in_top')->render() . $bodyMatch[2];
		
		// append code in /body
		$closingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);
		
		$content = ''
		           .substr($content, 0, $closingBodyTagPosition)
		           .view('gdprCookie::index')->render()
		           .substr($content, $closingBodyTagPosition);

		return $response->setContent($content);
	}

	protected function getLastClosingBodyTagPosition($content = '')
	{
		return strripos($content, '</body>');
	}

	protected function getFirstOpeningBodyTagPosition($content = '')
	{
		return strripos($content, '<body>') + 6;
	}
	
	protected  function getMatchBodyTagPosition($content = ''){
		return preg_split('/(<body.*?>)/i', $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
	}

	protected function getLastClosingHeadTagPosition($content = '')
	{
		return strripos($content, '</head>');
	}
}
