<?php
class tablepressTbp extends moduleTbp {
	public function init() {
		dispatcherTbp::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		add_shortcode(TBP_SHORTCODE, array($this, 'render'));
	}
	public function addAdminTab($tabs) {
		$tabs[ $this->getCode(). '_add_new' ] = array(
			'label' => __('Add New Table', TBP_LANG_CODE), 'callback' => array($this, 'getEditTabContent'), 'fa_icon' => 'fa-plus-circle', 'sort_order' => 10, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode(). '_edit' ] = array(
			'label' => __('Edit', TBP_LANG_CODE), 'callback' => array($this, 'getEditTabContent'), 'sort_order' => 20, 'child_of' => $this->getCode(), 'hidden' => 1, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode() ] = array(
			'label' => __('Show All Tables', TBP_LANG_CODE), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-list', 'sort_order' => 20, //'is_main' => true,
		);
		return $tabs;
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
	public function getEditTabContent() {
		$id = reqTbp::getVar('id', 'get');
		return $this->getView()->getEditTabContent( $id );
	}
	public function getEditLink($id, $tableTab = '') {
		$link = frameTbp::_()->getModule('options')->getTabUrl( $this->getCode(). '_edit' );
		$link .= '&id='. $id;
		if(!empty($tableTab)) {
			$link .= '#'. $tableTab;
		}
		return $link;
	}
	public function render($params){
		return $this->getView()->renderHtml($params);
	}

}

