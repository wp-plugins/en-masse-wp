<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2>Edit A Bill Template</h2>
    <?php
    global $bill;
		if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
			$messages[] = sprintf( _n( '%d bill template updated.', '%d bill templates updated.', $_REQUEST['updated'] ), number_format_i18n( $_REQUEST['updated']) );
			unset($_REQUEST['updated']);
			?>
            <div id="message" class="updated"><p>
            <?php if ( $messages )
				echo join( ' ', $messages );
				unset( $messages );
            ?>
			</p></div>
            <?
		}
	?> 
    <div class="form-wrap">
        <form id="addtag" method="post" action="admin.php?page=enmasse_billeditor&action=edit&id=<?php echo $bill->id; ?>&noheader=true" class="validate">
            <div class="form-field">
                <label style="font-size:16px;"><?php _e('Slug Name: '.$bill->slug_name,'enmassetxt') ?></label>
            </div>
            <div class="form-field">
                <label for="avail-attribute" style="font-size:16px;"><?php _e('Available Attribute: '.$bill->avail_attribute, 'enmassetxt'); ?></label>
            </div>
			<div id="postdivrich" class="postarea">
                <label for="content" style="font-size:16px;"><?php _e('Content', 'enmassetxt'); ?></label>
                <?php wp_editor(stripslashes($bill->content), 'content', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>20) ); ?>
            </div>            
        <?php
        submit_button("", 'button' );
        ?>
        </form>
	</div>            
</div>