<?php
	$title = TBP_WP_PLUGIN_NAME;
?>
<html>
    <head>
        <title><?php _e( $title )?></title>
    </head>
    <body>
<div style="position: fixed; margin-left: 40%; margin-right: auto; text-align: center; background-color: #fdf5ce; padding: 10px; margin-top: 10%;">
    <div><?php _e( $title )?></div>
    <?php echo htmlTbp::formStart('deactivatePlugin', array('action' => $this->REQUEST_URI, 'method' => $this->REQUEST_METHOD))?>
    <?php
        $formData = array();
        switch($this->REQUEST_METHOD) {
            case 'GET':
                $formData = $this->GET;
                break;
            case 'POST':
                $formData = $this->POST;
                break;
        }
        foreach($formData as $key => $val) {
            if(is_array($val)) {
                foreach($val as $subKey => $subVal) {
                    echo htmlTbp::hidden($key. '['. $subKey. ']', array('value' => $subVal));
                }
            } else
                echo htmlTbp::hidden($key, array('value' => $val));
        }
    ?>
        <table width="100%">
            <tr>
                <td><?php _e('Delete Plugin Data (options, setup data, database tables, etc.)', TBP_LANG_CODE)?>:</td>
                <td><?php echo htmlTbp::radiobuttons('deleteOptions', array('options' => array('No', 'Yes')))?></td>
            </tr>
        </table>
    <?php echo htmlTbp::submit('toeGo', array('value' => __('Done', TBP_LANG_CODE)))?>
    <?php echo htmlTbp::formEnd()?>
    </div>
</body>
</html>