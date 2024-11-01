<?php
class admin_navControllerTbp extends controllerTbp {
	public function getPermissions() {
		return array(
			TBP_USERLEVELS => array(
				TBP_ADMIN => array()
			),
		);
	}
}