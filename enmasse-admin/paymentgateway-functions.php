<?php
function pay_gty_submit_meta_box () {
	global $pay_gty;
?>
<div class="submitbox" id="submitpost">
    <div id="misc-publishing-actions">
        <div class="misc-pub-section">
            <span>
				<?php _e('Published','enmassetxt') ?>
            </span>
            <span class="form-input-right">
                <label for="published1">Yes</label>
                <input type="radio" value="1" name="published" id="published1"  <?php if(isset($pay_gty->published) && $pay_gty->published == 1 ) { ?> checked="checked" <?php } ?> />
                <label for="published0">No</label>
                <input type="radio" value="0" name="published" id="published0"	<?php if(!$pay_gty->published) { ?> checked="checked" <?php } ?>  />
            </span>
            <div class="clear"></div>           
        </div>
        <div class="clear"></div>
	</div>
    <div id="minor-publishing">
        <div id="major-publishing-actions">
            <div id="publishing-action">
            	<input name="submit" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Publish" />
            </div>
       	 	<div class="clear"></div>
        </div>
    </div>
</div>
<?
}
?>