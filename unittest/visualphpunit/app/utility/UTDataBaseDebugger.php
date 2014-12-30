<?php

class UTDataBaseDebugger{	
	//标志是否存储调用堆栈
	public $back_trace = false;

	//存储 save 调用堆栈
	private $_arr_save_stack = array();
	
	/**
	 * @param string $data
	 * @param string $validate
	 * @param array $fieldList
	 * 
	 * @author austin
	 * @description 用来替代cakePHP 中的save 方法，存储DB写入数据结果
	 */
	public function save( $data = null, $validate = true, $fieldList = array() ){
		$arr_save_data = array(
			'data' => $data,
			'validate' => $validate,
			'fieldList' => $fieldList,
		);
		$arr_save_record = array(
			'save_data'	=>	$arr_save_data,
		);		
		
		if( $this->back_trace ){
			$arr_call_stack = debug_backtrace();
			$arr_save_record['back_trace'] = $arr_call_stack;
		}

		$this->_arr_save_stack[] = $arr_save_record;
	}
	
	/**
	 * @return array:
	 * 
	 * @author austin
	 * @description 获取DB存储调用数据
	 */
	public function getSaveStack( ){
		return $this->_arr_save_stack;
		
	}
}