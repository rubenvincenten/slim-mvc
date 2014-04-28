<?php

namespace Slim\Extension;

use \ActiveRecord\Config;
use \ActiveRecord\Model as ArModel;
use \Slim\Slim;

class Model extends ArModel {

	/**
	 * Database configs
	 * @var array
	 */
	protected static $_dbConnectionConfig;

	/**
	 * Set connection settings
	 * @return void
	 */
	public static function setConnectionConfig()
	{
		if (!static::$_dbConnectionConfig) {
			$config = static::_getDbConnectionConfig();
			if (!is_array($config) || empty($config))
				throw new \ErrorException(
					'Not set configuration of database in file '
					.APPPATH.'config/database.php. '
					.'See example '.__DIR__.'database.php.config_example'
				);
			static::_setDbConnectionConfig($config);
			static::$_dbConnectionConfig = $config;
		}
	}

	/**
	 * Load config from file APPPATH/config/database.php
	 * @return array|false
	 */
	protected static function _getDbConnectionConfig()
	{
		$config = APPPATH.'config/database.php';
		if (file_exists($config)) {
			return include $config;
		}
		return false;
	}

	/**
	 * Sets database configs
	 * @param array $config
	 * @return void
	 */
	protected static function _setDbConnectionConfig(array $config)
	{
		$app = \Slim\Slim::getInstance();
		$cfg = Config::instance();
		$cfg->set_connections($config);
		$cfg->set_default_connection($app->config('mode'));
	}
}

/**
 * Set configs for ActiveRecord
 */
\Slim\Extension\Model::setConnectionConfig();
