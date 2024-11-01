<?php
class tablepressViewTbp extends viewTbp {
	public function getTabContent() {

		frameTbp::_()->addStyle('admin.tablepress.css', $this->getModule()->getModPath(). 'css/admin.tablepress.css');
		frameTbp::_()->getModule('templates')->loadJqGrid();
		frameTbp::_()->addScript('admin.tablepress.list', $this->getModule()->getModPath(). 'js/admin.tablepress.list.js');
        frameTbp::_()->getModule('templates')->loadFontAwesome();
        frameTbp::_()->addJSVar('admin.tablepress.list', 'tbpTblDataUrl', uriTbp::mod('tablepress', 'getListForTbl', array('reqType' => 'ajax')));
        frameTbp::_()->addJSVar('admin.tablepress.list', 'url', admin_url('admin-ajax.php'));
		frameTbp::_()->getModule('templates')->loadBootstrapSimple();

		$this->assign('addNewLink', frameTbp::_()->getModule('options')->getTabUrl('tablepress_add_new'));

		return parent::getContent('tablepressAdmin');
	}

	public function getEditTabContent($idIn) {
		$idIn = isset($idIn) ? (int) $idIn : 0;
		$table = $this->getModel('tablepress')->getById($idIn);
		$settings = unserialize($table['setting_data']);

        frameTbp::_()->getModule('templates')->loadBootstrapSimple();
        frameTbp::_()->addScript('cdn.data.tables', 'https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js');
        frameTbp::_()->addScript('cdn.data.tables2', 'https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js');
        frameTbp::_()->addScript('cdn.data.tables3', 'https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js');
        frameTbp::_()->addScript('cdn.data.tables4', 'https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js');
        frameTbp::_()->addScript('cdn.data.tables5', 'https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js');
        frameTbp::_()->addScript('cdn.data.tables6', 'https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js');
        frameTbp::_()->addScript('cdn.data.tables7', 'https://cdn.datatables.net/scroller/1.4.4/js/dataTables.scroller.min.js');
        frameTbp::_()->addScript('cdn.data.tables8', 'https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js');
        frameTbp::_()->addStyle('cdn.data.tables', 'https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css');
        frameTbp::_()->addStyle('cdn.data.tables2', 'https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css');
        frameTbp::_()->getModule('templates')->loadJqueryUi();
        frameTbp::_()->addStyle('frontend.tables', $this->getModule()->getModPath(). 'css/frontend.tables.css');
        frameTbp::_()->addScript('core.tables', $this->getModule()->getModPath(). 'js/core.tables.js');
		frameTbp::_()->addScript('admin.tables', $this->getModule()->getModPath(). 'js/tables.admin.js');
		frameTbp::_()->addJSVar('admin.tables', 'url', admin_url('admin-ajax.php'));
		frameTbp::_()->addStyle('admin.tables', $this->getModule()->getModPath(). 'css/admin.tables.css');
        frameTbp::_()->addStyle('loaders.admin.tables', $this->getModule()->getModPath(). 'css/loaders.css');


        $link = frameTbp::_()->getModule('options')->getTabUrl( $this->getCode() );
        $languages = frameTbp::_()->getModule('tablepress')->getModel('languages')->getLanguageBackend();
		$this->assign('languages', $languages);
		$this->assign('link', $link);
		$this->assign('settings', $settings);
		$this->assign('table', $table);

		return parent::getContent('tablepressEditAdmin');
	}

	public function renderHtml($params){

        frameTbp::_()->addScript('cdn.data.tables', 'https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js');
        frameTbp::_()->addScript('cdn.data.tables2', 'https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js');
        frameTbp::_()->addScript('cdn.data.tables3', 'https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js');
        frameTbp::_()->addScript('cdn.data.tables4', 'https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js');
        frameTbp::_()->addScript('cdn.data.tables5', 'https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js');
        frameTbp::_()->addScript('cdn.data.tables6', 'https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js');
        frameTbp::_()->addScript('cdn.data.tables7', 'https://cdn.datatables.net/scroller/1.4.4/js/dataTables.scroller.min.js');
        frameTbp::_()->addScript('cdn.data.tables8', 'https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js');
        frameTbp::_()->addStyle('cdn.data.tables', 'https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css');
        frameTbp::_()->addStyle('cdn.data.tables2', 'https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css');
        frameTbp::_()->addScript('core.tables', $this->getModule()->getModPath(). 'js/core.tables.js');
        frameTbp::_()->addScript('frontend.tables', $this->getModule()->getModPath(). 'js/tables.frontend.js');
        frameTbp::_()->addStyle('frontend.tables', $this->getModule()->getModPath(). 'css/frontend.tables.css');
        frameTbp::_()->addStyle('loaders.frontend.tables', $this->getModule()->getModPath(). 'css/loaders.css');

        $id = isset($params['id']) ? (int) $params['id'] : 0;
		if(!$id){
			return false;
		}

		$html = $this->getPostContentFrontend( $id );
        $table = $this->getModel('tablepress')->getById($id);
        $tableSettings = unserialize($table['setting_data']);
		$viewId = $id . '_' . mt_rand(0, 999999);
		$this->assign('viewId', $viewId);
		$this->assign('html', $html);
		$this->assign('settings', $tableSettings);

		return parent::getContent('tablepressHtml');
	}

    public function loadPost($params){

        if(empty($params['type'])){
            $params['type'] = 'post';
        }
        $dataArr = array();

        switch ($params['type']){
            case 'post':
                $args = array(
                    'posts_per_page' => -1,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'post_type'   => 'post',
                    'suppress_filters' => true,
                    'post_status' => array( 'publish' ),
                );

                $data = new WP_Query( $args );
                $data = $data->posts;

                foreach ( $data as $post ) {
                    $authorName = get_the_author_meta('display_name', $post->post_author);
                    $dataArr[] = array('id' => $post->ID, 'post_title' => $post->post_title, 'author_name' => $authorName);
                }
                break;
            case 'category':
                $args = array(
                    'taxonomy' => 'category',
                    'hide_empty' => true
                );

                $data = get_terms($args);

                foreach ( $data as $term ) {
                    $dataArr[] = array('term_id' => $term->term_id, 'name' => $term->name);
                }
                break;
            case 'tags':
                $args = array(
                    'taxonomy' => 'post_tag',
                    'hide_empty' => true
                );

                $data = get_terms($args);

                foreach ( $data as $term ) {
                    $dataArr[] = array('term_id' => $term->term_id, 'name' => $term->name);
                }
                break;
            case 'authors':
                $data = get_users();

                foreach ( $data as $user ) {
                    $dataArr[] = array('id' => $user->ID, 'name' => $user->display_name);
                }
                break;
        };

        $html = $this->generateTableHtml($dataArr);

        return $html;
    }



    public function getPostContent($params, $preview = false){
        $dataArr = array();
        if(!empty($params['tableid']) || !empty($params['postIdExist']) ){
            if(!empty($params['postIdExist'])){
                $postIdsExits = $params['postIdExist'];
                $postIdsExits = explode(",", $postIdsExits);
            }

            // if we have table id get settings from db
            if(!empty($params['tableid'])){
                $table = $this->getModel('tablepress')->getById($params['tableid']);
                $tableSettings = unserialize($table['setting_data']);

                $dateFormat = !empty($tableSettings['settings']['date_formats']) ? $tableSettings['settings']['date_formats'] : false;
                $timeFormat = !empty($tableSettings['settings']['time_formats']) ? $tableSettings['settings']['time_formats'] : false;
                $dateAndTimeFormat = false;
                if($timeFormat && $dateFormat){
                    $dateAndTimeFormat = $dateFormat . ' ' . $timeFormat;
                }else if($dateFormat){
                    $dateAndTimeFormat = $dateFormat;
                }else if($timeFormat){
                    $dateAndTimeFormat = $timeFormat;
                }

            }

            if(!empty($postIdsExits) && !is_array($postIdsExits)){
                $postIdsExits = array($postIdsExits);
            }

            if($postIdsExits){
                $args = array(
                    'post__in' => $postIdsExits,
                    'post_type' => 'post',
                    'ignore_sticky_posts' => true,
                    'post_status' => array( 'publish' ),
                    'posts_per_page' => -1
                );
                $dataExist = new WP_Query( $args );
                $postExist = $dataExist->posts;

                foreach ( $postExist as $post ) {
                    $authorName = get_the_author_meta('display_name', $post->post_author);
                    $categories = get_the_term_list( $post->ID, 'category', '', ', ', '' );
                    $postImg = get_the_post_thumbnail( $post->ID, 'thumbnail' );

                    $tagsArray = get_the_tags( $post->ID );
                    $tags = '';

                    if($tagsArray){
                        $countTags = count($tagsArray);
                        $i = 1;
                        foreach($tagsArray as $tag){
                            $tagLink = get_tag_link($tag->term_id);
                            if($countTags === $i){
                                $tags .= '<a href="'.$tagLink.'">'.$tag->name.'</a>';
                            }else{
                                $tags .= '<a href="'.$tagLink.'">'.$tag->name.'</a>, ';
                            }
                            $i++;
                        }
                    }
                    if(!$preview){
						$postContent = mb_strimwidth($post->post_content, 0, 100, "...");
                    }else{
                        $postContent = $post->post_content;
                    }

                    $dataArr[] = array(
                        'id' => $post->ID,
                        'post_title' => $post->post_title,
                        'author_name' => $authorName,
                        'post_date' => $post->post_date,
                        'post_content' => $postContent,
                        'categories' => $categories,
                        'tags' => $tags,
                        'post_img'=>$postImg
                    );
                }
            }

        }

        if(empty($params['type'])){
            $params['type'] = 'post';
        }
        if(empty($params['elementsid'])){
            $params['elementsid'] = '';
        }
        if(empty($params['order'])){
            $params['order'] = '';
        }

        switch ($params['type']){
            case 'post':
                $args = array(
                    'post__in' => $params['elementsid'],
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'ignore_sticky_posts' => true,
                    'post_status' => array( 'publish' ),
                );
                break;
            case 'category':
                $args = array(
                    'cat' => $params['elementsid'],
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'ignore_sticky_posts' => true,
                    'post_status' => array( 'publish' ),
                );
                break;
            case 'tags':
                $args = array(
                    'tag__in' => $params['elementsid'],
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'ignore_sticky_posts' => true,
                    'post_status' => array( 'publish' ),
                );
                break;
            case 'authors':
                $args = array(
                    'author__in' => $params['elementsid'],
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'ignore_sticky_posts' => true,
                    'post_status' => array( 'publish' ),
                );
                break;
        };

        if($params['elementsid']){
            $data = new WP_Query( $args );
            $data = $data->posts;


            foreach ( $data as $post ) {
                $authorName = get_the_author_meta('display_name', $post->post_author);
                $categories = get_the_term_list( $post->ID, 'category', '', ', ', '' );
                $postImg = get_the_post_thumbnail( $post->ID, 'thumbnail' );
                $tagsArray = get_the_tags( $post->ID );
                $tags = '';

                if($tagsArray){
                    $countTags = count($tagsArray);
                    $i = 1;
                    foreach($tagsArray as $tag){
                        $tagLink = get_tag_link($tag->term_id);
                        if($countTags === $i){
                            $tags .= '<a href="'.$tagLink.'">'.$tag->name.'</a>';
                        }else{
                            $tags .= '<a href="'.$tagLink.'">'.$tag->name.'</a>, ';
                        }
                        $i++;
                    }
                }
                if(!$preview){
					$postContent = mb_strimwidth($post->post_content, 0, 100, "...");
                }else{
                    $postContent = $post->post_content;
                }
                $dataArr[] = array(
                    'id' => $post->ID,
                    'post_title' => $post->post_title,
                    'author_name' => $authorName,
                    'post_date' => $post->post_date,
                    'post_content' => $postContent,
                    'categories' => $categories,
                    'tags' => $tags,
                    'post_img'=>$postImg
                );
            }
        }

        $dataArr = $this->uniqueMultidimArray($dataArr, 'id');
        $postIdsReturn = '';

        $count = count($dataArr);
        $i = 1;
        foreach ($dataArr as $data){
            if($count === $i){
                $postIdsReturn .= $data['id'];
            }else{
                $postIdsReturn .= $data['id'] . ',';
            }
            $i++;
        }

        $html = $this->generateTableHtml($dataArr, $params['order'], $preview, $dateAndTimeFormat);

        $return = array();
        $return['html'] = $html;
        $return['ids'] = $postIdsReturn;

        return $return;
    }

    public function getPostContentFrontend($id){
        $dataArr = array();
        if(!empty($id)){
            $table = $this->getModel('tablepress')->getById($id);
            $tableSettings = unserialize($table['setting_data']);
            $postIdsExits = $tableSettings['settings']['postids'];
            $orders = explode(",",  $tableSettings['settings']['order']);
            $dateFormat = !empty($tableSettings['settings']['date_formats']) ? $tableSettings['settings']['date_formats'] : false;
            $timeFormat = !empty($tableSettings['settings']['time_formats']) ? $tableSettings['settings']['time_formats'] : false;
            $dateAndTimeFormat = false;
            if($timeFormat && $dateFormat){
                $dateAndTimeFormat = $dateFormat . ' ' . $timeFormat;
            }else if($dateFormat){
                $dateAndTimeFormat = $dateFormat;
            }else if($timeFormat){
                $dateAndTimeFormat = $timeFormat;
            }

            $postIdsExits = explode(",", $postIdsExits);
            if(!empty($postIdsExits) && !is_array($postIdsExits)){
                $postIdsExits = array($postIdsExits);
            }

            if($postIdsExits ){
                $args = array(
                    'post__in' => $postIdsExits,
                    'post_type' => 'post',
                    'ignore_sticky_posts' => true,
                    'post_status' => array( 'publish' ),
                    'posts_per_page' => -1
                );
                $dataExist = new WP_Query( $args );
                $postExist = $dataExist->posts;

                foreach ( $postExist as $post ) {
                    $authorName = get_the_author_meta('display_name', $post->post_author);
                    $categories = get_the_term_list( $post->ID, 'category', '', ', ', '' );
                    $postImg = get_the_post_thumbnail( $post->ID, 'thumbnail' );

                    $tagsArray = get_the_tags( $post->ID );
                    $tags = '';

                    if($tagsArray){
                        $countTags = count($tagsArray);
                        $i = 1;
                        foreach($tagsArray as $tag){
                            $tagLink = get_tag_link($tag->term_id);
                            if($countTags === $i){
                                $tags .= '<a href="'.$tagLink.'">'.$tag->name.'</a>';
                            }else{
                                $tags .= '<a href="'.$tagLink.'">'.$tag->name.'</a>, ';
                            }
                            $i++;
                        }
                    }
                    $dataArr[] = array(
                        'id' => $post->ID,
                        'post_title' => $post->post_title,
                        'author_name' => $authorName,
                        'post_date' => $post->post_date,
                        'post_content' => $post->post_content,
                        'categories' => $categories,
                        'tags' => $tags,
                        'post_img'=>$postImg
                    );
                }
            }

            $dataArr = $this->uniqueMultidimArray($dataArr, 'id');
            $html = $this->generateTableHtml($dataArr, $orders, true, $dateAndTimeFormat);

            return $html;
        }
    }

    public function uniqueMultidimArray($array, $key) {

        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function replaceSlugToNiceName($slug){
        $nameArray = array(
            'post_title' => __('Title', TBP_LANG_CODE),
            'author_name' => __('Authors', TBP_LANG_CODE),
            'post_date' => __('Created', TBP_LANG_CODE),
            'post_content' => __('Content', TBP_LANG_CODE),
            'categories' => __('Categories', TBP_LANG_CODE),
            'tags' => __('Tags', TBP_LANG_CODE),
            'post_img' => __('Img', TBP_LANG_CODE),
        );
        if (array_key_exists($slug, $nameArray)) {
            return $nameArray[$slug];
        }else{
            return $slug;
        }
    }

    //Generate table html from post array
    public function generateTableHtml($listPost, $orders = false, $preview = false, $dateAndTimeFormat = false){

        if(!empty($orders) && $orders[0] !== ''){
            array_unshift($orders, "id");

            $sortedPostList = array();

            foreach ($orders as $order) {
                foreach ($listPost as $key=>$post) {
                    if (array_key_exists($order, $post)) {
                        $sortedPostList[$key][$order] = $post[$order];
                    }
                }
            }

            $listPost = $sortedPostList;
        }

        $listPost = array_values($listPost);

        if($preview){
            $tableHeader = '<thead><tr>';
            $tableBody = '<tbody>';
            $tableFooter = '<tfoot><tr>';
        }else{
            $tableHeader = '<thead><tr><th class="no-sort"><input class="tbpCheckAll" type="checkbox"/></th>';
            $tableBody = '<tbody>';
            $tableFooter = '<tfoot><tr><th class="no-sort"><input class="tbpCheckAll" type="checkbox"/></th>';
        }

        //reorder multy array $listpost like $order array says
        for($i = 0; $i<count($listPost); $i++){

            $k = 1;
            if($i === 0){
                foreach ($listPost[$i] as $key=>$post){
                    if($k !== 1){
                        $tableHeader .=  '<th data-key="'.$key.'">'.$this->replaceSlugToNiceName($key).'</th>';
                        $tableFooter .=  '<th data-key="'.$key.'">'.$this->replaceSlugToNiceName($key).'</th>';
                    }
                    $k++;
                }
                $countKeys = count($listPost[$i]);

            }

            $j = 1;
            foreach ($listPost[$i] as $key=>$post){
                if($j === 1){
                    if($preview){
                        $tableBody .=  '<tr>';
                    }else{
                        $tableBody .=  '<tr><td><input type="checkbox" data-id="'.$post.'"></td>';
                    }
                }else{
                    if($key === 'post_date' && $dateAndTimeFormat){

                        $date = $post;
                        $dateTimestamp = strtotime($date);
                        $outputDate = date($dateAndTimeFormat, $dateTimestamp);

                        $tableBody .=  '<td>'.$outputDate.'</td>';
                    }else{
                        $tableBody .=  '<td>'.$post.'</td>';
                    }

                }
                if($j === $countKeys){
                    $tableBody .=  '</tr>';
                }
                $j++;
            }
        }


        $tableHeader .= '</tr></thead>';
        $tableBody .= '</tbody>';
        $tableFooter .= '</tr></tfoot>';

        $table = $tableHeader . $tableFooter . $tableBody;

        return $table;
    }

	public function showEditTablepressFormControls() {
		parent::display('tablepressEditFormControls');
	}

}
