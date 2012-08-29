<?php
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;
?>
<div class="wrap">
	<h2><?php _ex("Payment Gateway","PaymentGateway PaymentGateways");?> <a href="admin.php?page=enmasse_paymentgateway&action=add" class="add-new-h2"><?php _ex('Add new','Add new payment gateway'); ?></a>
    </h2>
    <?php
		if ( isset($_REQUEST['deleted']) && (int) $_REQUEST['deleted'] ) {
			$messages[] = sprintf( _n( 'Item permanently deleted.', '%s items permanently deleted.', $_REQUEST['deleted'] ), number_format_i18n( $_REQUEST['deleted'] ) );
			unset($_REQUEST['deleted']);
			?>
            <div id="message" class="updated"><p>
            <?php 
				if ( $messages )
				echo join( ' ', $messages );
				unset( $messages );
            ?>
			</p></div>
            <?php
		}
	?> 
    <form action="admin.php" onsubmit="return confirm('<?php _e('Are you sure you want to delete selected of payment gateways?','enmassetxt'); ?>')">
    <input type="hidden" name="page" value="enmasse_paymentgateway" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="noheader" value="true" />
     <?php 
		if(!empty($pay_gtys))
		{	?>
        <div class="tablenav <?php echo esc_attr('top'); ?>">
            <div class="alignleft actions">
                <?php $wp_list_table->bulk_actions('top'); ?>
            </div>
            <br class="clear" />
        </div>    
			<table class="wp-list-table widefat" cellspacing="0">
			<thead>
                <th scope="col" class="manage-column column-cb check-column" ><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc" style="width:500px; text-align:left"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Published','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Updated at','enmassetxt') ?></th>
			</thead>
            <tfoot>
                <th scope="col" class="manage-column column-cb check-column"><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc" style="width:500px; text-align:left"><a href="#"><span><?php _e('Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Published','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Updated At','enmassetxt') ?></th>
			</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($pay_gtys as $pay_gty)
			{
				$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="pay-gty-<?php echo $pay_gty->id;?>" class="<?php echo $class; ?>">
				<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $pay_gty->id;?>"></th>
				<td class="column-title"><a href="admin.php?page=enmasse_paymentgateway&action=edit&id=<?php echo $pay_gty->id;?>" title="Edit this item" class="row-title"><strong><?php echo $pay_gty->name; ?></strong></a>
                <div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_paymentgateway&action=edit&id=<?php echo $pay_gty->id;?>" title="Edit this item">Edit</a> | </span><span class='trash'><a class='submitdelete' title='Delete Permanently this item' href='admin.php?page=enmasse_paymentgateway&action=delete&id=<?php echo $pay_gty->id;?>&noheader=true' onclick="return confirm('<?php _e('Are you sure you want to delete this payment gateway?','enmassetxt'); ?>')">Delete</a></span></div>
                </td>                <td class="column-tags"><?php 1 == $pay_gty->published ? _e("Yes","enmassetxt") : _e("No","enmassetxt") ?></td>
                <td class="column-date"><?php echo $pay_gty->updated_at; ?></td>
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
        	<p><?php _e("There are no Payment Gateways in the database yet","enmassetxt"); ?></p>
     	<?php
		}
	?>
</div>