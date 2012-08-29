<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2>Edit A Payment Gateway <a href="admin.php?page=enmasse_paymentgateway&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new payment gateway'); ?></a></h2>
    <?php
    global $pay_gty;
		if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
			$messages[] = sprintf( _n( '%d payment gateway updated.', '%d payment gateways updated.', $_REQUEST['updated'] ), number_format_i18n( $_REQUEST['updated']) );
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
    <div id="poststuff" class="metabox-holder<?php echo 1 != $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
		<form id="addtag" method="post" action="admin.php?page=enmasse_paymentgateway&action=edit&noheader=true&id=<?php echo $pay_gty->id; ?>" class="validate"> 
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
							<label for="pay-gty-name"><?php _e('Name','enmassetxt') ?></label>
							<input name="pay-gty-name" id="pay-gty-name" type="text" value="<?php echo $pay_gty->name ?>" size="40" aria-required="true" />
							<p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
						</div>
						<div class="form-field form-required">
							<label for="pay-gty-classname"><?php _e('Class Name','enmassetxt') ?></label>
							<input name="pay-gty-classname" id="pay-gty-classname" type="text" value="<?php echo $pay_gty->class_name ?>" size="40" aria-required="true" />
						</div>
						<div id="postdivrich" class="postarea">
							<label for="pay-gty-description"><h3><?php _e('Description', 'enmassetxt'); ?></h3></label>
							<p><?php _e('The description is not prominent by default; however, some themes may show it.','enmassetxt'); ?></p>  
							<?php wp_editor(stripslashes($pay_gty->description), 'pay-gty-description', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>10) ); ?>  
						</div>
                        <div>
                        	<table class="admintable">
                                <tbody id="admintable">
                                <?php
                                        $attribute_names = explode(",",$pay_gty->attributes);
                                        $attribute_values = json_decode($pay_gty->attribute_config);
										$numofattribute = count($attribute_names);
                                        for ($i=0; $i < $numofattribute; $i++)
                                        {
											$count = $i + 1;
											$name = $attribute_names[$i];
											$name == '' ? $value = '' : $value = $attribute_values->$name;
								?>	
									<tr>
										<th><?php echo _e('Attribute Name','enmassetxt'); ?></th>
										<th><?php echo _e('Attribute Value','enmassetxt'); ?></th>
									</tr>
									<tr>
										<td><input class="text_area" type="text" name="attribute_name[<?php echo $count; ?>]"
											id="attribute_name[<?php echo $count; ?>]" size="50" maxlength="250" 
											value="<?php echo $name; ?>" /></td>
										<td><input class="text_area" type="text" name="attribute_value[<?php echo $count; ?>]" 
										   id="attribute_value[<?php echo $count; ?>]" size="50" maxlength="250" 
										   value="<?php echo $value; ?>" /></td>
									</tr>
								<?php
										}
								?>	
								</tbody>	
							</table>
                            <input type="hidden" id="count" value="<?php echo $count; ?>"/>
                            <a href="#" onclick="addAttributeRow('admintable'); return false;"><?php echo _e('Add Attribute','enmassetxt'); ?></a>
						</div>
					</div> 
				</div>
			</div>    
		</form> 
	</div>	
</div>