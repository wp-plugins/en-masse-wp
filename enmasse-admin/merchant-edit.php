	<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2><? _e('Edit Merchant','enmassetxt') ?><a href="admin.php?page=enmasse_merchant&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new merchan'); ?></a></h2>
    <?php
    	
		if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
			$messages[] = sprintf( _n( '%s Merchant updated.', '%s merchants updated.', $_REQUEST['updated'] ), number_format_i18n( $_REQUEST['updated']) );
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
	 	<form id="addtag" method="post" action="admin.php?page=enmasse_merchant&action=edit&noheader=true&id=<?php echo $mer->id; ?>" class="validate" accept-charset="UTF-8">
		<div id="poststuff" class="metabox-holder<?php echo 1 != $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
			<div id="side-info-column" class="inner-sidebar">
				<!-- SIDE BAR -->
				<style>			
				.form-field input[type='checkbox'] { width:inherit}
				.form-field textarea { width:100%;}
				.form-input-right {float:right; display:block;}
				.requiretxt {color:#FF0000;}
				.requiretxt:hover {text-decoration:underline; }
				#side-info-column .inside{margin: 0;padding: 0;}			
				</style>
				<?php
				global $merchan;
				add_meta_box('subdiv', __('Publish'), 'merchant_publish_meta_box', null, 'side', 'core');
				//add_meta_box('googlediv', __('Google Map'), 'merchant_google_meta_box', null, 'side', 'core');
				$side_meta_boxes = do_meta_boxes(do_action('submitpost_box'), 'side', $mer);
				do_action('dbx_post_sidebar');
				?>
		
				<!-- SIDE BAR -->    
			</div>    
			<div id="post-body">
				<div id="post-body-content">              
					<div class="form-wrap">
							<div class="form-field form-required">
								<label for="mar-name"><?php _e('Name','enmassetxt') ?></label>
								<input name="mer-name" id="mer-name" type="text" value="<?php echo $mer->name ?>" size="40" />
								<p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
							</div>
							<div class="form-field">
								<label for="mer-web-url"><?php _e('Web URL', 'enmassetxt'); ?></label>
								  <input name="mer-web-url" id="mer-web-url" type="text" value="<?php echo $mer->web_url ?>" size="40" />
							</div>
							<div class="form-field">
								<label for="mer-logo-url"><?php _e('Logo URL', 'enmassetxt'); ?></label>
								  <input name="mer-logo-url" id="mer-logo-url" type="text" value="<?php echo $mer->logo_url ?>" size="40" />
							</div>
							<div class="form-field form-required">
								<label for="mer-address"><?php _e('Address','enmassetxt') ?></label>
								<textarea name="mer-address" id="mer-address" aria-required="true" ><?php echo $mer->address ?></textarea>
							</div>
							<div id="postdivrich" class="postarea">
							<label for="mer-description"><?php _e('Description', 'enmassetxt'); ?></label>
							<?php wp_editor($mer->description, 'mer-description', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>10) ); ?>					
							</div> 
							<div class="form-field" id="branches">
								<? 
									$mer->branches = str_replace("\\","",$mer->branches);
									$branches = json_decode($mer->branches,true);
									$num_of_branches = count($branches);	
									$count = 1;
									if(!empty($branches)):
								 		foreach($branches as $branch){ 
								?>
                                <table class="branchesRow" style="width: 100%" id="branches<? echo $count?>">
                                    <tr><th colspan=2># <? echo $branch['name'] ?></th></tr>
                                    <tr>
                                        <td>Check to remove</td>
                                        <td><input type="checkbox" onclick="uncheckRequire(this);" name="remove-<? echo $count?>" id="remove-<? echo $count?>"/></td>
                                    	<input type="hidden" id="branchname-<? echo $count?>" name="branchname-<? echo $count?>" value="branch<? echo $count?>"/>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="name-<? echo $count?>">Merchant name</label>
                                        </td>
                                        <td class="form-required" style="width: 100%"><input maxlength="50" type="text" name="name-<? echo $count?>" id="name-<? echo $count?>" size="50" maxlength="250" value="<? echo $branch['name'] ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="description-<? echo $count?>">Merchant description</label>
                                        </td>
                                        <td style="width: 100%"><textarea name="description-<? echo $count?>" id="description-<? echo $count?>" cols="10" rows="5"><? echo $branch['description'] ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="address-<? echo $count?>">Merchant address</label>
                                        </td>
                                        <td class="form-required" style="width: 100%"><textarea name="address-<? echo $count?>" id="address-<? echo $count?>" cols="10" rows="5"><? echo $branch['address'] ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="telephone-<? echo $count?>">Merchant telephone</label>
                                        </td>
                                        <td class="form-required" style="width: 100%"><input type="text" name="telephone-<? echo $count?>" id="telephone-<? echo $count?>" size="15" maxlength="250" value="<? echo $branch['telephone'] ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="fax-<? echo $count?>">Merchant fax</label>
                                        </td>
                                        <td style="width: 100%"><input type="text" name="fax-<? echo $count?>" id="fax-<? echo $count?>" size="15" maxlength="250" value="<? echo $branch['fax'] ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="google_map_lat-<? echo $count?>">Google map latitude</label>
                                        </td>
                                        <td class="form-required" style="width: 100%"><input type="text" name="google_map_lat-<? echo $count?>" id="google_map_lat-<? echo $count?>" size="15" maxlength="250" value="<? echo $branch['google_map_lat'] ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<label for="google_map_long-<? echo $count?>">Google map longtitude</label>
                                        </td>
                                    	<td class="form-required" style="width: 100%"><input type="text" name="google_map_long-<? echo $count?>" id="google_map_long-<? echo $count?>" size="15" maxlength="250" value="<? echo $branch['google_map_long'] ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>
                                    		<label for="goole_map_zoom-<? echo $count?>">Google map zoom</label>
                                    	</td>
                                    	<td style="width: 100%">
                                    		<input type="text" name="google_map_zoom-<? echo $count?>" id="google_map_zoom-<? echo $count?>" size="15" maxlength="250" value="<? echo $branch['google_map_zoom'] ?>" />
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2\"><hr/></td>
                                    </tr>
                                </table>
								<? $count++; } ?>								
								<? endif; ?>
							</div>
							<a onclick="addNewMerchantBranch(); return false;" href="#"><? _e('Add new branch','enmassetxt') ?></a>
                            <input type="hidden" name="num_of_branches" value="<? echo count($branches) ?>" />
							<?php submit_button("", 'button' ); ?> 			       
					</div> 
				</div>
			</div>               
		</div>
		</form>
	</div>