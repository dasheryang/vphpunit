<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

function default_cgi(){
	$c = new Caculator();
	$elem_str = trim( strval( $_GET['estr'] ) );
	$tar_val = intval( $_GET['tar'] ) ;
	
	$elem_set = str_split( $elem_str );
	
	
	$com_result_set = $c->get_result_arr( $elem_set );
// 	var_dump( $com_result_set );
	
	echo get_page_html();
	for( $i = 0; $i < count($com_result_set['value_set']); ++$i){
		
		if( $tar_val == $com_result_set['value_set'][$i] ){
			echo "{$com_result_set['desc_set'][$i]}</br>";
		}
	}
	
	
}

default_cgi();

function get_page_html(){
	$elem_str = empty( $_GET['estr']  ) ? '' : trim( strval( $_GET['estr'] ) );
	$tar_val =  empty( $_GET['tar']  ) ? '' : intval( $_GET['tar'] ) ;
	
	$page_html =<<<EOF
<html>
	<body>
		<form>
			<input name="estr" value="{$elem_str}" /><br/>
			<input name="tar"  value="{$tar_val}" /><br/>
			<input type="button" name="commit" value="caculate"/><br/>
		</form>
	</body>
</html>
<script src=http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js ></script>

<script>
(function(){
	$('[name=commit]').click(function(){
		estr = $('[name=estr]').val();
		tar = $('[name=tar]').val();
		window.location.href = "/d.php?estr=" + estr + "&tar=" + tar;			
	});
})();
</script>
					

EOF;
	
	return $page_html;
}



class Caculator {
	public function get_caculation(){

		$target_set = array( 2,4,4,5,6 );
		
		sort( $target_set );
		
		$res = $this->get_result_arr( $target_set );
		for( $i = 0; $i < count($res['value_set']); ++$i){
// 			var_dump( "{$res['value_set'][$i]} = {$res['desc_set'][$i]}" );
		}
		
	}
	
	public $op_result_set = array();
	
	public function get_result_arr( $target_set, $op_result_set = array() ){
		if( 1 == count($target_set) ){
			$result_pack = array(
					'value_set' => $target_set,
					'desc_set' => array( "{$target_set[0]}" ),
			);
			return $result_pack;
		}
		
		$combin_val_set_arr = $this->get_combination( $target_set );
		
		$combin_size = count( $combin_val_set_arr['l_val_arr_set'] );
		
		for( $combin_index = 0; $combin_index < $combin_size; ++$combin_index ){
			$l_val_set = $combin_val_set_arr['l_val_arr_set'][$combin_index];
			$r_val_set = $combin_val_set_arr['r_val_arr_set'][$combin_index];
			
			$tmp_l_set = array();
			foreach( $l_val_set as $val ){
				$tmp_l_set[] = $val;
			}
			$l_op_obj = new Caculator(); 
			$l_op_result_pack = $l_op_obj->get_result_arr( $tmp_l_set, $op_result_set );
			$l_op_result_set = $l_op_result_pack['value_set'];
			$l_op_result_desc = $l_op_result_pack['desc_set'];
			
// 			var_dump( "******" . implode('_', $target_set) );
			$tmp_r_set = array();
			foreach( $r_val_set as $val ){
				$tmp_r_set[] = $val;
			}
			$r_op_obj = new Caculator();
			$r_op_result_pack = $r_op_obj->get_result_arr( $tmp_r_set, $op_result_set );
			$r_op_result_set = $r_op_result_pack['value_set'];
			$r_op_result_desc = $r_op_result_pack['desc_set'];
			
			$result_op_result_set = array();
			$result_op_result_desc = array();
			foreach( $l_op_result_set as $l_index => $l_op_result ){
				foreach( $r_op_result_set as $r_index => $r_op_result ){
					
					$result_op_result_set[] = $l_op_result + $r_op_result;
					$result_op_result_desc[] = "($l_op_result_desc[$l_index] + $r_op_result_desc[$r_index])";
					
					$result_op_result_set[] = $l_op_result - $r_op_result;
					$result_op_result_desc[] = "($l_op_result_desc[$l_index] - $r_op_result_desc[$r_index])";
					
					$result_op_result_set[] = $r_op_result - $l_op_result;
					$result_op_result_desc[] = "($r_op_result_desc[$r_index] - $l_op_result_desc[$l_index])";
					
					$result_op_result_set[] = $l_op_result * $r_op_result;
					$result_op_result_desc[] = "($l_op_result_desc[$l_index] * $r_op_result_desc[$r_index])";
					
					if( $l_op_result < $r_op_result ){
						$multi = $r_op_result;
						$factor = $l_op_result;
						$desc = "($r_op_result_desc[$r_index] % $l_op_result_desc[$l_index])";
					}else{
						$multi = $l_op_result;
						$factor = $r_op_result;
						$desc = "($l_op_result_desc[$l_index] % $r_op_result_desc[$r_index])";
					}
					
					if( !empty($factor) && 0 == ($multi % $factor) ){
						$result_op_result_set[] = $multi / $factor;
						$result_op_result_desc[] = $desc;
					}
				}
			}
		}
		
			
		$result_pack = array(
				'value_set' => $result_op_result_set,
				'desc_set' => $result_op_result_desc,
		);
		return $result_pack;
	}
	
	public $l_combin_value_arr_set = array();
	public $r_combin_value_arr_set = array();
	
	public function get_combination( $target_set ){
		if( count($target_set) < 2 ){
			return false;
		}
		
		$l_arr_set = array();
		$r_arr_set = array();
		
		$tar_l_count = 1;
		$set_size = count( $target_set );
		
		$target_index_set = array_keys( $target_set );
		
		for( $tar_l_count = 1; $tar_l_count < $set_size; ++$tar_l_count ){
			$combiner = new CombinationGen();
			$combiner->combination( $target_index_set, $tar_l_count );
			
			$l_index_arr_set = $combiner->get_combin_arr_set();
			
			foreach ( $l_index_arr_set as $l_arr ){
				$value_set = $this->get_value_array_with_index($target_set, $l_arr);
				$l_arr_set[] = $value_set;
				
				$r_arr = array_diff( $target_index_set, $l_arr );
				$value_set = $this->get_value_array_with_index($target_set, $r_arr);
				$r_arr_set[] = $value_set;
			}
		}
		
		$result_arr = array(
			'l_val_arr_set' => $l_arr_set,
			'r_val_arr_set' => $r_arr_set,
		);
		return $result_arr;
	}
	
	public function get_value_array_with_index( $value_arr, $index_arr ){
		$result_arr = array();
		foreach( $index_arr as $i ){
			$result_arr[] = $value_arr[$i];
		}
		return $result_arr;
	}
}

class CombinationGen{
	
	public $combin_arr = array();
	
	function combination($arr, $len=0, $str="") {
		$arr_len = count($arr);
		if($len == 0){
			$this->combin_arr[] = $str;
		}else{
			for($i=0; $i<$arr_len-$len+1; $i++){
				$tmp = array_shift($arr);
				$this->combination($arr, $len-1, $str."_".$tmp);
			}
		}
	}
	
	function get_combin_arr_set( ){		
		$target_combin_arr = $this->combin_arr;
		$result_arr_set = array();
		foreach ( $target_combin_arr as $combin_str ){	
			$combin_str = substr( $combin_str, 1 );
			$arr = explode( '_', $combin_str );
			$int_arr = array();

			foreach( $arr as & $v ){
				$v = intval( $v );
			}
			unset( $v );
			$result_arr_set[] = $arr;
		}
		return $result_arr_set;
	}
	
}