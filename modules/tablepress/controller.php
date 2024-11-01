<?php
class tablepressControllerTbp extends controllerTbp {

    protected $_code = 'tablepress';

	protected function _prepareTextLikeSearch($val) {
		$query = '(title LIKE "%'. $val. '%"';
		if(is_numeric($val)) {
			$query .= ' OR id LIKE "%'. (int) $val. '%"';
		}
		$query .= ')';
		return $query;
	}

	/*
	public function updateSettingFromTpl() {

		$res = new responseTbp();

		if(($id = $this->getModel()->updateSettingFromTpl(reqTbp::get('post'))) != false) {
			$res->addMessage(__('Done', TBP_LANG_CODE));
			$res->addData('edit_link', $this->getModule()->getEditLink( $id ));
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	*/
	public function _prepareListForTbl($data){
		foreach($data as $key=>$row){
			$id = $row['id'];
			$shortcode = "[".TBP_SHORTCODE." id=".$id."]";
			$showPrewiewButton = "<button data-id='".$id."' data-shortcode='".$shortcode."' class='button button-primary button-prewiew' style='margin-top: 1px;'>".__('Prewiew', TBP_LANG_CODE)."</button>";
			$titleUrl = "<a href=".$this->getModule()->getEditLink( $id ).">".$row['title']." <i class='fa fa-fw fa-pencil'></i></a>";
			$data[$key]['shortcode'] = $shortcode;
			$data[$key]['rewiew'] = $showPrewiewButton;
			$data[$key]['title'] = $titleUrl;
		}
		return $data;
	}
	public function loadPreview(){
		$res = new responseTbp();
		$params = reqTbp::get('post');
		if(isset($params['id'])){
			$slider = $this->getView()->renderHtml($params);
			echo $slider;
		}else{
			$res->pushError ($this->getModel()->getErrors());
		}
		exit();
	}

	public function loadPost(){
		$res = new responseTbp();
		$params = reqTbp::get('post');

        $html = $this->getView()->loadPost($params);

		if($html){
			$res->addMessage(__('Done', TBP_LANG_CODE));
			$res->setHtml($html);
		}else{
			$res->addMessage(__('Post not exist!', TBP_LANG_CODE));
		}
		return $res->ajaxExec();
	}

    public function getPostContent(){
        $res = new responseTbp();
        $params = reqTbp::get('post');
        $frontend = !empty($params['frontend']) ? true : false;
        $prewiew = !empty($params['prewiew']) ? true : false;

        $htmlAndIds = $this->getView()->getPostContent($params, $frontend);

        if(!empty($htmlAndIds)){
            $res->addMessage(__('Done', TBP_LANG_CODE));
            $res->setHtml($htmlAndIds['html']);
            $res->addData(array('ids' => $htmlAndIds['ids']));
            if($prewiew){
                $id = !empty($params['tableid']) ? $params['tableid'] : '';
                $table = $this->getModel('tablepress')->getById($id);
                $tableSettings = unserialize($table['setting_data']);
                $res->addData(array('settings' => $tableSettings));
            }
        }else{
            $res->addMessage(__('Post not exist!', TBP_LANG_CODE));
        }
        return $res->ajaxExec();
    }

    public function save(){
        $res = new responseTbp();
        if(($id = $this->getModel('tablepress')->save(reqTbp::get('post'))) != false) {
            $res->addMessage(__('Done', TBP_LANG_CODE));
            $res->addData('edit_link', $this->getModule()->getEditLink( $id ));
        } else
            $res->pushError ($this->getModel('tablepress')->getErrors());
        return $res->ajaxExec();
    }

    public function deleteByID(){
        $res = new responseTbp();

        if($this->getModel('tablepress')->delete(reqTbp::get('post')) != false){
            $res->addMessage(__('Done', TBP_LANG_CODE));
        }else{
            $res->pushError ($this->getModel('tablepress')->getErrors());
        }
        return $res->ajaxExec();
    }

    /*
    public function showColumns(){
        $res = new responseTbp();

        $columnsNames = array(
            'post_title' => __('Title', TBP_LANG_CODE),
            'author_name' => __('Authors', TBP_LANG_CODE),
            'post_date' => __('Created', TBP_LANG_CODE),
            'post_content' => __('Content', TBP_LANG_CODE),
            'categories' => __('Categories', TBP_LANG_CODE),
            'tags' => __('Tags', TBP_LANG_CODE),
            'post_img' => __('Img', TBP_LANG_CODE),
        );

        $res->addMessage(__('Done', TBP_LANG_CODE));
        $res->addData('columns', $columnsNames);

        return $res->ajaxExec();
    }
    */

}

