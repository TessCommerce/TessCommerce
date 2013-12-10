<?php

namespace Tess\Core;

use Tess\Core\Controller\ControllerDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class App extends ContainerBuilder {

	public function __construct()
	{
		parent::__construct();
	}

	public function run()
	{
		require_once('Tess/Core' . DS . 'Config' . DS . 'Routes.php');

		$request = Request::createFromGlobals();

		$context = new RequestContext();
		$context->fromRequest($request);
		$matcher = new UrlMatcher($routes, $context);
		$resolver = new ControllerDispatcher(array(
			'controllers' => 'src' . DS . 'Controller'));
		 
		$request->attributes->add($matcher->match($request->getPathInfo()));
		 
		$resolver->dispatch($request);
	}

	public function debug($resource)
	{
		echo '<pre>';
		print_r($resource);
	}
}



