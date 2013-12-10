<?php
/*
 * This file is part of the Tess Commerce package.
 *
 * (c) Anthony De Meulemeester
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tess\Core\Controller;

use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpFoundation\Request;

	/**
     * ControllerDispatcher maps the matched route to the controller.
     * And also fetches the arguments.
     *
     * @author Anthony De Meulemeester
     *
     * @api
     */
class ControllerDispatcher implements ControllerResolverInterface {

	/**
     * Path where the controllers can be found.
     *
     * @param string
     *
     * @api
     */
	private $pathToController;

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	private $controller;

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	private $method;

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	public function __construct(array $options = null)
	{
		$this->pathToController = $options['controllers'];
	}

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	public function getController(Request $request)
	{
		if(!$controller = $request->attributes->get('_controller')) {
			throw new \Exception('Unable to find the controller, cause the _controller parameter is missing');
		}

		$this->controller = $controller;
	}

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	public function getMethod(Request $request)
	{
		if(!$method = $request->attributes->get('_method')) {
			throw new \Exception('Unable to find the method, cause the _method parameter is missing');
		}

		$this->method = $method;
	}

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	public function dispatch(Request $request)
	{	
		$this->getController($request);
		$this->getMethod($request);
	
		$controllerclassFile = $this->pathToController . DS . $this->controller . '.php';

		if(file_exists($controllerclassFile))
			require_once($controllerclassFile);

		$this->controller = new $this->controller();
		$controller = null;

		call_user_func_array(array($this->controller, $this->method), $this->getArguments($request, $controller));
	}

	/**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     *
     * @api
     */
	public function getArguments(Request $request, $controller)
	{
		$request->attributes->remove('_route');
		$request->attributes->remove('_controller');
		$request->attributes->remove('_method');

		foreach($request->attributes as $arguments => $values) {
			$args[] = $values;
		}
		
		return $args;
	}
}