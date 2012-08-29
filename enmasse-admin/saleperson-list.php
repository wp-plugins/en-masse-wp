<?
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;
?>	
<div class="wrap">
    <h2><?php _ex('Sale Person', 'Sale Person'); ?> <a href="admin.php?page=enmasse_saleperson&action=add" class="add-new-h2"><?php _ex('Add new', 'Add new saleperson'); ?></a>
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
    <form action="admin.php" onsubmit="return confirm('<?php _e('Are you sure you want to delete selected of sale persons?','enmassetxt'); ?>')">
    <input type="hidden" name="page" value="enmasse_saleperson" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="noheader" value="true" />
    <?php		
		if( !empty($sales))
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
                <th scope="col" class="manage-column column-tags"><?php _e('Phone','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-categories"><?php _e('Email','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('User Name','enmassetxt') ?></th>
                 <th scope="col" class="manage-column column-date"><?php _e('Create At','enmassetxt') ?></th>
			</thead>
            <tfoot>
                <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Phone','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-categories"><?php _e('Email','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('User Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Create At','enmassetxt') ?></th>
			</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($sales as $sale)
			{
			$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="cat-<?php echo $cat->id;?>" class="<?php echo $class; ?>">
				<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $sale->id;?>"></th>
				<td class="column-title"><a href="admin.php?page=enmasse_saleperson&action=edit&id=<?php echo $sale->id;?>" title="Edit this item" class="row-title"><strong><?php echo $sale->name; ?></strong></a>
                	<div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_saleperson&action=edit&id=<?php echo $sale->id;?>" title="Edit this item">Edit</a> | </span><span class='trash'><a class='submitdelete' title='Delete Permanently this item' href='admin.php?page=enmasse_saleperson&action=delete&id=<?php echo $sale->id;?>&noheader=true' onclick="return confirm('<?php _e('Are you sure you want to delete this sale person?','enmassetxt'); ?>')">Delete</a></span></div>
                </td>
                <td class="column-phone"><?php echo $sale->phone; ?></td>
                <td class="column-email"><?php if ($sale->email) echo $sale->email; else _e('None','enmassetxt'); ?></td>
                <td class="column-username"><?php echo $sale->uname; ?></td>
                <td class="column-date"><?php echo $sale->updated_at; ?></td>
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
            	<?php echo $paging; ?>
            </div>
            <br class="clear" />
        </div>     
		<?php
        }
		else
		{
		?>
        	<p><?php _e("There are no sale persons in the database yet!", 'enmassetxt');?></p>
        <?php
		}
	?>
</div>
