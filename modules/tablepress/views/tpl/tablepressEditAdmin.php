<?php
$isPro = true;
if ( ! $isPro ) {
	$tbpDisabled = 'tbpDisabled';
} else {
	$tbpDisabled = '';
}

$columnsNames = array(
    'post_title' => __('Title', TBP_LANG_CODE),
    'author_name' => __('Authors', TBP_LANG_CODE),
    'post_date' => __('Created', TBP_LANG_CODE),
    'post_content' => __('Content', TBP_LANG_CODE),
    'categories' => __('Categories', TBP_LANG_CODE),
    'tags' => __('Tags', TBP_LANG_CODE),
    'post_img' => __('Img', TBP_LANG_CODE),
);

$columnsNamesStr = '';
$i = 1;
$countColumnsNames = count($columnsNames);

foreach ($columnsNames as $key => $value){
    if($i === $countColumnsNames ){
        $columnsNamesStr .= $key;
    }else{
        $columnsNamesStr .= $key . ',';
    }
    $i++;
}

?>

<div id="tbpTablePressEditTabs">
	<section>
		<div class="supsystic-item supsystic-panel" style="padding-left: 10px;">
			<div id="containerWrapper">
				<form id="tbpTablePressEditForm" data-table-id="<?php echo $this->table['id']; ?>" data-href="<?php echo $this->link;?>">

					<div class="row">
						<div class="tbpCopyTextCodeSelectionShell col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-md-3 col-sm-5 col-xs-10">
									<select name="shortcode_example" id="tbpCopyTextCodeExamples">
										<option value="shortcode"><?php echo __('Table Shortcode', TBP_LANG_CODE); ?></option>
										<option value="phpcode"><?php echo __('Table PHP code', TBP_LANG_CODE); ?></option>
									</select>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2 tbpTooltipInfo">
									<i class="fa fa-question supsystic-tooltip" style="margin-left: 12px;" title="<?php echo esc_html(__('Table PHP code: lets display the table through themes/plugins files (for example in the site footer). You can use shortcode in this way. ', TBP_LANG_CODE))?>"></i>
								</div>
                                <?php $id = isset($this->table['id']) ? $this->table['id'] : ''; ?>
                                <?php if($id) {?>
								<div class="col-md-8 col-sm-6 col-xs-10 tbpCopyTextCodeShowBlock tbpShortcode shortcode" style="">
									<?php
										echo htmlTbp::text('shortcode', array(
												'value' => "[".TBP_SHORTCODE." id=$id]",
												'attrs' => 'readonly style="width: 100%" onclick="this.setSelectionRange(0, this.value.length);" class=""',
												'required' => true,
											));
									?>
								</div>
								<div class="col-md-8 col-sm-6 col-xs-10 tbpCopyTextCodeShowBlock tbpShortcode phpcode" style="display: none;">
									<?php
										echo htmlTbp::text('shortcode', array(
											'value' => "<?php echo do_shortcode('[".TBP_SHORTCODE." id=$id]') ?>",
											'attrs' => 'readonly style="width: 100%" onclick="this.setSelectionRange(0, this.value.length);" class=""',
											'required' => true,
										));
									?>
								</div>
                                <?php } else { ?>
                                    <div class="col-md-8 col-sm-6 col-xs-10" style="line-height: 30px;">
                                        <?php echo __('Will be created after first save', TBP_LANG_CODE); ?>
                                    </div>
                                <?php } ?>
								<div class="clear"></div>
							</div>
						</div>
						<div class="tbpMainBtnsShell col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<ul class="tbpSub control-buttons">
								<li>
									<button id="buttonSave" class="button">
										<i class="fa fa-floppy-o" aria-hidden="true"></i><span><?php echo __('Save', TBP_LANG_CODE); ?></span>
									</button>
								</li>
								<li>
									<button id="buttonDelete" class="button">
										<i class="fa fa-trash-o" aria-hidden="true"></i><span><?php echo __('Delete', TBP_LANG_CODE); ?></span>
									</button>
								</li>
							</ul>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<ul class="tbpSub tabs-wrapper tbpMainTabs">
								<li>
									<span id="tbpTableTitleShell" title="<?php echo esc_html(__('Click to edit', TBP_LANG_CODE))?>">
                                        <?php $title = isset($this->table['title']) ? $this->table['title'] : '';?>
										<span id="tbpTableTitleLabel"><?php echo $title; ?></span>
                                        <?php echo htmlTbp::text('title', array(
											'value' => $title,
											'attrs' => 'style="display:none;" id="tbpTableTitleTxt"',
											'required' => true,
										)); ?>
										<i class="fa fa-fw fa-pencil"></i>
									</span>
								</li>
								<li>
									<a href="#row-tab-settings" class="current button"><i class="fa fa-fw fa-wrench"></i><?php echo __('Settings', TBP_LANG_CODE); ?></a>
								</li>
								<li>
									<a href="#row-tab-content" class="button tbpContentTab"><i class="fa fa-fw fa-th"></i><?php echo __('Content', TBP_LANG_CODE); ?></a>
								</li>
								<li>
									<a href="#row-tab-preview" class="button tbpPreviewShow"><i class="fa fa-fw fa-eye"></i><?php echo __('Preview', TBP_LANG_CODE); ?></a>
								</li>
							</ul>
							<span id="tbpTableTitleEditMsg"></span>
						</div>
					</div>

					<div class="row row-tab active" id="row-tab-settings">
						<div class="col-xs-12">
                            <nav class="tabs-settings">
                                <ul class="tbpSub tabs-wrapper">
                                    <li>
                                        <a href="#row-tab-settings-main" class="current button"><i class="fa fa-fw fa-tachometer"></i><?php echo __('Main', TBP_LANG_CODE); ?></a>
                                    </li>
                                    <li>
                                        <a href="#row-tab-settings-features" class="button"><i class="fa fa-fw fa-cogs"></i><?php echo __('Features', TBP_LANG_CODE); ?></a>
                                    </li>
                                    <li>
                                        <a href="#row-tab-settings-design" class="button"><i class="fa fa-fw fa-picture-o"></i><?php echo __('Appearance', TBP_LANG_CODE); ?></a>
                                    </li>
                                    <li>
                                        <a href="#row-tab-settings-text" class="button"><i class="fa fa-fw fa-language"></i><?php echo __('Language and Text', TBP_LANG_CODE); ?></a>
                                    </li>
                                </ul>
                            </nav>
                            <section class="row-settings-tabs col-xs-12">
                                <section class="row row-settings-tab active" id="row-tab-settings-main">
                                    <table class="form-settings-table">
                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <th class="col-md-12"><?php echo __('Table Elements', TBP_LANG_CODE)?></th>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Caption', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Check here if you want to show the name of the table above the table.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[caption_enable]', array(
                                                        'checked' => (isset($this->settings['settings']['caption_enable']) ? (int) $this->settings['settings']['caption_enable'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <?php
                                                if(isset($this->settings['settings']['caption_enable'])
                                                    && (int) $this->settings['settings']['caption_enable'] == 1){
                                                    $tbpCaptionText = '';
                                                }else{
                                                    $tbpCaptionText = 'tbpHidden';
                                                }
                                            ?>
                                            <tr class="col-md-12 <?php echo $tbpCaptionText?>" id="tbpCaptionText">
                                                <td class="col-md-5">
                                                    <?php _e('Caption Text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-7">
                                                    <?php echo htmlTbp::textarea('settings[caption_text]', array(
                                                        'value' => (isset($this->settings['settings']['caption_text']) ? $this->settings['settings']['caption_text'] : ''),
                                                        'attrs' => 'style="width:100%"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Description', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('You can add short decsription to the table between title and table.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[description_enable]', array(
                                                        'checked' => (isset($this->settings['settings']['description_enable']) ? (int) $this->settings['settings']['description_enable'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <?php
                                            if(isset($this->settings['settings']['description_enable'])
                                                && (int) $this->settings['settings']['description_enable'] == 1){
                                                $tbpDescriptionText = '';
                                            }else{
                                                $tbpDescriptionText = 'tbpHidden';
                                            }
                                            ?>
                                            <tr class="col-md-12 <?php echo $tbpDescriptionText?>" id="tbpDescriptionText">
                                                <td class="col-md-5">
                                                    <?php _e('Description Text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-7">
                                                    <?php echo htmlTbp::textarea('settings[description_text]', array(
                                                        'value' => (isset($this->settings['settings']['description_text']) ? $this->settings['settings']['description_text'] : ''),
                                                        'attrs' => 'style="width:100%"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Signature', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('You can add signature under table footer.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[signature_enable]', array(
                                                        'checked' => (isset($this->settings['settings']['signature_enable']) ? (int) $this->settings['settings']['signature_enable'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <?php
                                            if(isset($this->settings['settings']['signature_enable'])
                                                && (int) $this->settings['settings']['signature_enable'] == 1){
                                                $tbpSignatureText = '';
                                            }else{
                                                $tbpSignatureText = 'tbpHidden';
                                            }
                                            ?>
                                            <tr class="col-md-12 <?php echo $tbpSignatureText?>" id="tbpSignatureText">
                                                <td class="col-md-5">
                                                    <?php _e('Signature Text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-7">
                                                    <?php echo htmlTbp::textarea('settings[signature_text]', array(
                                                        'value' => (isset($this->settings['settings']['signature_text']) ? $this->settings['settings']['signature_text'] : ''),
                                                        'attrs' => 'style="width:100%"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Header', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Check here if you want to show the table head.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[header_show]', array(
                                                        'checked' => (isset($this->settings['settings']['header_show']) ? (int) $this->settings['settings']['header_show'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Footer', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Check here if you want to show the table footer.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[footer_show]', array(
                                                        'checked' => (isset($this->settings['settings']['footer_show']) ? (int) $this->settings['settings']['footer_show'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Fixed Header', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allows to fix the table\'s header during table scrolling. Important! Header option must be enabled for using this feature. Also you need to set Fixed Table Height to create a vertical scroll for your table. To see the work of this feature you should not use such Responsive Modes such as Standard and Automatic columns hiding.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[header_fixed]', array(
                                                        'checked' => (isset($this->settings['settings']['header_fixed']) ? (int) $this->settings['settings']['header_fixed'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <th class="col-md-12"><?php echo __('Date Formats', TBP_LANG_CODE)?></th>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Date', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set output format for date. For example: Y-M-D - 1991-12-25, D.M.Y - 25.12.1991', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[date_formats]', array(
                                                        'value' => (isset($this->settings['settings']['date_formats']) ? $this->settings['settings']['date_formats'] : 'D.M.Y'),
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Time / Duration', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set output format for time and duration. For example:  1) time - H:m - 18:00 , h:m a - 9:00 pm 2) duration h:m - 36:40, h:m:s - 36:40:12', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[time_formats]', array(
                                                        'value' => (isset($this->settings['settings']['time_formats']) ? $this->settings['settings']['time_formats'] : 'H:m'),
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                                <section class="row row-settings-tab" id="row-tab-settings-features">
                                    <table class="form-settings-table">
                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <th class="col-md-12"><?php echo __('General', TBP_LANG_CODE)?></th>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Responsive mode', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Enable responsive mode to fit all container width', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[responsive_mode]', array(
                                                        'checked' => (isset($this->settings['settings']['responsive_mode']) ? (int) $this->settings['settings']['responsive_mode'] : 1)
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Table information', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Show pagination information after table ', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[table_information]', array(
                                                        'checked' => (isset($this->settings['settings']['table_information']) ? (int) $this->settings['settings']['table_information'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Sorting', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allow dynamic sorting with arrows. To use this option you must enable Header option.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[sorting]', array(
                                                        'checked' => (isset($this->settings['settings']['sorting']) ? (int) $this->settings['settings']['sorting'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Pagination', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Show table pagination.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[pagination]', array(
                                                        'checked' => (isset($this->settings['settings']['pagination']) ? (int) $this->settings['settings']['pagination'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Searching', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Show table searching field.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[searching]', array(
                                                        'checked' => (isset($this->settings['settings']['searching']) ? (int) $this->settings['settings']['searching'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Print', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Show table print button.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[print]', array(
                                                        'checked' => (isset($this->settings['settings']['print']) ? (int) $this->settings['settings']['print'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-md-6 tbpHidden">
                                            <tr class="col-md-12">
                                                <th class="col-md-12"><?php echo __('Export', TBP_LANG_CODE)?></th>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Frontend Export', TBP_LANG_CODE)?>
                                                    <span class="tbpPro">
                                                        <a target="_blank" class="supsystic-pro-feature" href="https://supsystic.com/plugins/data-tables-generator-plugin/?utm_medium=editable_fields_feature&amp;utm_source=plugin&amp;utm_campaign=data-tables"><?php _e('PRO option', TBP_LANG_CODE)?></a>
                                                    </span>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allow export from frontend.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[frontend_export]', array(
                                                        'checked' => (isset($this->settings['settings']['frontend_export']) ? (int) $this->settings['settings']['frontend_export'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                                <section class="row row-settings-tab" id="row-tab-settings-design">
                                    <table class="form-settings-table" style="width: 100%">
                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Auto Table Width', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('If checked - width of table columns will be calculated automatically for table width 100%', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[auto_width]', array(
                                                        'checked' => (isset($this->settings['settings']['auto_width']) ? (int) $this->settings['settings']['auto_width'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <?php
                                            if(isset($this->settings['settings']['auto_width'])
                                                && (int) $this->settings['settings']['auto_width'] == 1){
                                                $tbpFixedTableWidthText = 'tbpVisibilityHidden';
                                            }else{
                                                $tbpFixedTableWidthText = '';
                                            }
                                            ?>
                                            <tr class="col-md-12 <?php echo $tbpFixedTableWidthText; ?>" id="tbpFixedTableWidthText">
                                                <td class="col-md-5">
                                                    <?php _e('Fixed Table Width', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Set fixed table width in px or %.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[width][fixed_width]', array(
                                                        'value' => (isset($this->settings['settings']['width']['fixed_width']) ? $this->settings['settings']['width']['fixed_width'] : '100'),
                                                        'attrs' => 'style="width: 60px"'
                                                    ))?>
                                                    <?php echo htmlTbp::selectbox('settings[width][width_unit]', array(
                                                        'options' => array('pixels' => 'px', 'percents' => '%'),
                                                        'value' => (isset($this->settings['settings']['width']['width_unit']) ? $this->settings['settings']['width']['width_unit'] : 'percents'),
                                                        'attrs' => 'style="width: 60px"'
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Borders', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Cell - adds border around all four sides of each cell, Row - adds border only over and under each row. (i.e. only for the rows).', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::selectbox('settings[borders]', array(
                                                        'options' => array('cell' => 'cell', 'rows' => 'rows', 'none' => 'none'),
                                                        'value' => (isset($this->settings['settings']['borders']) ? $this->settings['settings']['borders'] : 'cell'),
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Row Striping', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Add automatic highlight for table odd rows', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[row_striping]', array(
                                                        'checked' => (isset($this->settings['settings']['row_striping']) ? (int) $this->settings['settings']['row_striping'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Highlighting by Mousehover', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Row highlighting by mouse hover.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[highlighting_mousehover]', array(
                                                        'checked' => (isset($this->settings['settings']['highlighting_mousehover']) ? (int) $this->settings['settings']['highlighting_mousehover'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Highlight the Order Column', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('If checked - the current sorted column will be highlighted', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[highlighting_order_column]', array(
                                                        'checked' => (isset($this->settings['settings']['highlighting_order_column']) ? (int) $this->settings['settings']['highlighting_order_column'] : '')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Hide Table Loader', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Enable / disable table loader icon before table will be completely loaded.', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::checkbox('settings[hide_table_loader]', array(
                                                        'checked' => (isset($this->settings['settings']['hide_table_loader']) ? (int) $this->settings['settings']['hide_table_loader'] : '')
                                                    ))?>
                                                </td>
                                            </tr>

                                            <?php
                                            $colorPreview = (isset($this->settings['settings']['table_loader_icon_color']) ? $this->settings['settings']['table_loader_icon_color'] : 'black');
                                            $iconName = (isset($this->settings['settings']['table_loader_icon_name']) ? $this->settings['settings']['table_loader_icon_name'] : 'default');
                                            $iconNumber = (isset($this->settings['settings']['table_loader_icon_number']) ? $this->settings['settings']['table_loader_icon_number'] : '0');

                                            if($iconName === 'default'){
                                                $htmlPreview = '<div class="supsystic-table-loader spinner" style="background-color:'.$colorPreview.'"></div>';
                                            }else{
                                                $htmlPreview = '<div class="supsystic-table-loader la-'.$iconName.' la-2x" style="color: '.$colorPreview.'">';
                                                for($i = 1; $i <= $iconNumber; $i++){
                                                    $htmlPreview .= '<div></div>';
                                                }
                                                $htmlPreview .= '</div>';
                                            }

                                            ?>
                                            <?php
                                            if(isset($this->settings['settings']['hide_table_loader'])
                                                && (int) $this->settings['settings']['hide_table_loader'] == 1){
                                                $tbpLoader = 'tbpHidden';
                                            }else{
                                                $tbpLoader = '';
                                            }
                                            ?>
                                            <tr class="col-md-12 tbpLoader <?php echo $tbpLoader; ?>" >
                                                <td class="col-md-5">
                                                    <?php _e('Table Loader Icon', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Choose icon for loader', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <div class="button chooseLoaderIcon"><?php _e('Choose Icon', TBP_LANG_CODE)?></div>
                                                    <div class="tbpIconPreview"><?php echo $htmlPreview; ?></div>
                                                    <?php echo htmlTbp::hidden('settings[table_loader_icon_name]', array(
                                                        'value' => (isset($this->settings['settings']['table_loader_icon_name']) ? $this->settings['settings']['table_loader_icon_name'] : 'default')
                                                    ))?>
                                                    <?php echo htmlTbp::hidden('settings[table_loader_icon_number]', array(
                                                        'value' => (isset($this->settings['settings']['table_loader_icon_number']) ? $this->settings['settings']['table_loader_icon_number'] : '0')
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12 tbpLoader <?php echo $tbpLoader; ?> tbpColorObserver">
                                                <td class="col-md-5">
                                                    <?php _e('Border color', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Choose color for loader', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::colorpicker('settings[table_loader_icon_color]', array(
                                                        'value' => (isset($this->settings['settings']['table_loader_icon_color']) ? $this->settings['settings']['table_loader_icon_color'] : 'black'),
                                                        'attrs' => 'style="width: 50px"',
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                                <section class="row row-settings-tab" id="row-tab-settings-text">
                                    <table class="form-settings-table">
                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <th class="col-md-12"><?php echo __('Overwrite Table Text', TBP_LANG_CODE)?></th>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Empty table', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[empty_table]', array(
                                                        'value' => (isset($this->settings['settings']['empty_table']) ? $this->settings['settings']['empty_table'] : ''),
                                                        'attrs' => 'placeholder="No data available in table"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Table info text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[table_info]', array(
                                                        'value' => (isset($this->settings['settings']['table_info']) ? $this->settings['settings']['table_info'] : ''),
                                                        'attrs' => 'placeholder="Showing _START_ to _END_ of _TOTAL_ entries"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Empty info text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[table_info_empty]', array(
                                                        'value' => (isset($this->settings['settings']['table_info_empty']) ? $this->settings['settings']['table_info_empty'] : ''),
                                                        'attrs' => 'placeholder="Showing 0 to 0 of 0 entries"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Filtered info text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[filtered_info_text]', array(
                                                        'value' => (isset($this->settings['settings']['filtered_info_text']) ? $this->settings['settings']['filtered_info_text'] : ''),
                                                        'attrs' => 'placeholder="(filtered from _MAX_ total entries)"'
                                                    ))?>
                                                </td>
                                            </tr>

                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Length text', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[length_text]', array(
                                                        'value' => (isset($this->settings['settings']['length_text']) ? $this->settings['settings']['length_text'] : ''),
                                                        'attrs' => 'placeholder="Show _MENU_ entries"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Search label', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[search_label]', array(
                                                        'value' => (isset($this->settings['settings']['search_label']) ? $this->settings['settings']['search_label'] : ''),
                                                        'attrs' => 'placeholder="Search:"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Zero records', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2"></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[zero_records]', array(
                                                        'value' => (isset($this->settings['settings']['zero_records']) ? $this->settings['settings']['zero_records'] : ''),
                                                        'attrs' => 'placeholder="No matching records are found"'
                                                    ))?>
                                                </td>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Export label', TBP_LANG_CODE)?>
                                                </td>
                                                <td class="col-md-2">
                                                    <i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This label can not be translated using Table Language option. You can change this label typing the custom text or hide this label typing _NONE_ as label text.', TBP_LANG_CODE))?>"></i></td>
                                                </td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::text('settings[export_label]', array(
                                                        'value' => (isset($this->settings['settings']['export_label']) ? $this->settings['settings']['export_label'] : ''),
                                                        'attrs' => 'placeholder="Save as"'
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-md-6">
                                            <tr class="col-md-12">
                                                <th class="col-md-12"><?php echo __('Language', TBP_LANG_CODE)?></th>
                                            </tr>
                                            <tr class="col-md-12">
                                                <td class="col-md-5">
                                                    <?php _e('Table Language', TBP_LANG_CODE)?>
                                                    <span class="tbpPro">
                                                            <a target="_blank" class="supsystic-pro-feature" href="https://supsystic.com/plugins/data-tables-generator-plugin/?utm_medium=editable_fields_feature&amp;utm_source=plugin&amp;utm_campaign=data-tables"><?php _e('PRO option', TBP_LANG_CODE)?></a>
                                                        </span>
                                                </td>
                                                <td class="col-md-2"><i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Allows to choose language for the table\'s labels (pagination, search ets.)', TBP_LANG_CODE))?>"></i></td>
                                                <td class="col-md-5">
                                                    <?php echo htmlTbp::selectbox('settings[language]', array(
                                                        'options' => $this->languages,
                                                        'value' => (isset($this->settings['settings']['language']) ? $this->settings['settings']['language'] : 'English'),
                                                        'attrs' => 'class="chosen" style="width: 100%"'
                                                    ))?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                            </section>
                        </div>
					</div>
					<div class="row row-tab" id="row-tab-content">
                        <!-- Save post id's -->
                        <?php echo htmlTbp::hidden('settings[postids]', array(
                            'value' => (isset($this->settings['settings']['postids']) ? $this->settings['settings']['postids'] : ''),
                        ));?>
                        <!-- Save show elements name like columns order in content table -->
                        <?php echo htmlTbp::hidden('settings[order]', array(
                            'value' => (isset($this->settings['settings']['order']) ? $this->settings['settings']['order'] : $columnsNamesStr),
                        ));?>

						<div class="col-xs-12">
                            <div class="tbpSearchTypeWrapp">
                                <div class="tbpTitle"><?php _e('Add content by', TBP_LANG_CODE)?>: </div>
                                <div id="tbpSearchType" class="tbpMenu">
                                    <label class="radio-inline"><input type="radio" name="optradio" data-search="post" checked><?php _e('Post', TBP_LANG_CODE)?></label>
                                    <label class="radio-inline"><input type="radio" name="optradio" data-search="category"><?php _e('Category', TBP_LANG_CODE)?></label>
                                    <label class="radio-inline"><input type="radio" name="optradio" data-search="tags"><?php _e('Tags', TBP_LANG_CODE)?></label>
                                    <label class="radio-inline"><input type="radio" name="optradio" data-search="authors"><?php _e('Authors', TBP_LANG_CODE)?></label>
                                </div>
                            </div>
                            <div class="tbpCheckColumns">
                                <div class="tbpTitle"><?php _e('Show columns', TBP_LANG_CODE)?>: </div>
                                <?php $columnsNamesStrSaved = isset($this->settings['settings']['order']) ? $this->settings['settings']['order'] : $columnsNamesStr; ?>
                                <?php $columnsNamesArray = explode(',', $columnsNamesStrSaved); ?>
                                <?php foreach($columnsNames as $key => $title){
                                    if( in_array($key, $columnsNamesArray) ){
                                        $checked = 'checked';
                                    }else{
                                        $checked = '';
                                    }
                                    ?>
                                    <label><input type="checkbox" value="<?php echo $key; ?>" <?php echo $checked; ?> /> <?php echo $title; ?></label>
                                    <?php
                                }
                                ?>
                            </div>

							<div id="tbpSearchContentTbl">
                                <h3 style="text-align: center"><?php _e('Content selection table', TBP_LANG_CODE)?></h3>
                                <table id="tbpSearchTable" class="tbpSearchTable"></table>
							</div>
                            <div id="tbpSortTableContent">
                                <h3 style="text-align: center"><?php _e('Content table', TBP_LANG_CODE)?></h3>
                                <table id="tbpContentTable" class="tbpContentAdmTable" style="width:100%;"></table>
                            </div>
						</div>
					</div>
					<div class="row row-tab" id="row-tab-preview">
						<div class="col-xs-12" style="max-width: 1000px;">
                            <div id="loadingProgress" class="tbpHidden tbpAdminPreviewNotice">
                                <p class="description">
                                    <i class="fa fa-fw fa-spin fa-circle-o-notch"></i>
                                    <?php _e('Loading your table, please wait...', TBP_LANG_CODE)?>
                                </p>
                            </div>
                            <div id="loadingEmpty" class="tbpHidden tbpAdminPreviewNotice">
                                <p class="description">
                                    <i class="fa fa-fw fa-exclamation-circle"></i>
                                    <?php _e('Table is empty', TBP_LANG_CODE)?>
                                </p>
                            </div>
                            <div id="loadingFinished" class="tbpHidden tbpAdminPreviewNotice">
                                <p class="description">
                                    <i class="fa fa-fw fa-exclamation-circle"></i>
                                    <?php _e('Note that the table may look a little different depending on your theme style.', TBP_LANG_CODE)?>
                                </p>
                            </div>
                            <div id="tbp-table-wrapper-1" class="tbpTableWrapper" >
                                <table id="tbpPreviewTable" class="tbpContentTable"></table>
                            </div>
                        </div>
					</div>

					<?php echo htmlTbp::hidden( 'mod', array( 'value' => 'tablepress' ) ) ?>
					<?php echo htmlTbp::hidden( 'action', array( 'value' => 'save' ) ) ?>
					<?php echo htmlTbp::hidden( 'id', array( 'value' => $this->table['id'] ) ) ?>
				</form>
				<div style="clear: both;"></div>
			</div>
		</div>
	</section>
</div>

<?php

?>