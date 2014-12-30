<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestMMexport extends PHPUnit_Framework_TestCase {	
	/**
	 * 
	 */
	public function _testExport(){
		$exporter = new IDSUserInfoExporter();
		
		$base_order_id = 351539817;
		$order_step = 10;
		$exporter->export( $base_order_id, $order_step );
		
	}
	
	public function _testAddExport(){
		$exporter = new IDSUserInfoExporter();
		$rel_max_id = $exporter->get_order_rel_max_id();
		var_dump( $rel_max_id );
		
		$order_max_id = $exporter->get_order_max_id();
		var_dump( $order_max_id );

// 		$exporter->export( $base_order_id, $order_step );
	}
	
	public function testCheck(){
		$action = new IDSUserAction();
		$d = $action->select('862029021176603', '2013-10-07', '2013-11-07' );
		
		var_dump( $d );
	}
}

global $database_conf;
$database_conf = array();
$database_conf['order_src'] = array(
		'uri' => 'mysql:host=124.172.236.79;port=33601',
		'login' => 'eric.cai',
		'password' => 'ericcaijun',
);

//histroy
$database_conf['order_src_hisory'] = array(
		'uri' => 'mysql:host=124.172.236.79;port=33063',
		'login' => 'austin.yang',
		'password' => 'wpBOG3OBYAZL',
);

$database_conf['order_stat'] = array(
		'uri' => 'mysql:host=183.61.109.39;port=13307',
		'login' => 'austin.yang',
		'password' => 'wpBOG3OBYAZL',
);

$database_conf['dev_uc'] = array(
		'uri' => 'mysql:host=124.172.236.79;port=33605',
		'login' => 'austin.yang',
		'password' => 'wpBOG3OBYAZL',
);

$database_conf['dev_log'] = array(
		'uri' => 'mysql:host=124.172.236.79;port=63306',
		'login' => 'austin.yang',
		'password' => 'wpBOG3OBYAZL',
);

$database_conf['dev_log_history'] = array(
		'uri' => 'mysql:host=113.107.201.168;port=65321',
		'login' => 'austin.yang',
		'password' => '7bJMzDrmeDj9k',
);

class IDSUserAction{
	public function select( $imei, $start_data = false, $end_data = false ){
		$act_set = array();
		if( empty($end_data ) ){
			$end_time = strtotime('today');
		}else{
			$end_time = strtotime( "{$end_data} 23:59:59" );
		}
		
		if( empty( $start_data ) ){
			$start_time = $end_time - 86400 * 30;
		}else{
			$start_time = strtotime( "{$start_data} 00:00:00" );
		}
		
		$imei_rel_set = $this->get_imei_rel( $imei, $start_time, $end_time );
		
		$imei_rel_set = $this->patch_order_info( $imei_rel_set );
		
		$imei_rel_set = $this->patch_game_info( $imei_rel_set );
		
		$logon_set = array();
		$logon_set = $this->get_logon_info( $imei_rel_set, $start_time, $end_time, true );
		$real_time_logon_set = $this->get_logon_info( $imei_rel_set, $start_time, $end_time );
		
		$logon_set = $this->patch_game_info( $logon_set );
		
		foreach ( $logon_set as $index => $record ){
			$logon_set[$index]['act'] = 1;
		}
		foreach ( $imei_rel_set as $index => $record ){
			$imei_rel_set[$index]['act'] = 2;
		}
		
// 		var_dump( $logon_set );
		$act_set = array_merge( $logon_set, $imei_rel_set );
		
		$act_set = $this->sort_by_time( $act_set );
		
		foreach ( $act_set as $index => $record ){
			$act_set[$index]['time_str'] = date( "Y-m-d H:i:s", $record['created']);
		}
		return $act_set;
	}
	
	public function sort_by_time( $action_set ){
		$time_index_arr = array();
		foreach( $action_set as $record ){
			$time_stamp = $record['created'];
			$time_index_arr[] = $time_stamp;	
		}
		array_multisort( $time_index_arr, $action_set );
		return $action_set;
	}
	
	public function get_imei_rel( $imei, $start_time, $end_time ){
		global $database_conf;
		
		$order_db_conf = $database_conf['order_stat'];
		
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
		
		
		$order_sql =<<<EOF
			SELECT *
			FROM order_stat.cm_order_rel
			WHERE imei='{$imei}' && '{$start_time}' < created && created < '{$end_time}'
EOF;
		
		$valid_order_id_set = array();
		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
	
		$kv_result = array();
		foreach ( $result as $order ){
			$id = $order['id'];
			$kv_result[$id] = $order;
		}
		return $kv_result;
	}

	public function patch_order_info( $imei_rel_set, $history_base = false ){
		global $database_conf;

		$ret_imei_rel_set = $imei_rel_set;

		$order_id_set = array_keys( $ret_imei_rel_set );
		if( empty( $order_id_set ) ){
			return $ret_imei_rel_set;
		}

		$order_id_str = implode( "','", $order_id_set );

		if( $history_base ){
			$order_db_conf = $database_conf['order_src_hisory'];
		}else{
			$order_db_conf = $database_conf['order_src'];	
		}
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
		
		$sql_where = " id in ('{$order_id_str}')";
		$order_sql =<<<EOF
			SELECT id, product_id, product_name
			FROM dev_order.orders
			WHERE {$sql_where}
EOF;

		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
		foreach( $result as $order ){
			$order_id = $order['id'];
			$ret_imei_rel_set[$order_id] = array_merge( $ret_imei_rel_set[$order_id] , $order );
		}
		
		$sql_where = " order_id in ('{$order_id_str}')";
		$order_sql =<<<EOF
			SELECT order_id, useragent, client_time
			FROM dev_order.order_details
			WHERE {$sql_where}
EOF;

		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
		foreach( $result as $order ){
			$order_id = $order['order_id'];
			
			$useragent_arr = json_decode( $order['useragent'], true );
			if( !empty( $useragent_arr['device_model'] ) ){
				$ret_imei_rel_set[$order_id]['device_model'] = $useragent_arr['device_model'];
			}
			if( !empty( $useragent_arr['device_brand'] ) ){
				$ret_imei_rel_set[$order_id]['device_brand'] = $useragent_arr['device_brand'];
			}
		}

		return $ret_imei_rel_set;
	}

	public function patch_game_info( $imei_rel_set ){
		$ret_imei_rel_set = $imei_rel_set;
		
		$game_name_map = array(
				'10096' => '水果忍者',
				'10234' => '水果忍者',
				'10088' => '水果忍者',
				'10405'=>'地铁跑酷',
				'10389'=>'地铁跑酷',
				'10313'=>'神庙逃亡2',
				'10311'=>'神庙逃亡2',
				'10329'=>'神庙逃亡',
				'10203'=>'疯狂喷气机',
				'10202'=>'疯狂喷气机',
				'10137'=>'疯狂喷气机',
				'10108'=>'水果忍者：穿靴子的猫',
				'10110'=>'小鸟爆破',
				'10238'=>'小鸟爆破',
				'10319'=>'小鸟爆破狂热',
		);
		
		foreach ( $ret_imei_rel_set as $index => $rel ){
			$game_id = $rel['game_id'];
			if( empty( $game_name_map[$game_id]) ){
				$ret_imei_rel_set[$index]['game_name'] = "其他游戏";
			}else{
				$ret_imei_rel_set[$index]['game_name'] = $game_name_map[$game_id];
			}
		}
		return $ret_imei_rel_set;
	}


	public function get_logon_info( $imei_rel_set, $start_time, $end_time, $history_base = false ){
		$ret_imei_rel_set = $imei_rel_set;
		
		$player_id_set = array();
		if( empty( $imei_rel_set ) )
			return array();
		
		foreach( $ret_imei_rel_set as $rel ){
			$player_id = $rel['player_id'];
			$player_id_set[] = $player_id;
		}
		
		
		//test
		$player_id_set[] = 358557327;
		
		$player_id_set = array_unique( $player_id_set );
		
		global $database_conf;
	
		$player_id_str = implode( "','", $player_id_set );
		
		$sql_where = " player_id in ('{$player_id_str}')";
	
		if( $history_base ){
			$db_conf = $database_conf['dev_log_history'];
			$table_name = "dgc_standby.playgame_sessions";
		}else{
			$db_conf = $database_conf['dev_log'];
			$table_name = "dgc_log.playgame_sessions";
		}
		
// 		var_dump( $db_conf );return;
		$conn = new PDO( $db_conf['uri'], $db_conf['login'], $db_conf['password'] );	
		$query_sql =<<<EOF
			SELECT *
			FROM {$table_name}
			WHERE {$sql_where} && '{$start_time}' < created && created < '{$end_time}'
EOF;
		
		$user_query = $conn->query( $query_sql );
		$result = $user_query->fetchAll( PDO::FETCH_ASSOC );
		$kv_result = array();
		foreach ( $result as $record ){
			$id = $record['id'];
			$kv_result[$id] = $record;
		}
		
		return $kv_result;
	}
}

class IDSUserInfoExporter{
	public function export( $base_order_id, $order_step){		
		$order_set = $this->get_order_set( $base_order_id, $order_step );
// 		var_dump( $order_set );
		
		$order_set_with_detail = $this->patch_order_detail( $order_set );
		$order_set_with_detail = $this->patch_order_detail( $order_set_with_detail, true );
		var_dump( $order_set_with_detail );

// 		$iret = $this->save_order_rel( $order_set_with_detail );
	}
	
	
	public function patch_order_detail( $order_set, $history_base = false ){
		global $database_conf;
	
		$order_id_set = array_keys( $order_set );
		$order_id_str = implode( "','", $order_id_set);
		
		$sql_where = " order_id in ( '{$order_id_str}' ) ";
		
		if( $history_base ){
			$order_db_conf = $database_conf['order_src_hisory'];
		}else{
			$order_db_conf = $database_conf['order_src'];
		}
		
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
		
		$order_sql =<<<EOF
			SELECT id, order_id, useragent, imei
			FROM dev_order.order_details
			WHERE {$sql_where};
EOF;
		
	
		
		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
		foreach( $result as $detail ){
			unset( $detail['id'] );
			
			$processed_imei = '';
			if( !empty( $detail['imei'] ) ){
				$processed_imei = $detail['imei'];
			}else{
				$ua = json_decode( $detail['useragent'], true );
				if( !empty($ua['imei']) && is_numeric( empty($ua['imei']) ) ) {
					$processed_imei = $ua['imei'];
				}
			}
			$detail['p_imei'] = $processed_imei;
			
			unset( $detail['imei'] );
			unset( $detail['useragent'] );
			
			$order_id = $detail['order_id'];
			unset( $detail['order_id'] );
			$order_set[$order_id] = array_merge( $order_set[$order_id], $detail );
		}
		return $order_set;
	}
	
	public function get_order_set( $base_order_id, $step, $history_base = false  ){
		global $database_conf;
		
		$id_limit = $base_order_id + $step;
		$sql_limit = " paymethod=26 && id>={$base_order_id} && id <{$id_limit}";
		
		if( $history_base ){
			$order_db_conf = $database_conf['order_src_hisory'];
		}else{
			$order_db_conf = $database_conf['order_src'];
		}
		
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
		
		$order_sql =<<<EOF
			SELECT id, game_id, player_id, created
			FROM dev_order.orders
			WHERE {$sql_limit}
			ORDER BY id DESC
EOF;
		$valid_order_id_set = array();
		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
		
		$kv_result = array();
		foreach ( $result as $order ){
			$id = $order['id'];
			$kv_result[$id] = $order;
		}
		
		return $kv_result;
	}
	
	
	public function save_order_rel( $order_dataset ){
		global $database_conf;
		
		$order_db_conf = $database_conf['order_stat'];
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
		
		$save_sql = '';
		foreach( $order_dataset as $order_record ){
			$order_id = $order_record['id'];
			
			$game_id = $order_record['game_id'];
			$player_id = $order_record['player_id'];
			$imei = $order_record['p_imei'];
			$created = $order_record['created'];
		
			$save_sql .=<<<EOF
			INSERT INTO order_stat.cm_order_rel
			SET id = '{$order_id}', game_id = '{$game_id}', player_id = '{$player_id}',
				imei = '{$imei}', created='{$created}'
			ON DUPLICATE KEY UPDATE game_id = '{$game_id}', player_id = '{$player_id}',imei = '{$imei}', created='{$created}';
EOF;
		}
		
		$statement = $order_conn->prepare( $save_sql );
		$iret = $statement->execute();
		
		return $iret;
		
	}

	public function get_order_rel_max_id(){
		global $database_conf;
		
		$order_db_conf = $database_conf['order_stat'];
		
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
		
		$order_sql =<<<EOF
			SELECT max(id) as maxid
			FROM order_stat.cm_order_rel;
EOF;
		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
		
		$max_id = $result[0]['maxid'];
		return $max_id;
	}
	
	public function get_order_max_id(){
		global $database_conf;
	
		$order_db_conf = $database_conf['order_src'];
	
		$order_conn = new PDO( $order_db_conf['uri'], $order_db_conf['login'], $order_db_conf['password'] );
	
		$order_sql =<<<EOF
			SELECT max(id) as maxid
			FROM dev_order.orders;
EOF;
		$user_order_query = $order_conn->query( $order_sql );
		$result = $user_order_query->fetchAll( PDO::FETCH_ASSOC );
	
		$max_id = $result[0]['maxid'];
		return $max_id;
	}
}