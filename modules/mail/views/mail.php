<?php
class mailViewTbp extends viewTbp {
	public function getTabContent() {
		frameTbp::_()->getModule('templates')->loadJqueryUi();
		frameTbp::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		
		$this->assign('options', frameTbp::_()->getModule('options')->getCatOpts( $this->getCode() ));
		$this->assign('testEmail', frameTbp::_()->getModule('options')->get('notify_email'));
		return parent::getContent('mailAdmin');
	}
}
