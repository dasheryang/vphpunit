<?php
//@dataProvider dataGameTestAbc
//testGameTestAbc
class PUTest extends PHPUnit_Framework_TestCase {
	public function dataGameTestAbc(){
		return array(
				array( '1', '10' ),
				array( '2', '20' ),
				array( '3', '30' ),
		);
	}
	
	/**
	 * @dataProvider dataGameTestAbc
	 */
    public function testGameTestAbc($value, $result ){
        $r = $this->getData( $value );
        //echo $r;
    	$this->assertEquals( $result , $r );
    }

    public function getData($a) {
        return $a*10;
    }

    /**
     * @depends testGameTestAbc
     */
    public function testGame2() {
        $a = 'true';
        $this->assertTrue($a);
    }
}