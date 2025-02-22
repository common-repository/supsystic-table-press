<?php
class recapchaTbp {
	private $_publicKey = '6LfUotgSAAAAAL4pqsHxE8sx6Cz8o7AEc_JjtROD';
	private $_privateKey = '6LfUotgSAAAAACFAM1TMpIsLiQsfDmV-mRNfQg1n';
	
	public function __construct() {
		if(!function_exists('recaptcha_get_html')) {	// In case if this lib was already included by another plugin
			importTbp(TBP_HELPERS_DIR. 'recaptchalib.php');
		}
	}
	static public function getInstance() {
		static $instance = NULL;
		if(empty($instance)) {
			$instance = new recapchaTbp();
		}
		return $instance;
	}
	static public function _() {
		return self::getInstance();
	}
	public function getHtml() {
		if(reqTbp::getVar('reqType') == 'ajax') {
			$divId = 'toeRecapcha'. mt_rand(1, 9999);
			return '<div id="'. $divId. '"></div>'.
				'<script type="text/javascript">
				// <!--
				Recaptcha.create("'. $this->_publicKey. '",
					"'. $divId. '",
					{
					  theme: "red",
					  callback: Recaptcha.focus_response_field
					}
				  );
				// -->
				</script>';
		} else {
			return recaptcha_get_html($this->_publicKey, null, true);
		}
	}
	public function check() {
		$resp = recaptcha_check_answer($this->_privateKey, 
					$_SERVER['REMOTE_ADDR'], 
					reqTbp::getVar('recaptcha_challenge_field'),
					reqTbp::getVar('recaptcha_response_field'));
		return $resp->is_valid;
	}
}