<?php
class FtpTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		return array(
			array(
				'host'	=> '192.168.0.29',
				'port'	=> '22',
				'timeout'	=> 3,
			),
		);
	}
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $host
	 * @param unknown_type $port
	 * @param unknown_type $timeout
	 */
	function testFtp( $host, $port, $timeout ) {
		$conn = ftp_connect($host, $port, $timeout ) ;

		var_dump( $conn ) ;
		
	}
}