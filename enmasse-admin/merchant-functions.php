<?php
function merchant_google_meta_box () {
	global $mer;
?>

<div>
	<div id="minor-publishing">
    	<div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                	<label for="mer-google-map-width"><?php _e('Display Width', 'enmassetxt'); ?></label>
                </span>
                <span class="form-input-right">
                    <input name="mer-google-map-width" id="mer-google-map-width" type="text" <?php if($_GET['action']=="edit") {?> value="<?php echo $mer->google_map_width ?>" <?php } ?> size="5" />
                </span>
                <div class="clear"></div>
            </div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
               <span>
                <label for="mer-google-map-height"><?php _e('Display Height', 'enmassetxt'); ?></label>
                </span>
                <span class="form-input-right">
                    <input name="mer-google-map-height" id="mer-google-map-height" type="text" <?php if($_GET['action']=="edit") {?> value="<?php echo $mer->google_map_height ?>" <?php } ?> size="5" />
                </span>
               	<div class="clear"></div>
            </div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section misc-pub-section-last">
                <span>
                    <label for="mer-google-map-zoom"><?php _e('Display Zoom', 'enmassetxt'); ?></label>
                </span>
                <span class="form-input-right">
                    <input name="mer-google-map-zoom" id="mer-google-map-zoom" type="text" <?php if($_GET['action']=="edit") {?> value="<?php echo $mer->google_map_zoom ?>" <?php } ?> size="5" />
                </span>
                <div class="clear"></div>
            </div>            
        </div>
    </div>
</div>  
<?php }

function merchant_publish_meta_box(){
	global $mer;
?>
<script>
	jQuery(function() {
		jQuery("#mer-user-id").autocomplete({
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
			open: function() {
				jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	});
</script>	
<div>
	<div id="minor-publishing">
    	<div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
		        	<label for="mer-sale-person-id"><?php _e('Sale Person', 'enmassetxt'); ?></label>
		        </span>
		        <span class="form-input-right">
		        	<select name="mer-sale-person-id">
		            	<option value="0">None</option>
		                <?php enmasse_dropdown_sale_person($mer->sales_person_id);?>
		            </select>
		        </span>
                <div class="clear"></div>
            </div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section misc-pub-section-last">
                <span>
					<label for="mer-user-id"><?php _e('Username', 'enmassetxt'); ?></label>
				</span>
				<span class="form-input-right">
                	<?php if ($mer->uname):?>
                    	<strong><?php echo $mer->uname;?></strong>
                    <?php else:?>
                	<div class="ui-widget form-field form-required">
					<input autocomplete ="off" type="text" name="mer-user-id" id="mer-user-id" size="25" aria-required="true" />     
                    </div>              
                	<a href="user-new.php" target="_blank"><?php _ex('Add new user', 'Add new user'); ?></a><br /><br />
                    <?php endif;?>
                    <div class="clear"></div>
				</span>                
            </div>
       		<div class="clear"></div>
        </div>
     </div>
  </div>
<?php } ?>