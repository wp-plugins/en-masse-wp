<div class="wrap">
    <h2>Add New Location</h2>
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
		}else if ( isset($_REQUEST['added']) && (int) $_REQUEST['added'] ) {
			$messages[] = sprintf( _n( '%s location added.', '%s locations added.', $_REQUEST['added'] ), number_format_i18n( $_REQUEST['added']) );
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
    <form id="addtag" method="post" action="admin.php?page=enmasse_location&action=add&noheader=true" class="validate">
    <div class="form-field form-required">
        <label for="loc-name"><?php _e('Name','enmassetxt') ?></label>
        <input name="loc-name" id="loc-name" type="text" value="" size="40" aria-required="true" />
        <p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
    </div>
    <!--
    <div class="form-field">
        <label for="loc-slug"><?php _e('Slug', 'enmassetxt'); ?></label>
        <input name="slug" id="loc-slug" type="text" value="" size="40" />
        <p><?php _e('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?></p>
    </div>
    -->
    <div class="form-field">
        <label for="parent"><?php _e('Parent', 'enmassetxt'); ?></label>
        	<select name="loc-parent">
            	<option value="0">None</option>
                <?php enmasse_dropdown_loc();?>
            </select>
            <p><?php _e('Categories, unlike tags, can have a hierarchy. You might have a Jazz Location, and under that have children categories for Bebop and Big Band. Totally optional.'); ?></p>
    </div>
    <div class="form-field">
        <label for="loc-description"><?php _e('Description', 'enmassetxt'); ?></label>
        <textarea name="loc-description" id="loc-description" rows="5" cols="40"></textarea>
        <p><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>
    </div>
    
    <?php
    submit_button("", 'button' );
    ?>
    </form></div>            
</div>