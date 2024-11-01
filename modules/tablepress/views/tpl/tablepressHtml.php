<!-- this style need to prevent display table before frontend.tables.css is loaded -->
<style>
    .tbpVisibilityHidden{
        visibility: hidden;
    }
</style>

<div id="tbp-table-wrapper-<?php echo $this->viewId;?>" class="tbpTableWrapper tbpVisibilityHidden">
    <table id="tbp-table-<?php echo $this->viewId;?>" class="tbpContentTable" data-settings="<?php echo htmlspecialchars(json_encode($this->settings['settings']), ENT_QUOTES, 'UTF-8'); ?>">
        <?php echo $this->html; ?>
    </table>
</div>
