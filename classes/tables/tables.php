<?php
class tableTablesTbp extends tableTbp {
	public function __construct() {
		$this->_table = '@__tables';
		$this->_id = 'id';
		$this->_alias = 'tbp_tables';
		$this->_addField('id', 'text', 'int')
		     ->_addField('title', 'text', 'varchar')
		     ->_addField('meta', 'text', 'text')
		     ->_addField('setting_data', 'text', 'text');
	}
}