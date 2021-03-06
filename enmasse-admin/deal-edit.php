<?php
	ob_start(); 
	if(isset($_GET['did'])){
		echo '<meta http-equiv="refresh" content="1; URL='._DEAL."?did=".$_GET['did'].'">';
	}
?>
<div class="wrap columns-<?php echo (int) $screen_layout_columns ? (int) $screen_layout_columns : 'auto'; ?>">
    <h2>Edit A Deal <a href="admin.php?page=enmasse_deal&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new category'); ?></a></h2>
    <?php
    global $deal;
		if(isset($_REQUEST['message'])){
			$messages[] = $_REQUEST['message'];
			unset($_REQUEST['message']);
			?>
            <div id="message" class="updated"><p>
            <?php if ( $messages )
				echo join( ' ', $messages );
				unset( $messages );
            ?>
			</p></div>
            <?php
		}else if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
			$messages[] = sprintf( _n( '%d deal updated.', '%d deal updated.', $_REQUEST['added'] ), number_format_i18n( $_REQUEST['updated']) );
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
    <form id="addtag" method="post" action="admin.php?page=enmasse_deal&action=edit&noheader=true&id=<?php echo $deal->id; ?>" class="validate">
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
		add_meta_box('submitdiv', __('Publish'), 'deal_submit_meta_box', null, 'side', 'core');
		add_meta_box('catdiv', __('Category'), 'deal_cat_meta_box', null, 'side', 'core');
		add_meta_box('locdiv', __('Location'), 'deal_loc_meta_box', null, 'side', 'core');
        $side_meta_boxes = do_meta_boxes(do_action('submitpost_box'), 'side', $deal);
        do_action('dbx_post_sidebar');
        ?>

        <!-- SIDE BAR -->    
    </div>    
    <div id="post-body">
    <div id="post-body-content">              
            <div class="form-wrap">
            <input type="hidden" id="deal_status" name="deal_status" value="<? echo $deal->status?>"/>
            <div class="form-field form-required">
                <label for="deal-name"><?php _e('Name','enmassetxt') ?></label>
                <input name="deal-name" id="deal-name" type="text" value="<?php echo isset($_SESSION['data'])?$_SESSION['data']['name']:$deal->name ?>" size="40" aria-required="true" />
                <p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
            </div>
           
            <div id="postdivrich" class="postarea">
                <label for="deal-description"><h3><?php _e('Short Description', 'enmassetxt'); ?></h3></label>
                <!-- <textarea name="deal-sort-description" id="deal-sort-description" rows="5" cols="40"><?php echo $deal->short_desc  ?></textarea> -->
                <p><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>  
                <?php wp_editor(stripslashes(isset($_SESSION['data'])?$_SESSION['data']['short_desc']:$deal->short_desc), 'deal-sort-description', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>5) ); ?>  
            </div>
            <div id="postdivrich" class="postarea">
                <label for="description"><h3><?php _e('Description', 'enmassetxt'); ?></h3></label>
                <?php wp_editor(stripslashes(isset($_SESSION['data'])?$_SESSION['data']['description']:$deal->description), 'deal-description', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>10) ); ?>
            </div>  
            <div id="postdivrich" class="postarea">
                <label for="highlights"><h3><?php _e('Hightlights', 'enmassetxt'); ?></h3></label>
                <?php wp_editor(stripslashes(isset($_SESSION['data'])?$_SESSION['data']['highlight']:$deal->highlight), 'deal-highlights', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>5) ); ?>
            </div> 
            <div id="postdivrich" class="postarea">
                <label for="terms"><h3><?php _e('Terms', 'enmassetxt'); ?></h3></label>
                <?php wp_editor(stripslashes(isset($_SESSION['data'])?$_SESSION['data']['terms']:$deal->terms), 'deal-terms', array('dfw' => true, 'tabindex' => 1,'textarea_rows'=>5) ); ?>
            </div>         
            </div> 
    </div>
    </div>    
    </form>           
</div>