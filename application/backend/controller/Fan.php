<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;

class Fan extends controller {
	public function __construct(){
		action('Common/checkSession');
	}
	public function fan_list() {
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$datemin = @$post ['datemin'] ? strtotime ( trim ( @$post ['datemin'] ) ) : '';
		$datemax = @$post ['datemax'] ? strtotime ( trim ( @$post ['datemax'] ) ) : '';
		$view = new View ();
		$where = "`id`>0 ";
		if ($keywords) {
			$where .= "and (`total_fan_num` like '%$keywords%')";
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
		$list = db ( 'fan' )->where ( $where )->select ();
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
		return $view->fetch ( 'fan/fan_list' );
	}
	public function fan_add() {
		$id = input ( 'get.id' );
		$view = new View ();
		if ($id > 0) {
			$info = db ( 'fan' )->where ( 'id', $id )->find ();
			$view->info = $info;
		} else {
			$info = [ 
					"id" => 0,
					"vipcn_id" => 0,
					'total_fan_num' => '',
					'today_new_num' => '',
					'today_delete_num' => '',
					'today_extra_num' => '',
					"status" => 1 
			];
			$view->info = $info;
		}
		$vipcn_list = db ( 'vipcn' )->where ( 'status', 1 )->field ( 'id as vipcn_id,name,type' )->order ( 'id desc' )->select ();
		$view->vipcn_list = $vipcn_list;
		return $view->fetch ( 'fan/fan_add' );
	}
	public function fan_submit() {
		$post = input ( 'post.' );
		$tmparr = explode ( '-', $post ['vipcn_id'] );
		$data = [ 
				"vipcn_id" => $tmparr [0],
				"vipcn_name" => $tmparr [1],
				"vipcn_type" => $tmparr [2],
				"total_fan_num" => $post ['total_fan_num'],
				"today_new_num" => $post ['today_new_num'],
				"today_delete_num" => $post ['today_delete_num'],
				"today_extra_num" => $post ['today_new_num'] - $post ['today_delete_num'],
				"status" => $post ['status'],
				"create_time" => time () 
		];
		if ($post ['id'] > 0) {
			$data ['update_time'] = time ();
			$ret = db ( 'fan' )->where ( "id", '=', $post ['id'] )->update ( $data );
		} else {
			$ret = db ( 'fan' )->insert ( $data );
		}
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function fan_show() {
		$id = input ( 'get.id' );
		if ($id > 0) {
			$info = db ( 'fan' )->where ( 'id', $id )->find ();
			$info ['status'] = $info ['status'] == 1 ? '已启用' : '已停用';
			$info ['create_time'] = date ( 'Y-m-d H:i', $info ['create_time'] );
			$info ['update_time'] = date ( 'Y-m-d H:i', $info ['update_time'] );
		}
		$view = new View ();
		$view->info = $info;
		return $view->fetch ( 'fan/fan_show' );
	}
	public function switch_state() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$ret = db ( 'fan' )->where ( 'id', $post ['id'] )->update ( [ 
				'status' => $post ['status'] 
		] );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function fan_del() {
		$post = input ( 'post.' );
		if (! $post) {
			exit ( json_encode ( - 1 ) );
		}
		$idsArr = explode ( ',', $post ['ids'] );
		$ret = db ( 'fan' )->delete ( $idsArr );
		if ($ret) {
			exit ( json_encode ( 1 ) );
		}
		exit ( json_encode ( - 1 ) );
	}
	public function fan_report() {
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
			$where .= "and (`total_fan_num` like '%$keywords%')";
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
		$list = db ( 'fan' )->where ( $where )->select ();
		//统计
		$total_fan_num = 0;
		$today_new_num = 0;
		$today_delete_num = 0;
		$today_extra_num = 0;
		if ($list) {
			foreach ( $list as $key => $val ) {
				if ($val ['create_time'])
					$list [$key] ['create_time'] = date ( 'Y-m-d H:i', $val ['create_time'] );
					if ($val ['update_time'])
						$list [$key] ['update_time'] = date ( 'Y-m-d H:i', $val ['update_time'] );
						$total_fan_num+=$val['total_fan_num'];
						$today_new_num+=$val['today_new_num'];
						$today_delete_num+=$val['today_delete_num'];
						$today_extra_num+=$val['today_extra_num'];
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
		$view->total_fan_num= $total_fan_num;
		$view->today_new_num = $today_new_num;
		$view->today_delete_num= $today_delete_num;
		$view->today_extra_num= $today_extra_num;
		return $view->fetch ( 'fan/fan_report' );
	}
	
	public function fan_report_charts1() {
		$view = new View ();
		return $view->fetch ( 'fan/fan_report_charts1' );
	}
}