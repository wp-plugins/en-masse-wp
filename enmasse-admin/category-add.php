<div class="wrap">
    <h2>Add New Category</h2>
    <?php
		if ( isset($_REQUEST['message'])) {
			$messages[] = $_REQUEST['message'];
			unset($_REQUEST['message']);
			?>
            <div id="message" class="updated"><p>
            <?php if ( $messages )
				echo join( ' ', $messages );
				unset( $messages );
            ?>
			</p></div>
            <?
		}else if( isset($_REQUEST['added']) && (int) $_REQUEST['added'] ) {
			$messages[] = sprintf( _n( '%s category added.', '%s categories added.', $_REQUEST['added'] ), number_format_i18n( $_REQUEST['added']) );
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
    <div class="form-wrap">
    <form id="addtag" method="post" action="admin.php?page=enmasse_category&action=add&noheader=true" class="validate">
    <div class="form-field form-required">
        <label for="cat-name"><?php _e('Name','enmassetxt') ?></label>
        <input name="cat-name" id="cat-name" type="text" value="" size="40" aria-required="true" />
        <p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
    </div>
    <!--
    <div class="form-field">
        <label for="cat-slug"><?php _e('Slug', 'enmassetxt'); ?></label>
        <input name="slug" id="cat-slug" type="text" value="" size="40" />
        <p><?php _e('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?></p>
    </div>
    -->
    <div class="form-field">
        <label for="parent"><?php _e('Parent', 'enmassetxt'); ?></label>
        	<select name="cat-parent">
            	<option value="0">None</option>
                <?php enmasse_dropdown_cat();?>
            </select>
            <p><?php _e('Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.'); ?></p>
    </div>
    <div class="form-field">
        <label for="cat-description"><?php _e('Description', 'enmassetxt'); ?></label>
        <textarea name="cat-description" id="cat-description" rows="5" cols="40"></textarea>
        <p><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>
    </div>
    
    <?php
    submit_button("Save", 'button' );
    ?>
    </form></div>            
</div>