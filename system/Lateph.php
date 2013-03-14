<?php
/**
 * @property LRouter $router Description
 */
class Lateph{
	/**
	 * Framework Kecil Cobak"
	 * @var Lateph 
	 */
	private static $_app;
	private $appFolder;
	private $sysFolder;
	private $components = array(
		 'router'=>array(
			  'class'=>'LRouter'
		 ),
		 'db'=>array(
			  'class'=>'PDO',
			  'construktor'=>array(
					'string'=>'mysql:host=127.0.0.1;dbname=track;charset=utf8',
					'user'=>'root',
					'pass'=>''
				)
		 ),
	);
	public function __construct($config) {
		$time = microtime(true);
		self::$_app = $this;
		$this->sysFolder = dirname(__FILE__);
		
		foreach($config as $key=>$value){
			$this->$key = $value;
		}
		spl_autoload_register("Lateph::autoLoadSys");
		spl_autoload_register("Lateph::autoLoadAppController");
		$class = $this->getControllerClass();
		$controller = new $class;
		$action = $this->getActionName();
		$controller->$action();
		echo "Time Elapsed: ".(microtime(true) - $time)."s";
		
	}
	public function __get($name) {
		try{
			if(!isset($this->components[$name])){
				throw new Exception("Componen Tidak Ditemukan");
			}
			$componen = $this->components[$name];
			if(!isset($componen['class'])){
				throw new Exception("Class Name Tidak Difinisikan");
			}
			if(isset($componen['construktor'])){
				$reflect  = new ReflectionClass($componen['class']);
				$this->$name = $reflect->newInstanceArgs($componen['construktor']);
			}
			else{
				$this->$name = new $componen['class'];
			}
			foreach($componen as $var=>$value){
				if($value=='class' or $value=='construktor'){
					continue;
				}
				$this->$name->$var = $value;
			}
			
		}
		catch (Exception $e){
			throw new Exception($e->getMessage());
		}
		return $this->$name;
	}
	public function getControllerClass(){
		return ucfirst($this->router->getController().'Controller');
	}
	public function getActionName(){
		return 'action'.ucfirst($this->router->getAction());
	}
	public static function autoLoadSys($className){
		 $filename = Lateph::app()->sysFolder."/" . $className . ".php";
		 if (is_readable($filename)) {
			  require $filename;
		 }
	}
	public static function autoLoadAppController($className){
		 $filename = Lateph::app()->appFolder."/controllers/" . $className . ".php";
		 if (is_readable($filename)) {
			  require $filename;
		 }
	}
	
	public static function run($config){
		self::$_app = new Lateph($config);
	}
	/**
	 * Get Instanc App
	 * @return Lateph
	 */
	public static function app(){
		return self::$_app;
	}
}