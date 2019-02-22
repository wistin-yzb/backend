<?php

namespace app\backend\controller;

use \think\View;
use think\Controller;
use think\Db;
class Dnspod extends controller {
	public function __construct() {
		import('dnspod-api-php-web-master.dnspod',VENDOR_PATH);		
		 
		@session_start();
	}
	
	//dnspod_list
	public function dnspod_list() {
		$post = input ( 'post.' );
		$keywords = @$post ['keywords'] ? trim ( @$post ['keywords'] ) : '';
		$view = new View ();
		$dnspod = new \dnspod();	
		$_POST['token_id'] = "77302";
		$_POST['token_key'] = "8d81b469908cffdb4e9191552a965743";
		if ($_POST['token_id'] == '') {
			if ($_SESSION['token_id'] == '') {
				$dnspod->message('danger', '请输入Token ID。', -1);
			}
		} else {
			$_SESSION['token_id'] = $_POST['token_id'];
		}
		if ($_POST['token_key'] == '') {
			if ($_SESSION['token_key'] == '') {
				$dnspod->message('danger', '请输入Token Key。', -1);
			}
		} else {
			$_SESSION['token_key'] = $_POST['token_key'];
		}		
		$_SESSION['cookies'] = time();
		$postArr = [
								'domain' => $keywords,
								'record_type' => 'A'
						];
		$response = $dnspod->api_call('Record.List', $postArr);			
		if($response){
			$view->list = $response['records'];			
			$filter = [
					'keywords' => $keywords,
					'total' => count ($response['records'])
			];
		}else{
			$view->list = array();
			$filter = [
					'keywords' => $keywords,
					'total' => count (array())
			];
		}
	
		$view->filter = $filter;
		return $view->fetch ( 'dnspod/dnspod_list' );
	}
	
	//record_add
	public function dnspod_add() {		
		$input = input ( 'get.' );
		$view = new View ();
		$view->domain = $input['domain'];
		return $view->fetch ( 'dnspod/dnspod_add' );
	}
	
	//dnspod_sumbit
	public function dnspod_sumbit() {		
		exit(json_encode(1));
	}
	
	//dnspod_del
	public function dnspod_del() {
		exit(json_encode(1));
	}
}