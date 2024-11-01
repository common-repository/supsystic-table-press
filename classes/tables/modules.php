<?php
class tableModulesTbp extends tableTbp {
    public function __construct() {
        $this->_table = '@__modules';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'sup_m';
        $this->_addField('label', 'text', 'varchar', 0, __('Label', TBP_LANG_CODE), 128)
                ->_addField('type_id', 'selectbox', 'smallint', 0, __('Type', TBP_LANG_CODE))
                ->_addField('active', 'checkbox', 'tinyint', 0, __('Active', TBP_LANG_CODE))
                ->_addField('params', 'textarea', 'text', 0, __('Params', TBP_LANG_CODE))
                ->_addField('code', 'hidden', 'varchar', '', __('Code', TBP_LANG_CODE), 64)
                ->_addField('ex_plug_dir', 'hidden', 'varchar', '', __('External plugin directory', TBP_LANG_CODE), 255);
    }
}