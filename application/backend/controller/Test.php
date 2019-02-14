<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Test extends controller {
	public function test_list() {
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$datemin = @$post ['datemin'] ? strtotime ( @$post ['datemin'] ) : '';
		$datemax = @$post ['datemax'] ? strtotime ( @$post ['datemax'] ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`title` like '%$keywords%' or `content` like '%$keywords%')";
		}
		if ($datemin != '' && $datemax == '') {
			$where .= "and `create_time`>='$datemin'";
		}
		if ($datemin == '' && $datemax != '') {
			$where .= "and `create_time`<='$datemax'";
		}
		if ($datemin && $datemax) {
			$where .= "and (`create_time`>='$datemin' and `create_time`<='$datemax')";
		}
		
		$list = db ( 'test' )->where ( $where )->select ();
		if ($list) {
			foreach ( $list as $key => $val ) {
				$list [$key] ['create_time'] = date ( 'Y-m-d H:i:s', $val ['create_time'] );
			}
		}
		$view->list = $list;
		$filter = [ 
				'keywords' => $keywords,
				'datemin' => @$post ['datemin'],
				'datemax' => @$post ['datemax'],
				'total' => count ( $list ) 
		];
		$view->filter = $filter;
		return $view->fetch ( 'test/test_list' );
	}
	public function test_add() {
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'test' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [ 
					'title' => '',
					'content' => '',
					"id" => 0 
			];
			$view->info = $info;
		}
		return $view->fetch ( 'test/test_add' );
	}
	public function test_submit() {
		$post = input ( 'post.' );
		$data = [ 
				"title" => $post ['title'],
				"content" => $post ['content'],
				"create_time" => time () 
		];
		if ($post ['id'] > 0) {
			$ret = db ( 'test' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$ret = db ( 'test' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function test_show() {
		$view = new View ();
		return $view->fetch ( 'test/test_show' );
	}
	public function switch_state() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'test' )->where ( 'id', $post ['id'] )->update ( [ 
				'status' => $post ['status'] 
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function test_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'test' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
}