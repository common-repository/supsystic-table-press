<?php
class optionsControllerTbp extends controllerTbp {
	public function saveGroup() {
		$res = new responseTbp();
		if($this->getModel()->saveGroup(reqTbp::get('post'))) {
			$res->addMessage(__('Done', TBP_LANG_CODE));
		} else
			$res->pushError ($this->getModel('options')->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			TBP_USERLEVELS => array(
				TBP_ADMIN => array('saveGroup')
			),
		);
	}
}

