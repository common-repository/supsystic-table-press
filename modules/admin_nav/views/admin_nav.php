<?php
class admin_navViewTbp extends viewTbp {
	public function getBreadcrumbs() {
		$this->assign('breadcrumbsList', dispatcherTbp::applyFilters('mainBreadcrumbs', $this->getModule()->getBreadcrumbsList()));
		return parent::getContent('adminNavBreadcrumbs');
	}
}
