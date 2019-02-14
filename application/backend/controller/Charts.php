<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Charts extends controller {
	// charts1
	public function charts1() {
		$view = new View ();
		return $view->fetch ( 'charts/charts1' );
	}
	
	// charts2
	public function charts2() {
		$view = new View ();
		return $view->fetch ( 'charts/charts2' );
	}
	
	// charts3
	public function charts3() {
		$view = new View ();
		return $view->fetch ( 'charts/charts3' );
	}
	
	// charts4
	public function charts4() {
		$view = new View ();
		return $view->fetch ( 'charts/charts4' );
	}
	
	// charts5
	public function charts5() {
		$view = new View ();
		return $view->fetch ( 'charts/charts5' );
	}
	
	// charts6
	public function charts6() {
		$view = new View ();
		return $view->fetch ( 'charts/charts6' );
	}
	
	// charts7
	public function charts7() {
		$view = new View ();
		return $view->fetch ( 'charts/charts7' );
	}
}