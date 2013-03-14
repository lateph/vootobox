<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author Lateph
 */
class LRouter {
	//put your code here
	public $defaultController = 'main';
	public function getController(){
		if(isset($_GET['c'])){
			return $_GET['c'];
		}
		else
			return $this->defaultController;
	}
	public function getAction(){
		if(isset($_GET['a'])){
			return $_GET['a'];
		}
		else
			return 'index';
	}
}

?>
