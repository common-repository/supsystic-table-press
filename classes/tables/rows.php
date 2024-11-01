<?php
class tableRowsTbp extends tableTbp {
	public function __construct() {
		$this->_table = '@__rows';
		$this->_id = 'id';
		$this->_alias = 'tbp_rows';
		$this->_addField('id', 'text', 'int')
		     ->_addField('table_id', 'text', 'int')
		     ->_addField('data', 'text', 'text');
	}
}