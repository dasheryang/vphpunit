<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestTCPAttack extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					'cgi' => "",
					'post' => array(
					),
					'',
					'',
			),
		);
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testTCPAttack ( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		error_reporting(E_ALL);
		
		echo "<h2>TCP/IP Connection</h2>\n";
		
		/* Get the port for the WWW service. */
		$service_port = getservbyname('www', 'tcp');
		
		/* Get the IP address for the target host. */
		$address = gethostbyname('test.feed.ids111.com');
		
		/* Create a TCP/IP socket. */
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
		    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
		} else {
		    echo "OK.\n";
		}
		
		echo "Attempting to connect to '$address' on port '$service_port'...";
		$result = socket_connect($socket, $address, $service_port);
		if ($result === false) {
		    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		} else {
		    echo "OK.\n";
		}
		
		$in = "HEAD / HTTP/1.1\r\n";
		$in .= "Host: www.example.com\r\n";
		$in .= "Connection: Close\r\n";
		$out = '';
		
		echo "Sending HTTP HEAD request...";
		socket_write($socket, $in, strlen($in));
		die;
		
		
		
		echo "OK.\n";
		
		echo "Reading response:\n\n";
		while ($out = socket_read($socket, 2048)) {
		    echo $out;
		}
		
		echo "Closing socket...";
		socket_close($socket);
		echo "OK.\n\n";
		
	}
}