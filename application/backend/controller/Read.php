<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Read extends controller {
	public function __construct(){
		action('Common/checkSession');
	}
	public function read_list() {
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$datemin = @$post ['datemin'] ? strtotime ( trim ( @$post ['datemin'] ) ) : '';
		$datemax = @$post ['datemax'] ? strtotime ( trim ( @$post ['datemax'] ) ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`pageview` like '%$keywords%')";
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
		$list = db ( 'read' )->where ( $where )->select ();
		if ($list) {
			foreach ( $list as $key => $val ) {
				if ($val ['create_time'])
					$list [$key] ['create_time'] = date ( 'Y-m-d H:i', $val ['create_time'] );
					if ($val ['update_time'])
						$list [$key] ['update_time'] = date ( 'Y-m-d H:i', $val ['update_time'] );
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
		return $view->fetch ( 'read/read_list' );
	}
	public function read_add() {
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'read' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [
					"id" => 0,
					"vipcn_id" => 0,
					'pageview' => '',
					'readrate' => '',
					"status" => 1
			];
			$view->info = $info;
		}
		$vipcn_list = db ( 'vipcn' )->where ( 'status', 1 )->field ( 'id as vipcn_id,name' )->order ( 'id desc' )->select ();
		$view->vipcn_list = $vipcn_list;
		return $view->fetch ( 'read/read_add' );
	}
	public function read_submit() {
		$post = input ( 'post.' );
		$tmparr = explode('-',$post ['vipcn_id']);
		$data = [
				"vipcn_id" => $tmparr[0],
				"vipcn_name" => $tmparr[1],
				"pageview" => $post ['pageview'],
				"readrate" => $post ['readrate'],
				"status" => $post ['status'],
				"create_time" => time ()
		];
		if ($post ['id'] > 0) {
			$data ['update_time'] = time ();
			$ret = db ( 'read' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$ret = db ( 'read' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function read_show() {
		$id = input ( 'get.id' );
		if ($id > 0) {
			$info = db ( 'read' )->where ( 'id', $id )->find ();
			$info ['status'] = $info ['status'] == 1 ? '已启用' : '已停用';
			$info ['create_time'] = date ( 'Y-m-d H:i', $info ['create_time'] );
			$info ['update_time'] = date ( 'Y-m-d H:i', $info ['update_time'] );
		}
		$view = new View ();
		$view->info = $info;
		return $view->fetch ( 'read/read_show' );
	}
	public function switch_state() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'read' )->where ( 'id', $post ['id'] )->update ( [
				'status' => $post ['status']
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function read_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'read' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function read_report() {
		$post = input ( 'post.' );
		$vipcn_type = @$post ['vipcn_type'] ? trim ( @$post ['vipcn_type'] ) : '';
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$datemin = @$post ['datemin'] ? strtotime ( trim ( @$post ['datemin'] ) ) : '';
		$datemax = @$post ['datemax'] ? strtotime ( trim ( @$post ['datemax'] ) ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($vipcn_type) {
			$where .= "and (`vipcn_type`=$vipcn_type)";
		}
		if ($keywords) {
			$where .= "and (`pageview` like '%$keywords%')";
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
		$list = db ( 'read' )->where ( $where )->select ();
		//统计
		$pageview= 0;
		$readrate= 0;
		if ($list) {
			foreach ( $list as $key => $val ) {
				if ($val ['create_time'])
					$list [$key] ['create_time'] = date ( 'Y-m-d H:i', $val ['create_time'] );
					if ($val ['update_time'])
						$list [$key] ['update_time'] = date ( 'Y-m-d H:i', $val ['update_time'] );
						$pageview+=$val['pageview'];
						$readrate+=$val['readrate'];
			}
		}
		$view->list = $list;
		$filter = [
				'vipcn_type' => $vipcn_type,
				'keywords' => $keywords,
				'datemin' => @$post ['datemin'],
				'datemax' => @$post ['datemax'],
				'total' => count ( $list )
		];
		$view->filter = $filter;
		$view->pageview= $pageview;
		$view->readrate= round($readrate/count($list),2);		
		return $view->fetch ( 'read/read_report' );
	}
}