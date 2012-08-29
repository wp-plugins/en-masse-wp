<div class="wrap">
    <h2>Add New Sale Person</h2>
    <style>
		.form-field input {width:inherit}
		.form-field input[type='checkbox'] {width:inherit}
		<?php global $fluginurl;?>
		.ui-autocomplete-loading { background: white url('<?=$fluginurl?>/enmasse-admin/images/ui-anim_basic_16x16.gif') right center no-repeat;}
	</style>
	<script>jQuery(function() {
			jQuery("#sale-user-id").autocomplete({
                source: function( request, response ) {		
                    jQuery.ajax({
                        url: "admin.php?page=enmasse_merchant&action=getuser&noheader=true&searchStr="+request.term,
                        dataType: "text json",
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(jqXHR.responseText);
                        }
                        ,
                        success: function( data ) {	
                            response( jQuery.map( data.users, function( item ) {
                                return {
                                    label: item.user_login+", "+item.display_email,
                                    value: item.user_login
                                }
                            }));
                        }
                    });
                },
                minLength: 2,
                open: function() {jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
        });
    </script>	    
    <?php
		if ( isset($_REQUEST['error'])) {
			$messages[] = $_REQUEST['error'];
			unset($_REQUEST['error']);
			?>
            <div id="message" class="updated"><p>
            <?php if ( $messages )
				echo join( ' ', $messages );
				unset( $messages );
            ?>
			</p></div>
            <?
		}else if ( isset($_REQUEST['added']) && (int) $_REQUEST['added'] ) {
			$num = $_REQUEST['added'];
			$messages[] = sprintf( _n( '%d sale person added.', '%d sale person added.', $num ), number_format_i18n($num) );
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
    <form id="addtag" method="post" action="admin.php?page=enmasse_saleperson&action=add&noheader=true" class="validate">
    <div class="form-field form-required">
        <label for="sale-name"><?php _e('Full Name','enmassetxt') ?></label>
        <input name="sale-name" id="sale-name" type="text" value="" size="40" aria-required="true" />
        <p><?php _e('The name is how it appears on your site.','enmassetxt'); ?></p>
    </div>
    <div class="form-field form-required">
        <label for="sale-user-id"><?php _e('Username','enmassetxt') ?></label>
        <div class="ui-widget">
        <input name="sale-user-id" id="sale-user-id" type="text" value="" size="40" autocomplete="off" aria-required="true" />
        </div>
        &nbsp;
        <a href="user-new.php" target="_blank"><?php _ex('Add new user', 'Add new user'); ?></a>
    </div>
    <div class="form-field">
        <label for="cat-description"><?php _e('Adress', 'enmassetxt'); ?></label>
        <textarea name="sale-address" id="sale-address" rows="5" cols="40"></textarea>
        <p><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>
    </div>
  <div class="form-field">
        <label for="sale-email"><?php _e('Email','enmassetxt') ?></label>
        <input name="sale-email" id="sale-email" type="text" value="" size="40"  />
    </div>
    <div class="form-field">
        <label for="sale-phone"><?php _e('Phone','enmassetxt') ?></label>
        <input name="sale-phone" id="sale-phone" type="text" value="" size="40"  />
    </div>
    <?php
    	submit_button("Save", 'button' );
    ?>
    </form></div>            
</div>