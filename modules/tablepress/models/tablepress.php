<?php
class tablepressModel extends modelTbp {
	public function __construct() {
		$this->_setTbl('tables');
	}

	public function save($data = array()){

        $id = isset($data['id']) ? ($data['id']) : '';
        if(!empty($id)) {
            $data['id'] = (string)$id;
            $settingData = array('settings' => $data['settings']);
            $data['setting_data'] = serialize($settingData);
            $statusUpdate = $this->updateById( $data , $id );
            if($statusUpdate){
                return $id;
            }
        } else if( empty($id) ){
            $idInsert = $this->insert( $data );
            if($idInsert){
                if(empty($data['title'])){
                    $data['title'] = (string)$idInsert;
                }
                $data['id'] = (string)$idInsert;
                $settingData = array('settings' => $data['settings']);
                $data['setting_data'] = serialize($settingData);
                $this->updateById( $data , $idInsert );
            }
            return $idInsert;
        } else
            $this->pushError (__('Please enter Name', TBP_LANG_CODE), 'title');
        return false;
    }
}
