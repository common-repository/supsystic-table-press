<?php
class pagesViewTbp extends viewTbp {
    public function displayDeactivatePage() {
        $this->assign('GET', reqTbp::get('get'));
        $this->assign('POST', reqTbp::get('post'));
        $this->assign('REQUEST_METHOD', strtoupper(reqTbp::getVar('REQUEST_METHOD', 'server')));
        $this->assign('REQUEST_URI', basename(reqTbp::getVar('REQUEST_URI', 'server')));
        parent::display('deactivatePage');
    }
}

