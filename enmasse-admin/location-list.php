<?
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;
?>	
<div class="wrap">
    <h2><?php _ex('Locations', 'Deal Locations'); ?> <a href="admin.php?page=enmasse_location&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new category'); ?></a>
    </h2>
    <?php
		if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
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
    <form action="admin.php" onsubmit="return confirm('<?php _e('Are you sure you want to delete selected of Locations?','enmassetxt'); ?>')">
    <input type="hidden" name="page" value="enmasse_location" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="noheader" value="true" />
    <?php		
		if( !empty($locx))
		{	?>
        <div class="tablenav <?php echo esc_attr('top'); ?>">
            <div class="alignleft actions">
                <?php $wp_list_table->bulk_actions('top'); ?>
            </div>
            <br class="clear" />
        </div>        
			<table class="wp-list-table widefat fixed posts" cellspacing="0">
			<thead>
                <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Description','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Locations"><?php _e('Parent','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Date','enmassetxt') ?></th>
			</thead>
            <tfoot>
                <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable desc"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Description','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Locations"><?php _e('Parent','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Date','enmassetxt') ?></th>
			</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($locx as $loc)
			{
			$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="loc-<?php echo $loc->id;?>" class="<?php echo $class; ?>">
				<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $loc->id;?>"></th>
				<td class="column-title"><a href="admin.php?page=enmasse_location&action=edit&id=<?php echo $loc->id;?>" title="Edit this item" class="row-title"><strong><?php echo $loc->name; ?></strong></a>
                <div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_location&action=edit&id=<?php echo $loc->id;?>" title="Edit this item">Edit</a> | </span><span class='trash'><a class='submitdelete' title='Delete Permanently this item' href='admin.php?page=enmasse_location&action=delete&id=<?php echo $loc->id;?>&noheader=true' onclick="return confirm('<?php _e('Are you sure you want to delete this category?','enmassetxt'); ?>')">Delete</a></span></div>
                </td>
                <td class="column-tags"><?php echo $loc->description; ?></td>
                <td class="column-Locations"><?php if ($loc->pname) echo $loc->pname; else _e('None','enmassetxt'); ?></td>
                <td class="column-date"><?php echo $loc->updated_at; ?></td>
			</tr>
            <?php
			}
			?>
            </tbody></table>
            <div class="tablenav <?php echo esc_attr('bottom'); ?>">
                <div class="alignleft actions">
                    <?php $wp_list_table->bulk_actions('bottom'); ?>
                </div>
                <br class="clear" />
            </div>    
            
		<?php
        }
		else
		{
		?>
        	<p><?php _e("There are no Locations in the database yet!", 'enmassetx');?></p>
        <?php
		}
	?>
</div>