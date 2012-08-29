<div class="wrap">
    <h2><? _e('Edit Sale Person','enmassetxt') ?><a href="admin.php?page=enmasse_saleperson&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new saleperson'); ?></a></h2>
   <?php
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
    	
		} else if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) 
		{
			$num = $_REQUEST['updated'];
			$messages[] = sprintf( _n( '%d sale person updated.', '%d sale person updated.', $num ), number_format_i18n($num) );
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
    <div class="form-field">
        <h2><?=$sale->user_login?></h2>
        <p><?=$sale->user_email?></p>
    </div>
    <form id="addtag" method="post" action="admin.php?page=enmasse_saleperson&action=edit&id=<?php echo $sale->id ?>&noheader= true" class="validate">
    <div class="form-field form-required">
        <label for="sale-name"><?php _e('Full Name','enmassetxt') ?></label>
        <input name="sale-name" id="sale-name" type="text" value="<?php echo $sale->name ?>" size="40" aria-required="true" />
        <p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
    </div>
    <div class="form-field">
        <label for="cat-description"><?php _e('Adress', 'enmassetxt'); ?></label>
        <textarea name="sale-address" id="sale-address" rows="5" cols="40"><?php echo $sale->address ?></textarea>
        <p><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>
    </div>
  <div class="form-field">
        <label for="sale-email"><?php _e('Email','enmassetxt') ?></label>
        <input name="sale-email" id="sale-email" type="text" value="<?php echo $sale->email ?>" size="40"  />
    </div>
    <div class="form-field">
        <label for="sale-phone"><?php _e('Phone','enmassetxt') ?></label>
        <input name="sale-phone" id="sale-phone" type="text" value="<?php echo $sale->phone ?>" size="40"  />
    </div>
    
    <?php
    	submit_button("", 'button' );
    ?>
    </form></div>            
</div>