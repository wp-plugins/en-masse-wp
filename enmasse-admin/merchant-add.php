	<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2>Add New Merchant</h2>
    <?php
		if ( isset($_REQUEST['added']) && (int) $_REQUEST['added'] )
		 {
			$num = $_REQUEST['added'];
			$messages[] = sprintf( _n( '%d Merchant added.', '%d merchants added.', $num ), number_format_i18n( $num) );
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
	<form id="addtag" method="post" action="admin.php?page=enmasse_merchant&action=add&noheader=true" class="validate">
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
			<?php global $fluginurl;?>
			.ui-autocomplete-loading { background: white url('<?=$fluginurl?>/enmasse-admin/images/ui-anim_basic_16x16.gif') right center no-repeat;}
			</style>
			<?php
			global $merchan;
			add_meta_box('submitdiv', __('Information'), 'merchant_publish_meta_box', null, 'side', 'core');
	        //add_meta_box('googlediv', __('Google Map'), 'merchant_google_meta_box', null, 'side', 'core');
			$side_meta_boxes = do_meta_boxes(do_action('submitpost_box'), 'side', $merchan);
	        do_action('dbx_post_sidebar');
	        ?>
	        <!-- SIDE BAR -->    
	    </div>    
	    <div id="post-body">
		    <div id="post-body-content">              
	            <div class="form-wrap">
			            <div class="form-field form-required">
			                <label for="mer-name"><?php _e('Name','enmassetxt') ?></label>
			                <input name="mer-name" id="mer-name" type="text" value="" size="40" />
			                <p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
			            </div>    			            
			            <div class="form-field">
			                <label for="mer-web-url"><?php _e('Web URL', 'enmassetxt'); ?></label>
			                  <input name="mer-web-url" id="mer-web-url" type="text" value="" size="40" />
			            </div>
			            <div class="form-field">
			                <label for="mer-logo-url"><?php _e('Logo URL', 'enmassetxt'); ?></label>
			                  <input name="mer-logo-url" id="mer-logo-url" type="text" value="" size="40" />
			            </div>
                        <div class="form-field form-required">
			                <label for="mer-address"><?php _e("Address","enmassetxt") ?></label>
			                <textarea name="mer-address" id="mer-address" aria-required="true" ><?php echo $mer->address ?></textarea>
			            </div>                        
			            <div id="postdivrich" class="postarea">
			            	<label for="mer-description"><?php _e('Description', 'enmassetxt'); ?></label>
			            	<?php wp_editor($post->post_content, 'mer-description', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>10) ); ?>
			            </div> 
			            <div class="form-field" id="branches">	    
	    				</div>
	    				<a onclick="addNewMerchantBranch(); return false;" href="#">Add new branch</a>                        
                        <input type="hidden" name="num_of_branches" value="0" />
                        <?php    submit_button("Save", 'button' ); ?>
			    </div> 
		    </div>
	    </div>   	    
	    </form>   
	</div>
