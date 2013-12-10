<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

// Add and configure routes 

$routes->add('hello', new Route('/hello/{name}', array(
	'_controller' => 'indexController',
	'_method' => 'index',
)));