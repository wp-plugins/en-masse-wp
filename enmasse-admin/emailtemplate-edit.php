<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2>Edit A Email Template</h2>
    <?php
    global $email_tmp;
		if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
			$messages[] = sprintf( _n( '%d email template updated.', '%d email templates updated.', $_REQUEST['updated'] ), number_format_i18n( $_REQUEST['updated']) );
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
        <form id="addtag" method="post" action="admin.php?page=enmasse_emailtemplate&action=edit&id=<?php echo $email_tmp->id; ?>&noheader=true" class="validate">
            <div class="form-field">
                <label style="font-size:16px;"><?php _e('Slug Name: '.$email_tmp->slug_name,'enmassetxt') ?></label>
                <p><?php _e('The slug name of the mail','enmassetxt'); ?></p>
            </div>
            <div class="form-field">
                <label for="avail-attribute" style="font-size:16px;"><?php _e('Available Attribute: '.$email_tmp->avail_attribute, 'enmassetxt'); ?></label>
                <p><?php _e('All attributes are requied for email'); ?></p>
            </div>
            <div class="form-field form-required">
                <label for="subject" style="font-size:16px;"><?php _e('Subject', 'enmassetxt'); ?></label>
                <input name="subject" id="subject" type="text" value="<?php echo $email_tmp->subject; ?>" size="40" aria-required="true" />
                <p><?php _e('The subject of the email'); ?></p>
            </div>
            <div id="postdivrich" class="postarea form-required">
                <label for="content" style="font-size:16px;"><?php _e('Content', 'enmassetxt'); ?></label>
                <?php wp_editor(stripslashes($email_tmp->content), 'content', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>10) ); ?> 
            </div>
        <?php
        submit_button("", 'button' );
        ?>
        </form>
	</div>            
</div>