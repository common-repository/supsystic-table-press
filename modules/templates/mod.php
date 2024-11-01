<?php
class templatesTbp extends moduleTbp {
    protected $_styles = array();
	private $_cdnUrl = '';
	
	public function __construct($d) {
		parent::__construct($d);
		$this->getCdnUrl();	// Init CDN URL
	}
	public function getCdnUrl() {
		if(empty($this->_cdnUrl)) {
			if((int) frameTbp::_()->getModule('options')->get('use_local_cdn')) {
				$uploadsDir = wp_upload_dir( null, false );
				$this->_cdnUrl = $uploadsDir['baseurl']. '/'. TBP_CODE. '/';
				if(uriTbp::isHttps()) {
					$this->_cdnUrl = str_replace('http://', 'https://', $this->_cdnUrl);
				}
				dispatcherTbp::addFilter('externalCdnUrl', array($this, 'modifyExternalToLocalCdn'));
			} else {
				$this->_cdnUrl = (uriTbp::isHttps() ? 'https' : 'http'). '://supsystic-42d7.kxcdn.com/';
			}
		}
		return $this->_cdnUrl;
	}
	public function modifyExternalToLocalCdn( $url ) {
		$url = str_replace(
			array('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css'), 
			array($this->_cdnUrl. 'lib/font-awesome'), 
			$url);
		return $url;
	}
    public function init() {
        if (is_admin()) {
			if($isAdminPlugOptsPage = frameTbp::_()->isAdminPlugOptsPage()) {
				$this->loadCoreJs();
				$this->loadAdminCoreJs();
				$this->loadCoreCss();
				$this->loadChosenSelects();
				frameTbp::_()->addScript('adminOptionsTbp', TBP_JS_PATH. 'admin.options.js', array(), false, true);
				add_action('admin_enqueue_scripts', array($this, 'loadMediaScripts'));
				add_action('init', array($this, 'connectAdditionalAdminAssets'));
			}
			// Some common styles - that need to be on all admin pages - be careful with them
			frameTbp::_()->addStyle('supsystic-for-all-admin-'. TBP_CODE, TBP_CSS_PATH. 'supsystic-for-all-admin.css');
		}
        parent::init();
    }
	public function connectAdditionalAdminAssets() {
		if(is_rtl()) {
			frameTbp::_()->addStyle('styleTbp-rtl', TBP_CSS_PATH. 'style-rtl.css');
		}
	}
	public function loadMediaScripts() {
		if(function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
		}
	}
	public function loadAdminCoreJs() {
		frameTbp::_()->addScript('jquery-ui-dialog');
		frameTbp::_()->addScript('jquery-ui-slider');
		frameTbp::_()->addScript('wp-color-picker');
		frameTbp::_()->addScript('icheck', TBP_JS_PATH. 'icheck.min.js');
		$this->loadTooltipster();
	}
	public function loadCoreJs() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addScript('jquery');

			frameTbp::_()->addScript('commonTbp', TBP_JS_PATH. 'common.js');
			frameTbp::_()->addScript('coreTbp', TBP_JS_PATH. 'core.js');

			$ajaxurl = admin_url('admin-ajax.php');
			$jsData = array(
				'siteUrl'					=> TBP_SITE_URL,
				'imgPath'					=> TBP_IMG_PATH,
				'cssPath'					=> TBP_CSS_PATH,
				'loader'					=> TBP_LOADER_IMG, 
				'close'						=> TBP_IMG_PATH. 'cross.gif', 
				'ajaxurl'					=> $ajaxurl,
				'options'					=> frameTbp::_()->getModule('options')->getAllowedPublicOptions(),
				'TBP_CODE'					=> TBP_CODE,
				//'ball_loader'				=> TBP_IMG_PATH. 'ajax-loader-ball.gif',
				//'ok_icon'					=> TBP_IMG_PATH. 'ok-icon.png',
				'jsPath'					=> TBP_JS_PATH,
			);
			if(is_admin()) {
				$jsData['isPro'] = frameTbp::_()->getModule('supsystic_promo')->isPro();
				$jsData['mainLink'] = frameTbp::_()->getModule('supsystic_promo')->getMainLink();
			}
			$jsData = dispatcherTbp::applyFilters('jsInitVariables', $jsData);
			frameTbp::_()->addJSVar('coreTbp', 'TBP_DATA', $jsData);
			$loaded = true;
		}
	}
	public function loadTooltipster() {
		frameTbp::_()->addScript('tooltipster', $this->_cdnUrl. 'lib/tooltipster/jquery.tooltipster.min.js');
		frameTbp::_()->addStyle('tooltipster', $this->_cdnUrl. 'lib/tooltipster/tooltipster.css');
	}
	public function loadSlimscroll() {
		frameTbp::_()->addScript('jquery.slimscroll', $this->_cdnUrl. 'js/jquery.slimscroll.js');
	}
	public function loadCodemirror() {
		frameTbp::_()->addStyle('tbpCodemirror', $this->_cdnUrl. 'lib/codemirror/codemirror.css');
		frameTbp::_()->addStyle('codemirror-addon-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/show-hint.css');
		frameTbp::_()->addScript('tbpCodemirror', $this->_cdnUrl. 'lib/codemirror/codemirror.js');
		frameTbp::_()->addScript('codemirror-addon-show-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/show-hint.js');
		frameTbp::_()->addScript('codemirror-addon-xml-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/xml-hint.js');
		frameTbp::_()->addScript('codemirror-addon-html-hint', $this->_cdnUrl. 'lib/codemirror/addon/hint/html-hint.js');
		frameTbp::_()->addScript('codemirror-mode-xml', $this->_cdnUrl. 'lib/codemirror/mode/xml/xml.js');
		frameTbp::_()->addScript('codemirror-mode-javascript', $this->_cdnUrl. 'lib/codemirror/mode/javascript/javascript.js');
		frameTbp::_()->addScript('codemirror-mode-css', $this->_cdnUrl. 'lib/codemirror/mode/css/css.js');
		frameTbp::_()->addScript('codemirror-mode-htmlmixed', $this->_cdnUrl. 'lib/codemirror/mode/htmlmixed/htmlmixed.js');
	}
	public function loadCoreCss() {
		$this->_styles = array(
			'styleTbp'			=> array('path' => TBP_CSS_PATH. 'style.css', 'for' => 'admin'), 
			'supsystic-uiTbp'	=> array('path' => TBP_CSS_PATH. 'supsystic-ui.css', 'for' => 'admin'), 
			'dashicons'			=> array('for' => 'admin'),
			'bootstrap-alerts'	=> array('path' => TBP_CSS_PATH. 'bootstrap-alerts.css', 'for' => 'admin'),
			'icheck'			=> array('path' => TBP_CSS_PATH. 'jquery.icheck.css', 'for' => 'admin'),
			//'uniform'			=> array('path' => TBP_CSS_PATH. 'uniform.default.css', 'for' => 'admin'),
			'wp-color-picker'	=> array('for' => 'admin'),
		);
		foreach($this->_styles as $s => $sInfo) {
			if(!empty($sInfo['path'])) {
				frameTbp::_()->addStyle($s, $sInfo['path']);
			} else {
				frameTbp::_()->addStyle($s);
			}
		}
		$this->loadFontAwesome();
	}
	public function loadJqueryUi() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addStyle('jquery-ui', TBP_CSS_PATH. 'jquery-ui.min.css');
			frameTbp::_()->addStyle('jquery-ui.structure', TBP_CSS_PATH. 'jquery-ui.structure.min.css');
			frameTbp::_()->addStyle('jquery-ui.theme', TBP_CSS_PATH. 'jquery-ui.theme.min.css');
			frameTbp::_()->addStyle('jquery-slider', TBP_CSS_PATH. 'jquery-slider.css');
			$loaded = true;
		}
	}
	public function loadJqGrid() {
		static $loaded = false;
		if(!$loaded) {
			$this->loadJqueryUi();
			frameTbp::_()->addScript('jq-grid', $this->_cdnUrl. 'lib/jqgrid/jquery.jqGrid.min.js');
			frameTbp::_()->addStyle('jq-grid', $this->_cdnUrl. 'lib/jqgrid/ui.jqgrid.css');
			$langToLoad = utilsTbp::getLangCode2Letter();
			$availableLocales = array('ar','bg','bg1251','cat','cn','cs','da','de','dk','el','en','es','fa','fi','fr','gl','he','hr','hr1250','hu','id','is','it','ja','kr','lt','mne','nl','no','pl','pt','pt','ro','ru','sk','sr','sr','sv','th','tr','tw','ua','vi');
			if(!in_array($langToLoad, $availableLocales)) {
				$langToLoad = 'en';
			}
			frameTbp::_()->addScript('jq-grid-lang', $this->_cdnUrl. 'lib/jqgrid/i18n/grid.locale-'. $langToLoad. '.js');
			$loaded = true;
		}
	}
	public function loadFontAwesome() {
		frameTbp::_()->addStyle('font-awesomeTbp', dispatcherTbp::applyFilters('externalCdnUrl', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'));
	}
	public function loadChosenSelects() {
		frameTbp::_()->addStyle('jquery.chosen', $this->_cdnUrl. 'lib/chosen/chosen.min.css');
		frameTbp::_()->addScript('jquery.chosen', $this->_cdnUrl. 'lib/chosen/chosen.jquery.min.js');
	}
	public function loadDatePicker() {
		frameTbp::_()->addScript('jquery-ui-datepicker');
	}
	public function loadJqplot() {
		static $loaded = false;
		if(!$loaded) {
			$jqplotDir = $this->_cdnUrl. 'lib/jqplot/';

			frameTbp::_()->addStyle('jquery.jqplot', $jqplotDir. 'jquery.jqplot.min.css');

			frameTbp::_()->addScript('jplot', $jqplotDir. 'jquery.jqplot.min.js');
			frameTbp::_()->addScript('jqplot.canvasAxisLabelRenderer', $jqplotDir. 'jqplot.canvasAxisLabelRenderer.min.js');
			frameTbp::_()->addScript('jqplot.canvasTextRenderer', $jqplotDir. 'jqplot.canvasTextRenderer.min.js');
			frameTbp::_()->addScript('jqplot.dateAxisRenderer', $jqplotDir. 'jqplot.dateAxisRenderer.min.js');
			frameTbp::_()->addScript('jqplot.canvasAxisTickRenderer', $jqplotDir. 'jqplot.canvasAxisTickRenderer.min.js');
			frameTbp::_()->addScript('jqplot.highlighter', $jqplotDir. 'jqplot.highlighter.min.js');
			frameTbp::_()->addScript('jqplot.cursor', $jqplotDir. 'jqplot.cursor.min.js');
			frameTbp::_()->addScript('jqplot.barRenderer', $jqplotDir. 'jqplot.barRenderer.min.js');
			frameTbp::_()->addScript('jqplot.categoryAxisRenderer', $jqplotDir. 'jqplot.categoryAxisRenderer.min.js');
			frameTbp::_()->addScript('jqplot.pointLabels', $jqplotDir. 'jqplot.pointLabels.min.js');
			frameTbp::_()->addScript('jqplot.pieRenderer', $jqplotDir. 'jqplot.pieRenderer.min.js');
			$loaded = true;
		}
	}
	public function loadSortable() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addScript('jquery-ui-core');
			frameTbp::_()->addScript('jquery-ui-widget');
			frameTbp::_()->addScript('jquery-ui-mouse');

			frameTbp::_()->addScript('jquery-ui-draggable');
			frameTbp::_()->addScript('jquery-ui-sortable');
			$loaded = true;
		}
	}
	public function loadMagicAnims() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addStyle('magic.anim', $this->_cdnUrl. 'css/magic.min.css');
			$loaded = true;
		}
	}
	public function loadCssAnims() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addStyle('animate.styles', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.min.css');
			$loaded = true;
		}
	}
	public function loadBootstrapSimple() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addStyle('bootstrap-simple', TBP_CSS_PATH. 'bootstrap-simple.css');
			$loaded = true;
		}
	}
	public function loadGoogleFont( $font ) {
		static $loaded = array();
		if(!isset($loaded[ $font ])) {
			frameTbp::_()->addStyle('google.font.'. str_replace(array(' '), '-', $font), 'https://fonts.googleapis.com/css?family='. urlencode($font));
			$loaded[ $font ] = 1;
		}
	}
	public function loadBxSlider() {
		static $loaded = false;
		if(!$loaded) {
			frameTbp::_()->addStyle('bx-slider', TBP_JS_PATH. 'bx-slider/jquery.bxslider.css');
			frameTbp::_()->addScript('bx-slider', TBP_JS_PATH. 'bx-slider/jquery.bxslider.min.js');
			$loaded = true;
		}
	}
}
