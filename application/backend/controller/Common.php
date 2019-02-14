<?php

namespace app\backend\controller;

use \think\Controller;

class Common extends controller {
	/**
	 * 验证session是否失效
	 */
	public function checkSession() {
		if (! session ( 'account' )) {
			$this->redirect ( 'backend/index/login');
		}
	}
}