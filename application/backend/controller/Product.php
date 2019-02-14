<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;

class Product extends controller {
	
	// product_brand
	public function product_brand() {
		$view = new View ();
		return $view->fetch ( 'product/product_brand' );
	}
	
	// product_category
	public function product_category() {
		$view = new View ();
		return $view->fetch ( 'product/product_category' );
	}
	
	// poduct_category_add
	public function product_category_add() {
		$view = new View ();
		return $view->fetch ( 'product/product_category_add' );
	}
	
	// product_list
	public function product_list() {
		$view = new View ();
		return $view->fetch ( 'product/product_list' );
	}
	
	// product_add
	public function product_add() {
		$view = new View ();
		return $view->fetch ( 'product/product_add' );
	}
	
	// product_show
	public function product_show() {
		$view = new View ();
		return $view->fetch ( 'product/product_show' );
	}
}