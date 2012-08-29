<?php
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;
?>	
<script>
jQuery(document).ready(function(){
		jQuery('#change_satus').unbind('click').bind('click', function(e) {
				if(jQuery('#the-list input:checked').length == 0){
					alert("Please check at least a deal");
					return false;
				}
				else if(jQuery('#dealstatus option:selected').val() == "DealStatus")
				{
					alert("Please select a status of deal");
					return false;
				}
				
				return confirm('<?php _e('Are you sure you want to change status of Deals?','enmassetxt'); ?>')
			});
		jQuery('#doaction2').unbind('click').bind('click', function(e) {
			return confirm('<?php _e('Are you sure you want to delete Deals?','enmassetxt'); ?>')
		});
	});	
</script>
<div class="wrap">
    <h2><?php _ex('Deals', 'Deal Deals'); ?> <a href="admin.php?page=enmasse_deal&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new category'); ?></a>
    </h2>
    <?php
		if ( isset($_REQUEST['deleted']) && (int) $_REQUEST['deleted'] ) {
			$messages[] = sprintf( _n( 'Item permanently deleted.', '%s items permanently deleted.', $_REQUEST['deleted'] ), number_format_i18n( $_REQUEST['deleted'] ) );
			unset($_REQUEST['deleted']);
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
    <form action="admin.php?page=enmasse_deal" >
    <input type="hidden" name="page" value="enmasse_deal" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="noheader" value="true" />
    <?php		
		if( !empty($deals))
		{	?>
        <div class="tablenav <?php echo esc_attr('top'); ?>">
            <div class="alignleft actions">
                <?php $wp_list_table->bulk_actions('top'); ?>
            </div>
            <div class="alignleft actions" >
	            	<label for="dealstatus"><?php _e('Deal Status: ') ?></label>
	            	<select id = "dealstatus" name="dealstatus">
	            	<?php enmmasse_dropdow_deal_status(); ?>
	            	</select>
	            	<input type="submit"  value="Change Status" class="button-secondary action" id="change_satus" name="change_satus">
	        </div>
            <br class="clear" />
        </div>    
			<table class="wp-list-table widefat fixed posts" cellspacing="0">
			<thead>
                <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                 <th scope="col" class="manage-column column-tags"><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Short Description','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Deals"><?php _e('Sale Person','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Deals"><?php _e('Status','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Date','enmassetxt') ?></th>
			</thead>
            <tfoot>
                <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable desc"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Deals"><?php _e('Short Description','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Sale Person','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Deals"><?php _e('Status','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Date','enmassetxt') ?></th>
                
			</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($deals as $deal)
			{
				$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="cat-<?php echo $deal->id;?>" class="<?php echo $class; ?>">
				<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $deal->id;?>"></th>
				<td class="column-title"><a href="admin.php?page=enmasse_deal&action=edit&id=<?php echo $deal->id;?>" title="Edit this item" class="row-title"><strong><?php echo $deal->name; ?></strong></a>
                <div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_deal&action=edit&id=<?php echo $deal->id;?>" title="Edit this item">Edit</a> | </span><span class='trash'><a class='submitdelete' title='Delete Permanently this item' href='admin.php?page=enmasse_deal&action=delete&id=<?php echo $deal->id;?>&noheader=true' onclick="return confirm('<?php _e('Are you sure you want to delete this deal?','enmassetxt'); ?>')">Delete</a></span></div>
                </td>
                <td class="column-tags"><?php echo $deal->deal_code; ?></td>
                <td class="column-tags"><?php echo $deal->short_desc; ?></td>
                <td class="column-Deals"><?php if ($deal->uname) echo $deal->uname; else _e('None','enmassetxt'); ?></td>
                <td class="column-tags"><?php echo $deal->status; ?></td>
                <td class="column-date"><?php echo date("Y-m-d H:i:s",strtotime($deal->updated_at)+7*3600) ?></td>
			</tr>
            <?php
			}
			?>
            </tbody></table>
        <div class="tablenav <?php echo esc_attr('bottom'); ?>">
            <div class="alignleft actions">
                <?php $wp_list_table->bulk_actions('bottom'); ?>
            </div>
            <div class='tablenav-pages'>
            <?php echo $paging;  ?>
            </div>
            <br class="clear" />
        </div>     
		<?php
        }
		else
		{
		?>
        	<p><?php _e("There are no Deals in the database yet!", 'enmassetx');?></p>
        <?php
		}
	?>
</div>