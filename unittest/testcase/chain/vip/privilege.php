<?php
/**
 * @target http://test.vip.ids111.com/vip/insert_pri_items
 * 
 * 
 * @author chain
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPrivilege extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		$str = file_get_contents(dirname( __FILE__ ) . "/conf/pri_list.csv");
		$str_arr = explode("\n", $str);
		$global_privilege_pri_list = array();
		$global_year_pri_list = array();
		foreach ($str_arr as $one_item) {
			$value = explode(",", $one_item);
			$tmp_arr =  array();
			foreach ($value as $k => $d) {
				$value[$k] = trim($d);
			}
			$key_words = empty($value[1]) ? 0 : $value[1];
			if ($value[4])
			{
				$current_arr = $global_year_pri_list;
			}
			else
			{
				$current_arr = $global_privilege_pri_list;
			}
			$has_key = $this->key_exists($current_arr, $value[3], $value[5], $value[1]);

			$current_arr[$value[3]][$value[5]][$value[1]]['key'] = $key_words;
			$current_arr[$value[3]][$value[5]][$value[1]]['values'][] = array(
						"id" => $value[0],
						"count" => $value[2],
						"type" => 1,
			);
			if ($value[4])
			{
				$global_year_pri_list = $current_arr;
			}
			else
			{
				$global_privilege_pri_list = $current_arr;
			}
		}
//		var_dump($global_privilege_pri_list);
//		$global_privilege_pri_list = PrivilegeConf::$global_privilege_pri_list;
//		var_dump($global_privilege_pri_list);exit;

//		$global_year_pri_list = PrivilegeConf::$global_year_pri_list;
		
		$post_arr = array();
		foreach ($global_privilege_pri_list as $vip_level => $pri_list) {
			foreach ($pri_list as $pri_type => $value) {
				foreach ($value as $items) {
					$tmp_key_words = $items["key"];
					$pri_pack_value = json_encode($items["values"]);

					$post_arr[] = array(
						"game_id" => "10313",
						"pri_type" => $pri_type,
						"vip_level" => $vip_level,
						"is_year_vip" => 0,
						"keywords" => $tmp_key_words,
						"pri_pack_value" => $pri_pack_value,
					);
				}
			}
		}

		foreach ($global_year_pri_list as $vip_level => $pri_list) {
			foreach ($pri_list as $pri_type => $value) {
				foreach ($value as $items) {
					$tmp_key_words = $items["key"];
					$pri_pack_value = json_encode($items["values"]);

					$post_arr[] = array(
						"game_id" => "10313",
						"pri_type" => $pri_type,
						"vip_level" => $vip_level,
						"is_year_vip" => 1,
						"keywords" => $tmp_key_words,
						"pri_pack_value" => $pri_pack_value,
					);
				}
			}
		}
		return array(
			array(
					"cgi" => "http://{$target_domain}/vip/insert_pri_list",
					"post" => $post_arr,
					"",
					"",
			),
		);
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGICharge( $str_target_cgi, $post_arrs, $expect_result, $desc = "" ){
		$target_domain = TARGET_DOMAIN;
		foreach ($post_arrs as $tmp_key => $post_arr) {
			//先插入
			$obj_ret_data = $this->curl_exec($str_target_cgi, $post_arr, TARGET_HOST );
			
			$ret_data = json_decode($obj_ret_data, true);
			if (!empty($ret_data["lastInsertId"]))
			{
				$lastInsertId = $ret_data["lastInsertId"];
			}
			else
			{
				var_dump($post_arr,$ret_data);
				$this->assertTrue( !empty( $ret_data["cgi_code"] ) );
				$this->assertTrue( ( $ret_data["cgi_code"] == 200) );
			}
			
			$ret_id = $ret_data["lastInsertId"];

			$game_id = $post_arr["game_id"];

			///查询
			$query_url = "http://{$target_domain}/vip/get_privilege_by_udid?gid={$game_id}&udid=418ss05489790_61083080r270q10on2q";
			$return = $this->curl_exec($query_url, "", TARGET_HOST);
//			var_dump($return, $query_url);
			//var_dump( $return );

			///删除
			$delete_url = "http://{$target_domain}/vip/delete_pri_data";
			$delete_arr = array(
					'id' => $ret_id,
					'table' => 'pri_list',
				);
//			$return = $this->curl_exec($delete_url, $delete_arr, TARGET_HOST);
			var_dump( $return );
		}
		
	}

 
    /**
     * curl请求
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    private function curl_exec($url, $post_data = "", $need_host = "")
    {
    	$ch = curl_init();
    	curl_setopt( $ch, CURLOPT_URL, $url );
    	curl_setopt( $ch, CURLOPT_TIMEOUT, 1 );
    	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    	//设置超时
    	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    
    	//如果需要配置host
    	if (!empty($need_host))
    	{
    		$host = array("Host: {$need_host}");
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
    	}
    
    	if (!empty($post_data))
    	{
    		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    	}
    	$xml_data = curl_exec( $ch );
    	curl_close( $ch );
    
    	return $xml_data;
    }

    public function key_exists($data, $vip_level, $pri_type, $keywords)
    {
    	if (empty($data[$vip_level]))
    	{
    		$data[$vip_level] = array();
    	}

    	if (empty($data[$vip_level][$pri_type]))
    	{
    		$data[$vip_level][$pri_type] = array();
    	}

    	if (empty($data[$vip_level][$pri_type][$keywords]))
    	{
    		$data[$vip_level][$pri_type][$keywords] = array();
    	}

    	if (isset($data[$vip_level]) && isset($data[$vip_level][$pri_type]) && !empty($data[$vip_level][$pri_type][$keywords]))
    	{
    		return true;
    	}
    	return false;
    }

	public function create_rand_str($pw_length =   6)
	{  
		$randpwd = "";  
		for ($i = 0; $i < $pw_length; $i++)  
		{  
			$randpwd .= chr(mt_rand(33, 126));  
		}  
		return $randpwd;  
	}
}