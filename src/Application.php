<?php


namespace Turovskiy\WpEloquent;

use Turovskiy\WpEloquent\Events\Dispatcher;
use Turovskiy\WpEloquent\Database\Capsule\Manager;
use Turovskiy\WpEloquent\Database\WpConnection;
use Turovskiy\WpEloquent\Support\Facades\Facade;

class Application {

	/**
	 * @var Application
	 */
	protected static $instance;
	protected $manager;
	protected function __construct() {
		$this->manager = new Manager();
	}
	protected function setupWp( $useWpConnection = true ) {
		if ( $useWpConnection ) {
			$driver = 'wp';
		} else {
			$driver = 'mysql';
		}
		global $wpdb;

		if ( strpos( $wpdb->db_version(), 'SQLite' ) !== false ) {
			$driver = 'sqlite';
		}

		$dbuser     = defined( 'DB_USER' ) ? DB_USER : '';
		$dbpassword = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : '';
		$dbname     = defined( 'DB_NAME' ) ? DB_NAME : '';
		$dbhost     = defined( 'DB_HOST' ) ? DB_HOST : '';
		$charset    = $wpdb->charset;
		$collate    = $wpdb->collate;

		$connection_data = array(
			'driver'    => $driver,
			'host'      => $dbhost,
			'database'  => $dbname,
			'username'  => $dbuser,
			'password'  => $dbpassword,
			'charset'   => $charset,
			'collation' => $collate,
			'prefix'    => $wpdb->prefix,
		);

		if ( class_exists( '\WP_SQLite_Translator' ) ) {
			$connection_data = array(
				'driver'   => 'sqlite',
				'database' => defined( 'FQDB' ) ? FQDB : '',
				'prefix'   => $wpdb->prefix,
			);
		}

		$this->setupConnection( $connection_data );
	}
	protected function setupConnection( $connection = array() ) {
		$this->manager->addConnection( $connection );
	}
	protected function setupEloquent() {
		$app = $this->manager->getContainer();
		$app->instance( 'db', $this->manager->getDatabaseManager() );
		Facade::setFacadeApplication( $app );
		$this->manager->setAsGlobal();
		$this->manager->setEventDispatcher( new Dispatcher( $app ) );
		$this->manager->bootEloquent();
	}
	public static function bootWp( $useWpConnection = true ) {
		if ( ! static::$instance ) {
			static::$instance = new static();
			static::$instance->setupWp( $useWpConnection );
			static::$instance->setupEloquent();
		}
		return static::$instance;
	}
	public static function boot( $connection = array() ) {
		if ( ! static::$instance ) {
			static::$instance = new static();
			static::$instance->setupConnection( $connection );
			static::$instance->setupEloquent();
		}
		return static::$instance;
	}
	public function getCapsule() {
		return $this->manager;
	}
	public static function getInstance() {
		return static::$instance;
	}
	/**
	 * Dynamically pass methods to the default connection.
	 *
	 * @param  string $method
	 * @param  array  $parameters
	 * @return mixed
	 */
	public static function __callStatic( $method, $parameters ) {
		return static::$instance->getCapsule()->getConnection()->$method( ...$parameters );
	}
}
