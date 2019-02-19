<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Line extends controller {
	public function __construct() {
		action ( 'Common/checkSession' );
	}
	
	public function line_list() {
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' )";
		}
		$list = db ( 'line' )->where ( $where )->order('id','desc')->select ();	
		if ($list) {
			foreach ( $list as $key => $val ) {
				if ($val ['update_time'])
					$list [$key] ['update_time'] = date ( 'Y-m-d H:i', $val ['update_time'] );
			}
		}
		$view->list = $list;
		$filter = [
				'keywords' => $keywords,
				'total' => count ( $list )
		];
		$view->filter = $filter;		
		return $view->fetch ( 'line/line_list' );
	}
	
	public function line_add() {
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'line' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,			
					'name' => '',
					'remark' => '',
					'state_ip' => '',
			];
			$view->info = $info;
		}	
		return $view->fetch ( 'line/line_add' );
	}
	
	public function line_submit() {
		$post = input ( 'post.' );		
		$data = [
				"name" => $post ['name'],								
				"remark" => $post ['remark'],
				"state_ip" => $post ['state_ip'],
				"status" => 1,
				"update_time" => time ()
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'line' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$is_exists = db ( 'line' )->where ( "name", '=', trim($post ['name']) )->find();
			if($is_exists){
				exit ( json_encode ( - 2) );
			}
			$ret = db ( 'line' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function switch_state() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'line' )->where ( 'id', $post ['id'] )->update ( [
				'status' => $post ['status']
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	
	public function line_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'line' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
}