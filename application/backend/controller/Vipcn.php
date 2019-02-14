<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Vipcn extends controller {
	public function __construct(){
		action('Common/checkSession');
	}
	public function vipcn_list() {
		$post = input ( 'post.' );
		$type = @$post ['type'] ? trim ( @$post ['type'] ) : '';
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$datemin = @$post ['datemin'] ? strtotime ( trim ( @$post ['datemin'] ) ) : '';
		$datemax = @$post ['datemax'] ? strtotime ( trim ( @$post ['datemax'] ) ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($type) {
			$where .= "and (`type` =$type )";
		}
		if ($keywords) {
			$where .= "and (`name` like '%$keywords%' or `account` like '%$keywords%')";
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
		$list = db ( 'vipcn' )->where ( $where )->select ();
		if ($list) {
			foreach ( $list as $key => $val ) {
				$list [$key] ['create_time'] = date ( 'Y-m-d H:i', $val ['create_time'] );
				if ($val ['update_time'])
					$list [$key] ['update_time'] = date ( 'Y-m-d H:i', $val ['update_time'] );
			}
		}
		$view->list = $list;
		$filter = [ 
				'type' => $type,
				'keywords' => $keywords,
				'datemin' => @$post ['datemin'],
				'datemax' => @$post ['datemax'],
				'total' => count ( $list ) 
		];
		$view->filter = $filter;
		return $view->fetch ( 'vipcn/vipcn_list' );
	}
	public function vipcn_add() {
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'vipcn' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [ 
					'name' => '',
					'remark' => '',
					"id" => 0,
					'account' => '',
					'AppID' => '',
					"AppSecret" => '',
					"type" => '' 
			];
			$view->info = $info;
		}
		return $view->fetch ( 'vipcn/vipcn_add' );
	}
	public function vipcn_submit() {
		$post = input ( 'post.' );
		$data = [ 
				"name" => $post ['name'],
				"account" => $post ['account'],
				"AppID" => $post ['AppID'],
				"AppSecret" => $post ['AppSecret'],
				"type" => $post ['type'],
				"remark" => $post ['remark'],
				"create_time" => time () 
		];
		if ($post ['id'] > 0) {
			$data ['update_time'] = time ();
			$ret = db ( 'vipcn' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$ret = db ( 'vipcn' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function vipcn_show() {
		$id = input ( 'get.id' );
		if ($id > 0) {
			$info = db ( 'vipcn' )->where ( 'id', $id )->find ();
			$info ['type'] = $info ['type'] == 1 ? '服务号' : ($info ['type'] == 2 ? '订阅号' : '企业号');
			$info ['status'] = $info ['status'] == 1 ? '已启用' : '已停用';
			$info ['create_time'] = date ( 'Y-m-d H:i', $info ['create_time'] );
			$info ['update_time'] = date ( 'Y-m-d H:i', $info ['update_time'] );
		}
		$view = new View ();
		$view->info = $info;
		return $view->fetch ( 'vipcn/vipcn_show' );
	}
	public function switch_state() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'vipcn' )->where ( 'id', $post ['id'] )->update ( [ 
				'status' => $post ['status'] 
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function vipcn_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'vipcn' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
}