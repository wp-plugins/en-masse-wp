<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2>Add New Payment Gateway</h2>
    <?php
    global $pay_gty;
		if ( isset($_REQUEST['added']) && (int) $_REQUEST['added'] ) {
			$messages[] = sprintf( _n( '%d payment gateway added.', '%d payment gateway added.', $_REQUEST['added'] ), number_format_i18n( $_REQUEST['added']) );
			unset($_REQUEST['added']);
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
    <div id="poststuff" class="metabox-holder<?php echo 1 != $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
		<form id="addtag" method="post" action="admin.php?page=enmasse_paymentgateway&action=add&noheader=false" class="validate">  
            <div id="side-info-column" class="inner-sidebar">
                <!-- SIDE BAR -->
                <style>
                .form-field input { width:100%;}
                .form-field input[type='checkbox'] { width:inherit}
                .form-field textarea { width:100%;}
                .form-input-right {float:right; display:block;}
                .requiretxt {color:#FF0000;}
                .requiretxt:hover {text-decoration:underline; }
                </style>
                <?php
                global $pay_gty;
                add_meta_box('submitdiv', __('Publish'), 'pay_gty_submit_meta_box', null, 'side', 'core');
                $side_meta_boxes = do_meta_boxes(do_action('submitpost_box'), 'side', $pay_gty);
                do_action('dbx_post_sidebar');
                ?>
        
                <!-- SIDE BAR -->    
            </div>     
			<div id="post-body">
				<div id="post-body-content">              
					<div class="form-wrap">
						<div class="form-field form-required">
							<label for="pay-gty-name" ><?php _e('Name','enmassetxt') ?></label>
							<input name="pay-gty-name" id="pay-gty-name" type="text" value="" size="40" aria-required="true" />
							<p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
						</div>
						<div class="form-field form-required">
							<label for="pay-gty-classname"><?php _e('Class Name','enmassetxt') ?></label>
							<input name="pay-gty-classname" id="pay-gty-classname" type="text" value="" size="40" aria-required="true" />
						</div>
						<div id="postdivrich" class="postarea">
							<label for="pay-gty-description"><h3><?php _e('Description', 'enmassetxt'); ?></h3></label>
							<p><?php _e('The description is not prominent by default; however, some themes may show it.','enmassetxt'); ?></p>  
							<?php wp_editor('', 'pay-gty-description', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>10) ); ?>  
						</div>
                        <div>
                        	<input type="hidden" id="count" value="1"/>
                            <table class="admintable">
                                <tbody id="admintable">
                                    <tr>
                                        <th><?php echo _e('Attribute Name','enmassetxt'); ?></th>
                                        <th><?php echo _e('Attribute Values','enmassetxt'); ?></th>
                                    </tr>
                                    <tr>
                                        <td><input class="text_area" type="text" name="attribute_name[1]" 
                                           id="attribute_name[1]" size="50" maxlength="250" 
                                           value="" /></td>
                                        <td><input class="text_area" type="text" name="attribute_value[1]" 
                                           id="attribute_value[1]" size="50" maxlength="250" 
                                           value="" /></td>
                                    </tr>
                                </tbody>	
                            </table>
                            <a href="#" onclick="addAttributeRow('admintable'); return false;"><?php echo _e('Add Attribute','enmassetxt'); ?></a>
                        </div>
					</div> 
				</div>
			</div>    
		</form> 
	</div>	
</div>