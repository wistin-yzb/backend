<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Comment extends controller {
	
	// feedback_list
	public function feedback_list() {
		$view = new View ();
		return $view->fetch ( 'comment/feedback_list' );
	}
}