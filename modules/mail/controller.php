<?php
class mailControllerTbp extends controllerTbp {
	public function testEmail() {
		$res = new responseTbp();
		$email = reqTbp::getVar('test_email', 'post');
		if($this->getModel()->testEmail($email)) {
			$res->addMessage(__('Now check your email inbox / spam folders for test mail.'));
		} else 
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function saveMailTestRes() {
		$res = new responseTbp();
		$result = (int) reqTbp::getVar('result', 'post');
		frameTbp::_()->getModule('options')->getModel()->save('mail_function_work', $result);
		$res->ajaxExec();
	}
	public function saveOptions() {
		$res = new responseTbp();
		$optsModel = frameTbp::_()->getModule('options')->getModel();
		$submitData = reqTbp::get('post');
		if($optsModel->saveGroup($submitData)) {
			$res->addMessage(__('Done', TBP_LANG_CODE));
		} else
			$res->pushError ($optsModel->getErrors());
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			TBP_USERLEVELS => array(
				TBP_ADMIN => array('testEmail', 'saveMailTestRes', 'saveOptions')
			),
		);
	}
}
