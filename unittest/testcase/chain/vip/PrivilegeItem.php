<?php
/**
 * @target http://test.vip.ids111.com/vip/insert_pri_items
 * 
 * 
 * @author chain
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPrivilegeItem extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		/*
		$pri_pack_value = array(
			array(
				"id" => "TempleRun1_Activation",
				"count" => 10,
				"type" => 1,
			),
			array(
				"id" => "TempleRun1_Activation",
				"count" => 10,
				"type" => 1,
			),
		);
		$pri_pack_value = serialize($pri_pack_value);
		*/
		$global_item_list = PrivilegeConf::$global_item_list;
		
		$post_arr = $global_item_list;
		return array(
			array(
					"cgi" => "http://{$target_domain}/vip/insert_pri_item",
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
		foreach ($post_arrs as $post_arr) {
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

			var_dump( $ret_id );
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