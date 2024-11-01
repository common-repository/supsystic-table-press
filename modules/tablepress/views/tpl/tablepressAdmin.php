<section>
    <div class="supsystic-item supsystic-panel">
        <div id="containerWrapper">
            <ul id="tbpTableTblNavBtnsShell" class="supsystic-bar-controls">
                <li title="<?php _e('Delete selected', TBP_LANG_CODE)?>">
                    <button class="button" id="tbpTableRemoveGroupBtn" disabled data-toolbar-button>
                        <i class="fa fa-fw fa-trash-o"></i>
						<?php _e('Delete selected', TBP_LANG_CODE)?>
                    </button>
                </li>
                <li title="<?php _e('Search', TBP_LANG_CODE)?>">
                    <input id="tbpTableTblSearchTxt" type="text" name="tbl_search" placeholder="<?php _e('Search', TBP_LANG_CODE)?>">
                </li>
            </ul>
            <div id="tbpTableTblNavShell" class="supsystic-tbl-pagination-shell"></div>
            <div style="clear: both;"></div>
            <hr />
            <table id="tbpTableTbl"></table>
            <div id="tbpTableTblNav"></div>
            <div id="tbpTableTblEmptyMsg" style="display: none;">
                <h3><?php printf(__('You have no Tables for now. <a href="%s" style="font-style: italic;">Create</a> your Table!', TBP_LANG_CODE), $this->addNewLink)?></h3>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div id="prewiew" style="margin-top: 30px"></div>
    </div>
</section>