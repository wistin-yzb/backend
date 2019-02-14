<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Article extends controller {
	
	// article-list
	public function article_list() {
		$view = new View ();
		return $view->fetch ( 'article/article_list' );
	}
	
	//article-add
	public function article_add() {
		$view = new View ();
		return $view->fetch ( 'article/article_add' );
	}
	
	//article-class
	public function article_class() {
		$view = new View ();
		return $view->fetch ( 'article/article_class' );
	}
	
	//article-class-edit
	public function article_class_edit() {
		$view = new View ();
		return $view->fetch ( 'article/article_class_edit' );
	}
}