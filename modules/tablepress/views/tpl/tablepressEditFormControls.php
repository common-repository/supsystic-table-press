<div class="supsystic-bar" style="display: inline-block;">
    <div id="tbpComparisonTitleLabel" style="display: inline;">
        <?php echo htmlTbp::text('title', array(
            'value' => (isset($this->slider['title']) ? $this->slider['title'] : ''),
            'attrs' => 'style="float: left; width:200px;"',
            'required' => true,
        ))?>
    </div>
    <button class="button button-primary tbpComparisonSaveBtn" style="margin-left: 10px;">
        <i class="fa fa-check"></i>
        <?php _e('Save', TBP_LANG_CODE)?>
    </button>
</div>

