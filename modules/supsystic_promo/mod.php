<?php
class supsystic_promoTbp extends moduleTbp {
	private $_mainLink = '';
	private $_minDataInStatToSend = 20;	// At least 20 points in table shuld be present before send stats
	private $_assetsUrl = '';
	public function __construct($d) {
		parent::__construct($d);
		$this->getMainLink();
		dispatcherTbp::addFilter('jsInitVariables', array($this, 'addMainOpts'));
	}
	public function init() {
		parent::init();
		add_action('admin_footer', array($this, 'displayAdminFooter'), 9);
		if(is_admin()) {
			add_action('init', array($this, 'checkWelcome'));
			add_action('init', array($this, 'checkStatisticStatus'));
			add_action('admin_footer', array($this, 'checkPluginDeactivation'));
		}
		$this->weLoveYou();
		dispatcherTbp::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		dispatcherTbp::addFilter('subDestList', array($this, 'addSubDestList'));
		dispatcherTbp::addAction('beforeSaveOpts', array($this, 'checkSaveOpts'));
		dispatcherTbp::addFilter('showTplsList', array($this, 'checkProTpls'));
		add_action('admin_notices', array($this, 'checkAdminPromoNotices'));
		// Admin tutorial
		add_action('admin_enqueue_scripts', array( $this, 'loadTutorial'));
	}
	public function checkAdminPromoNotices() {
		if(!frameTbp::_()->isAdminPlugOptsPage())	// Our notices - only for our plugin pages for now
			return;
		$notices = array();
		// Start usage
		$startUsage = (int) frameTbp::_()->getModule('options')->get('start_usage');
		$currTime = time();
		$day = 24 * 3600;
		if($startUsage) {	// Already saved
			$rateMsg = sprintf(__("<h3>Hey, I noticed you just use %s over a week – that’s awesome!</h3><p>Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.</p>", TBP_LANG_CODE), TBP_WP_PLUGIN_NAME);
			$rateMsg .= '<p><a href="https://wordpress.org/support/view/plugin-reviews/popup-by-supsystic?rate=5#postform" target="_blank" class="button button-primary" data-statistic-code="done">'. __('Ok, you deserve it', TBP_LANG_CODE). '</a>
			<a href="#" class="button" data-statistic-code="later">'. __('Nope, maybe later', TBP_LANG_CODE). '</a>
			<a href="#" class="button" data-statistic-code="hide">'. __('I already did', TBP_LANG_CODE). '</a></p>';
			$enbPromoLinkMsg = sprintf(__("<h3>More then eleven days with our %s plugin - Congratulations!</h3>", TBP_LANG_CODE), TBP_WP_PLUGIN_NAME);
			$enbPromoLinkMsg .= __('<p>On behalf of the entire <a href="https://pareslider.com/" target="_blank">pareslider.com</a> company I would like to thank you for been with us, and I really hope that our software helped you.</p>', TBP_LANG_CODE);
			$enbPromoLinkMsg .= __('<p>And today, if you want, - you can help us. This is really simple - you can just add small promo link to our site under your PopUps. This is small step for you, but a big help for us! Sure, if you don\'t want - just skip this and continue enjoy our software!</p>', TBP_LANG_CODE);
			$enbPromoLinkMsg .= '<p><a href="#" class="button button-primary" data-statistic-code="done">'. __('Ok, you deserve it', TBP_LANG_CODE). '</a>
			<a href="#" class="button" data-statistic-code="later">'. __('Nope, maybe later', TBP_LANG_CODE). '</a>
			<a href="#" class="button" data-statistic-code="hide">'. __('Skip', TBP_LANG_CODE). '</a></p>';
			$enbStatsMsg = '<p>'
			               . sprintf(__('You can help us improve our plugin - by <a href="%s" data-statistic-code="hide" class="button button-primary tbpEnbStatsAdBtn">enabling Usage Statisttbp</a>. We will collect only our plugin usage statisttbp data - to understand Your needs and make our solution better for You.', TBP_LANG_CODE), frameTbp::_()->getModule('options')->getTabUrl('settings'))
			               . '</p>';
			$checkOtherPlugins = '<p>'
			                     . sprintf(__('Check out <a href="%s" target="_blank" class="button button-primary" data-statistic-code="hide">our other Plugins</a>! Years of experience in WordPress plugins developers made those list unbreakable!', TBP_LANG_CODE), frameTbp::_()->getModule('options')->getTabUrl('featured-plugins'))
			                     . '</p>';
			$notices = array(
				'rate_msg' => array('html' => $rateMsg, 'show_after' => 7 * $day),
				'enb_promo_link_msg' => array('html' => $enbPromoLinkMsg, 'show_after' => 11 * $day),
				'enb_stats_msg' => array('html' => $enbStatsMsg, 'show_after' => 5 * $day),
				'check_other_plugs_msg' => array('html' => $checkOtherPlugins, 'show_after' => 1 * $day),
			);
			foreach($notices as $nKey => $n) {
				if($currTime - $startUsage <= $n['show_after']) {
					unset($notices[ $nKey ]);
					continue;
				}
				$done = (int) frameTbp::_()->getModule('options')->get('done_'. $nKey);
				if($done) {
					unset($notices[ $nKey ]);
					continue;
				}
				$hide = (int) frameTbp::_()->getModule('options')->get('hide_'. $nKey);
				if($hide) {
					unset($notices[ $nKey ]);
					continue;
				}
				$later = (int) frameTbp::_()->getModule('options')->get('later_'. $nKey);
				if($later && ($currTime - $later) <= 2 * $day) {	// remember each 2 days
					unset($notices[ $nKey ]);
					continue;
				}
				if($nKey == 'enb_promo_link_msg' && (int)frameTbp::_()->getModule('options')->get('add_love_link')) {
					unset($notices[ $nKey ]);
					continue;
				}
			}
		} else {
			frameTbp::_()->getModule('options')->getModel()->save('start_usage', $currTime);
		}
		if(!empty($notices)) {
			if(isset($notices['rate_msg']) && isset($notices['enb_promo_link_msg']) && !empty($notices['enb_promo_link_msg'])) {
				unset($notices['rate_msg']);	// Show only one from those messages
			}
			$html = '';
			foreach($notices as $nKey => $n) {
				$this->getModel()->saveUsageStat($nKey. '.'. 'show', true);
				$html .= '<div class="updated notice is-dismissible supsystic-admin-notice" data-code="'. $nKey. '">'. $n['html']. '</div>';
			}
			echo $html;
		}
	}
	public function addAdminTab($tabs) {
//		$tabs['overview'] = array(
//			'label' => __('Overview', TBP_LANG_CODE), 'callback' => array($this, 'getOverviewTabContent'), 'fa_icon' => 'fa-info', 'sort_order' => 5,
//		);
//		$tabs['featured-plugins'] = array(
//			'label' => __('Featured Plugins', TBP_LANG_CODE), 'callback' => array($this, 'showFeaturedPluginsPage'), 'fa_icon' => 'fa-heart', 'sort_order' => 99,
//		);
		return $tabs;
	}
	public function addSubDestList($subDestList) {
		if(!$this->isPro()) {
			$subDestList = array_merge($subDestList, array(
				'constantcontact' => array('label' => __('Constant Contact - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'campaignmonitor' => array('label' => __('Campaign Monitor - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'verticalresponse' => array('label' => __('Vertical Response - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'sendgrid' => array('label' => __('SendGrid - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'get_response' => array('label' => __('GetResponse - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'icontact' => array('label' => __('iContact - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'activecampaign' => array('label' => __('Active Campaign - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'mailrelay' => array('label' => __('Mailrelay - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'arpreach' => array('label' => __('arpReach - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'sgautorepondeur' => array('label' => __('SG Autorepondeur - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'benchmarkemail' => array('label' => __('Benchmark - PRO', TBP_LANG_CODE), 'require_confirm' => true),
				'infusionsoft' => array('label' => __('InfusionSoft - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'salesforce' => array('label' => __('SalesForce - Web-to-Lead - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'convertkit' => array('label' => __('ConvertKit - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'myemma' => array('label' => __('Emma - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'sendinblue' => array('label' => __('SendinBlue - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'vision6' => array('label' => __('Vision6 - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'vtiger' => array('label' => __('Vtiger - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'ymlp' => array('label' => __('Your Mailing List Provider (Ymlp) - PRO', TBP_LANG_CODE), 'require_confirm' => false),
				'fourdem' => array('label' => __('4Dem.it - PRO', TBP_LANG_CODE), 'require_confirm' => false),
			));
		}
		return $subDestList;
	}
	public function getOverviewTabContent() {
		return $this->getView()->getOverviewTabContent();
	}
	public function showWelcomePage() {
		$this->getView()->showWelcomePage();
	}
	public function displayAdminFooter() {
		if(frameTbp::_()->isAdminPlugPage()) {
			$this->getView()->displayAdminFooter();
		}
	}
	private function _preparePromoLink($link, $ref = '') {
		if(empty($ref))
			$ref = 'user';
		return $link;
	}
	public function weLoveYou() {
		if(!$this->isPro()) {
			dispatcherTbp::addFilter('popupEditTabs', array($this, 'addUserExp'), 10, 2);
			dispatcherTbp::addFilter('popupEditDesignTabs', array($this, 'addUserExpDesign'));
			dispatcherTbp::addFilter('editPopupMainOptsShowOn', array($this, 'showAdditionalmainAdminShowOnOptions'));
		}
	}
	public function showAdditionalmainAdminShowOnOptions($popup) {
		$this->getView()->showAdditionalmainAdminShowOnOptions($popup);
	}
	public function addUserExp($tabs, $popup) {
		$modPath = '';
		$tabs['tbpPopupAbTesting'] = array(
			'title' => __('Testing', TBP_LANG_CODE),
			'content' => '<a href="'. $this->generateMainLink('utm_source=plugin&utm_medium=abtesting&utm_campaign=popup'). '" target="_blank" class="button button-primary">'
	             . __('Get PRO', TBP_LANG_CODE). '</a><br /><a href="'. $this->generateMainLink('utm_source=plugin&utm_medium=abtesting&utm_campaign=popup'). '" target="_blank">'
	             . '<img style="max-width: 100%;" src="'. $modPath. 'img/AB-testing-pro.jpg" />'
	             . '</a>',
			'icon_content' => '<b>A/B</b>',
			'avoid_hide_icon' => true,
			'sort_order' => 55,
		);
		if(!in_array($popup['type'], array(TBP_FB_LIKE, TBP_IFRAME, TBP_SIMPLE_HTML, TBP_PDF, TBP_AGE_VERIFY, TBP_FULL_SCREEN))) {
			$tabs['tbpLoginRegister'] = array(
				'title' => __('Login/Registration', TBP_LANG_CODE),
				'content' => '<a href="'. $this->generateMainLink('utm_source=plugin&utm_medium=login_registration&utm_campaign=popup'). '" target="_blank" class="button button-primary">'
		             . __('Get PRO', TBP_LANG_CODE). '</a><br /><a href="'. $this->generateMainLink('utm_source=plugin&utm_medium=login_registration&utm_campaign=popup'). '" target="_blank">'
		             . '<img style="max-width: 100%;" src="'. $modPath. 'img/login-registration-1.jpg" />'
		             . '</a>',
				'fa_icon' => 'fa-sign-in',
				'sort_order' => 25,
			);
		}
		return $tabs;
	}
	public function addUserExpDesign($tabs) {
		$tabs['tbpPopupLayeredPopup'] = array(
			'title' => __('Popup Location', TBP_LANG_CODE),
			'content' => $this->getView()->getLayeredStylePromo(),
			'fa_icon' => 'fa-arrows',
			'sort_order' => 15,
		);
		return $tabs;
	}
	/**
	 * Public shell for private method
	 */
	public function preparePromoLink($link, $ref = '') {
		return $this->_preparePromoLink($link, $ref);
	}
	public function checkStatisticStatus(){
		// Not used for now - using big data methods
		/*$canSend = (int) frameTbp::_()->getModule('options')->get('send_stats');
		if($canSend && frameTbp::_()->getModule('user')->isAdmin()) {
			// Before this version we had many wrong data collected taht we don't need at all. Let's clear them.
			if(TBP_VERSION == '1.3.5') {
				$clearedTrashStatData = (int) get_option(TBP_DB_PREF. 'cleared_trash_stat_data');
				if(!$clearedTrashStatData) {
					$this->getModel()->clearUsageStat();
					update_option(TBP_DB_PREF. 'cleared_trash_stat_data', 1);
					return;	// We just cleared whole data - so don't need to even check send stats
				}
			}
			$this->getModel()->checkAndSend();
		}*/
	}
	public function getMinStatSend() {
		return $this->_minDataInStatToSend;
	}
	public function getMainLink() {
		if(empty($this->_mainLink)) {
			$affiliateQueryString = '';
			$this->_mainLink = 'https://pareslider.com/plugins/popup-plugin/' . $affiliateQueryString;
		}
		return $this->_mainLink ;
	}
	public function generateMainLink($params = '') {
		$mainLink = $this->getMainLink();
		if(!empty($params)) {
			return $mainLink. (strpos($mainLink , '?') ? '&' : '?'). $params;
		}
		return $mainLink;
	}
	public function getContactFormFields() {
		$fields = array(
			'name' => array('label' => __('Name', TBP_LANG_CODE), 'valid' => 'notEmpty', 'html' => 'text'),
			'email' => array('label' => __('Email', TBP_LANG_CODE), 'html' => 'email', 'valid' => array('notEmpty', 'email'), 'placeholder' => 'example@mail.com', 'def' => get_bloginfo('admin_email')),
			'website' => array('label' => __('Website', TBP_LANG_CODE), 'html' => 'text', 'placeholder' => 'http://example.com', 'def' => get_bloginfo('url')),
			'subject' => array('label' => __('Subject', TBP_LANG_CODE), 'valid' => 'notEmpty', 'html' => 'text'),
			'category' => array('label' => __('Topic', TBP_LANG_CODE), 'valid' => 'notEmpty', 'html' => 'selectbox', 'options' => array(
				'plugins_options' => __('Plugin options', TBP_LANG_CODE),
				'bug' => __('Report a bug', TBP_LANG_CODE),
				'functionality_request' => __('Require a new functionality', TBP_LANG_CODE),
				'other' => __('Other', TBP_LANG_CODE),
			)),
			'message' => array('label' => __('Message', TBP_LANG_CODE), 'valid' => 'notEmpty', 'html' => 'textarea', 'placeholder' => __('Hello Supsystic Team!', TBP_LANG_CODE)),
		);
		foreach($fields as $k => $v) {
			if(isset($fields[ $k ]['valid']) && !is_array($fields[ $k ]['valid']))
				$fields[ $k ]['valid'] = array( $fields[ $k ]['valid'] );
		}
		return $fields;
	}
	public function isPro() {
		static $isPro;
		if(is_null($isPro)) {
			// license is always active with PRO - even if license key was not entered,
			// add_options module was from the begining of the times in PRO, and will be active only once user will activate license on site
			$isPro = frameTbp::_()->getModule('license') && frameTbp::_()->getModule('on_exit');
		}
		return $isPro;
	}
//	public function getAssetsUrl() {
//		if(empty($this->_assetsUrl)) {
//			$this->_assetsUrl = frameTbp::_()->getModule('comparison')->getAssetsUrl(). 'promo/';
//		}
//		return $this->_assetsUrl;
//	}
	public function checkWelcome() {
		$from = reqTbp::getVar('from', 'get');
		$pl = reqTbp::getVar('pl', 'get');
		if($from == 'welcome-page' && $pl == TBP_CODE && frameTbp::_()->getModule('user')->isAdmin()) {
			$welcomeSent = (int) get_option(TBP_DB_PREF. 'welcome_sent');
			if(!$welcomeSent) {
				$this->getModel()->welcomePageSaveInfo();
				update_option(TBP_DB_PREF. 'welcome_sent', 1);
			}
			$skipTutorial = (int) reqTbp::getVar('skip_tutorial', 'get');
			if($skipTutorial) {
				$tourHst = $this->getModel()->getTourHst();
				$tourHst['closed'] = 1;
				$this->getModel()->setTourHst( $tourHst );
			}
		}
	}
	public function getContactLink() {
		return $this->getMainLink(). '#contact';
	}
	public function addMainOpts($opts) {
		$title = 'WordPress PopUp Plugin';
		$opts['options']['love_link_html'] = '<a title="'. $title. '" style="color: #26bfc1 !important; font-size: 9px; position: absolute; bottom: 15px; right: 15px;" href="'. $this->generateMainLink('utm_source=plugin&utm_medium=love_link&utm_campaign=popup'). '" target="_blank">'
             . $title
             . '</a>';
		return $opts;
	}
	public function checkSaveOpts($newValues) {
		$loveLinkEnb = (int) frameTbp::_()->getModule('options')->get('add_love_link');
		$loveLinkEnbNew = isset($newValues['opt_values']['add_love_link']) ? (int) $newValues['opt_values']['add_love_link'] : 0;
		if($loveLinkEnb != $loveLinkEnbNew) {
			$this->getModel()->saveUsageStat('love_link.'. ($loveLinkEnbNew ? 'enb' : 'dslb'));
		}
	}
	public function checkProTpls($list) {
		if(!$this->isPro()) {
			//$imgsPath = frameTbp::_()->getModule('comparison')->getAssetsUrl(). 'img/preview/';
			$imgsPath = '';
			$promoList = array(
				array('label' => 'List Building Layered', 'img_preview' => 'list-building-layered.jpg', 'sort_order' => 18, 'type_id' => 10),
				array('label' => 'Full Screen Transparent', 'img_preview' => 'full-screen-transparent.jpg', 'sort_order' => 20, 'type_id' => 8),
				array('label' => 'Age Verification', 'img_preview' => 'age-verification.jpg', 'sort_order' => 10, 'type_id' => 7),
				array('label' => 'WordPress Login', 'img_preview' => 'wordpress-login.jpg', 'sort_order' => 15, 'type_id' => 9),
				array('label' => 'Bump!', 'img_preview' => 'bump.jpg', 'sort_order' => 16, 'type_id' => 10),
				array('label' => 'Subscribe Me Bar', 'img_preview' => 'subscribe-me-bar.jpg', 'sort_order' => 17, 'type_id' => 10),
				array('label' => 'Black Friday', 'img_preview' => 'black-friday.jpg', 'sort_order' => 16, 'type_id' => 10),
				array('label' => 'Pyramid', 'img_preview' => 'pyramid.jpg', 'sort_order' => 19, 'type_id' => 10),
				array('label' => 'Catch Eye', 'img_preview' => 'catch-eye.jpg', 'sort_order' => 17, 'type_id' => 10),
				array('label' => 'Logout Reminder', 'img_preview' => 'wordpress-logout.jpg', 'sort_order' => 16, 'type_id' => 9),
				array('label' => 'Ho Ho Holiday Sale', 'img_preview' => 'HoHoHolidaySale.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Exclusive Christmas', 'img_preview' => 'ExclusiveChristmasBg2.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Christmas-4', 'img_preview' => 'christmas-4-prev.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Holiday Discount', 'img_preview' => '358-prev-holiday-discount.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Winter Sale', 'img_preview' => '365-5-winter-sale-prev.png', 'sort_order' => 0, 'type_id' => 7),
				array('label' => 'Christmas Tree', 'img_preview' => '365-6-img-prev.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Christmas Candies', 'img_preview' => '361-christmas-candies-prev.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Xmas Discount', 'img_preview' => '373-xmas-discount-prev.png', 'sort_order' => 0, 'type_id' => 11),
				array('label' => 'Exclusive Subscription', 'img_preview' => '230-7-exclusive-subscr-preview.png', 'sort_order' => 1, 'type_id' => 1),
				array('label' => 'Pretty', 'img_preview' => '2016-8-Pretty-prev.png', 'sort_order' => 1, 'type_id' => 1),
				array('label' => 'Get Discount', 'img_preview' => '2016-9-get-discount-prev.png', 'sort_order' => 1, 'type_id' => 1),
				array('label' => 'Winter Subscribe', 'img_preview' => '2016-10-winter-subscr-prev.png', 'sort_order' => 1, 'type_id' => 1),
				array('label' => 'Lavender Mood', 'img_preview' => '2016-11-lavender-mood-prev.png', 'sort_order' => 1, 'type_id' => 1),
			);
			foreach($promoList as $i => $t) {
				$promoList[ $i ]['img_preview_url'] = $imgsPath. $promoList[ $i ]['img_preview'];
				$promoList[ $i ]['promo'] = strtolower(str_replace(array(' ', '!'), '', $t['label']));
				$promoList[ $i ]['promo_link'] = $this->generateMainLink('utm_source=plugin&utm_medium='. $promoList[ $i ]['promo']. '&utm_campaign=popup');
			}
			foreach($list as $i => $t) {
				if(isset($t['id']) && $t['id'] >= 50) {
					unset($list[ $i ]);
				}
			}
			$list = array_merge($list, $promoList);
		}
		return $list;
	}
	public function loadTutorial() {
		// Don't run on WP < 3.3
		if ( get_bloginfo( 'version' ) < '3.3' )
			return;

		if ( is_admin() && current_user_can(frameTbp::_()->getModule('adminmenu')->getMainCap()) ) {

			$this->checkToShowTutorial();
		}
	}
	public function checkToShowTutorial() {
		if(reqTbp::getVar('tour', 'get') == 'clear-hst') {
			$this->getModel()->clearTourHst();
		}
		$hst = $this->getModel()->getTourHst();
		if((isset($hst['closed']) && $hst['closed'])
		   || (isset($hst['finished']) && $hst['finished'])
		) {
			return;
		}
		$tourData = array();
		$tourData['tour'] = array(
			'welcome' => array(
				'points' => array(
					'first_welcome' => array(
						'target' => '#toplevel_page_popup-wp-supsystic',
						'options' => array(
							'position' => array(
								'edge' => 'bottom',
								'align' => 'top',
							),
						),
						'show' => 'not_plugin',
					),
				),
			),
			'create_first' => array(
				'points' => array(
					'create_bar_btn' => array(
						'target' => '.supsystic-content .supsystic-navigation .supsystic-tab-popup_add_new',
						'options' => array(
							'position' => array(
								'edge' => 'left',
								'align' => 'right',
							),
						),
						'show' => array('tab_popup', 'tab_settings', 'tab_overview'),
					),
					'enter_title' => array(
						'target' => '#tbpCreatePopupForm input[type=text]',
						'options' => array(
							'position' => array(
								'edge' => 'top',
								'align' => 'bottom',
							),
						),
						'show' => 'tab_popup_add_new',
					),
					'select_tpl' => array(
						'target' => '.popup-list',
						'options' => array(
							'position' => array(
								'edge' => 'bottom',
								'align' => 'top',
							),
						),
						'show' => 'tab_popup_add_new',
					),
					'save_first_popup' => array(
						'target' => '#tbpCreatePopupForm .button-primary',
						'options' => array(
							'position' => array(
								'edge' => 'left',
								'align' => 'right',
							),
						),
						'show' => 'tab_popup_add_new',
					),
				),
			),
			'first_edit' => array(
				'points' => array(
					'popup_main_opts' => array(
						'target' => '#tbpPopupEditForm',
						'options' => array(
							'position' => array(
								'edge' => 'right',
								'align' => 'left',
							),
							'pointerWidth' => 200,
						),
						'show' => 'tab_popup_edit',
					),
					'popup_design_opts' => array(
						'target' => '#tbpPopupEditForm',
						'options' => array(
							'position' => array(
								'edge' => 'right',
								'align' => 'top',
							),
							'pointerWidth' => 200,
						),
						'show' => 'tab_popup_edit',
						'sub_tab' => '#tbpPopupTpl',
					),
					'popup_subscribe_opts' => array(
						'target' => '#tbpPopupEditForm',
						'options' => array(
							'position' => array(
								'edge' => 'right',
								'align' => 'top',
							),
							'pointerWidth' => 200,
						),
						'show' => 'tab_popup_edit',
						'sub_tab' => '#tbpPopupSubscribe',
					),
					'popup_statisttbp_opts' => array(
						'target' => '#tbpPopupEditForm',
						'options' => array(
							'position' => array(
								'edge' => 'right',
								'align' => 'left',
							),
							'pointerWidth' => 200,
						),
						'show' => 'tab_popup_edit',
						'sub_tab' => '#tbpPopupStatisttbp',
					),
					'popup_code_opts' => array(
						'target' => '#tbpPopupEditForm',
						'options' => array(
							'position' => array(
								'edge' => 'right',
								'align' => 'left',
							),
							'pointerWidth' => 200,
						),
						'show' => 'tab_popup_edit',
						'sub_tab' => '#tbpPopupEditors',
					),
					'final' => array(
						'target' => '#tbpPopupMainControllsShell .tbpPopupSaveBtn',
						'options' => array(
							'position' => array(
								'edge' => 'top',
								'align' => 'bottom',
							),
							'pointerWidth' => 500,
						),
						'show' => 'tab_popup_edit',
					),
				),
			),
		);
		$isAdminPage = frameTbp::_()->isAdminPlugOptsPage();
		$activeTab = frameTbp::_()->getModule('options')->getActiveTab();
		foreach($tourData['tour'] as $stepId => $step) {
			foreach($step['points'] as $pointId => $point) {
				$pointKey = $stepId. '-'. $pointId;
				if(isset($hst['passed'][ $pointKey ]) && $hst['passed'][ $pointKey ]) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				$show = isset($point['show']) ? $point['show'] : 'plugin';
				if(!is_array($show))
					$show = array( $show );
				if((in_array('plugin', $show) && !$isAdminPage) || (in_array('not_plugin', $show) && $isAdminPage)) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				$showForTabs = false;
				$hideForTabs = false;
				foreach($show as $s) {
					if(strpos($s, 'tab_') === 0) {
						$showForTabs = true;
					}
					if(strpos($s, 'tab_not_') === 0) {
						$showForTabs = true;
					}
				}
				if($showForTabs && (!in_array('tab_'. $activeTab, $show) || !$isAdminPage)) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				if($hideForTabs && (in_array('tab_not_'. $activeTab, $show) || !$isAdminPage)) {
					unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
					continue;
				}
				switch($pointKey) {
					case 'create_first-create_bar_btn':
						// Pointer for Create new POpUp we can show only if there are no created PopUps
						$createdPopupsNum = frameTbp::_()->getModule('comparison')->getModel()->getCount();
						if(!empty($createdPopupsNum)) {
							unset($tourData['tour'][ $stepId ]['points'][ $pointId ]);
							continue;
						}
				}
			}
		}
		foreach($tourData['tour'] as $stepId => $step) {
			if(!isset($step['points']) || empty($step['points'])) {
				unset($tourData['tour'][ $stepId ]);
			}
		}
		if(empty($tourData['tour']))
			return;
		$tourData['html'] = $this->getView()->getTourHtml();
		frameTbp::_()->getModule('templates')->loadCoreJs();
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'wp-pointer' );
		frameTbp::_()->addScript(TBP_CODE. 'admin.tour', $this->getModPath(). 'js/admin.tour.js');
		frameTbp::_()->addJSVar(TBP_CODE. 'admin.tour', 'tbpAdminTourData', $tourData);
	}
	public function getContactFormPlgUrl() {
		return 'http://wordpress.org/support/plugin/contact-form-by-supsystic';
	}
	public function showFeaturedPluginsPage() {
		return $this->getView()->showFeaturedPluginsPage();
	}
	public function checkPluginDeactivation() {
		if(function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if($screen && isset($screen->base) && $screen->base == 'plugins') {
				frameTbp::_()->getModule('templates')->loadCoreJs();
				frameTbp::_()->getModule('templates')->loadCoreCss();
				frameTbp::_()->getModule('templates')->loadJqueryUi();
				frameTbp::_()->addScript('jquery-ui-dialog');
				frameTbp::_()->addScript(TBP_CODE. '.admin.plugins', $this->getModPath(). 'js/admin.plugins.js');
				frameTbp::_()->addJSVar(TBP_CODE. '.admin.plugins', 'tbpPluginsData', array(
					'plugSlug' => TBP_PLUG_NAME,
				));
				echo $this->getView()->getPluginDeactivation();
			}
		}
	}
	public function connectItemEditStats() {
		frameTbp::_()->addScript(TBP_CODE. '.admin.item.edit.stats', $this->getModPath(). 'js/admin.item.edit.stats.js');
	}
}