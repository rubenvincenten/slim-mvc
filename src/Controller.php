<?php

namespace Slim\Extension;

use \Slim\Slim;

abstract class Controller {

	/**
	 * Instance of \Slim\Slim
	 * @var object
	 */
	public $app;

	/**
	 * Instance of \Slim\Http\Request
	 * @var object
	 */
	public $request;

	/**
	 * Instance of \Slim\Http\Response
	 * @var object
	 */
	public $response;

	/**
	 * @param 	object 	$app	// instance of class \Slim\Slim
	 * @retrurn void
	 */
	public function __construct(Slim $app = NULL)
	{
		$this->app 		= $app;
		$this->request 	= $app->request;
		$this->response = $app->response;
	}

	/**
	 * Run action
	 * @param string $action
	 * @return void
	 */
	public function execute($action = NULL)
	{
		$action = ($action == NULL)
			? strtolower($this->request->getMethod())
			: $action;

		$this->before();
		$this->{$action}();
		$this->after();
	}

	/**
	 * Will executed before the action
	 * @return void
	 */
	public function before()
	{
		// ...
	}

	/**
	 * Will executed after the action
	 * @return void
	 */
	public function after()
	{
		// ...
	}

	/**
	 * Gets route params
	 *
	 * @param 	string 	$key
	 * @param 	string 	$default
	 * @return 	string
	 */
	public function param($key = NULL, $default = NULL)
	{
		$params = $this->app->router->getCurrentRoute()->getParams();

		return (array_key_exists($key, $params))
			? $params[$key]
			: $default;
	}
}
