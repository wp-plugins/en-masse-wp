<?php
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;
?>	
<div class="wrap">
    <h2><?php _ex('Orders', 'Order Deals'); ?> </h2>
    <div class="tablenav">
    <form action="admin.php?page=enmasse_order&action=search" method="post">
			<table>
				<tbody><tr>
					<td>
				<div style="float: left; margin-right: 10px;">
					<?php $filter = $_POST['filter'];?>
					<b>Status: </b>
					<select name="filter[status]" id="filterstatus">
						<option <?php if(empty($filter['status'])) { ?> selected="selected" <?php } ?> value="">--- All ---</option>
						<option <?php if($filter['status'] == "Error") { ?> selected="selected" <?php } ?> value="Error">Error</option>
						<option <?php if($filter['status'] == "Cancelled") { ?> selected="selected" <?php } ?> value="Cancelled">Cancelled</option>
						<option <?php if($filter['status'] == "Pending") { ?> selected="selected" <?php } ?> value="Pending">Pending</option>
						<option <?php if($filter['status'] == "Unpaid") { ?> selected="selected" <?php } ?> value="Unpaid">Unpaid</option>
						<option <?php if($filter['status'] == "Paid") { ?> selected="selected" <?php } ?> value="Paid">Paid</option>
						<option <?php if($filter['status'] == "Delivered") { ?> selected="selected" <?php } ?> value="Delivered">Delivered</option>
						<option <?php if($filter['status'] == "Refunded") { ?> selected="selected" <?php } ?> value="Refunded">Refunded</option>
						<option <?php if($filter['status'] == "Waiting for refund") { ?> selected="selected" <?php } ?> value="Waiting_For_Refund">Waiting for refund</option>
						<option <?php if($filter['status'] == "Cancel") { ?> selected="selected" <?php } ?> value="Cancel">Cancel</option>
					</select>
				</div>
						<div style="float: left; margin-right: 10px;">
							<b>Deal Code</b>
							<input type="text" value="<?php _e($filter['dealcode']) ?>" name="filter[dealcode]">
						</div>
						<div style="float: left; margin-right: 10px;">
							<b>Deal Name</b>
							<input type="text" value="<?php _e($filter['dealname']) ?>" name="filter[dealname]">
						</div>
						<input type="submit" value="Search">
						<input type="reset" onclick="resetSearchField();" value="Reset">
					</td>
				</tr>
			</tbody>
			</table>
	</form>
	</div>
    <form action="admin.php">
    <?php		
		if( !empty($orders))
		{	?>
        <div class="tablenav <?php echo esc_attr('top'); ?>">
           <?php  $wp_list_table->search_box('Deal Name', 'search') ?>
        </div>
			<table class="wp-list-table widefat fixed posts" cellspacing="0">
			<thead>
                <th width="10%" align ="center" scope="col" class="manage-column"><?php _e('Order ID','enmassetxt') ?></th>
                <th width="10%" align ="center" scope="col" class="manage-column"><?php _e('Total Paid','enmassetxt') ?></th>
                <th width="10%"  align ="center" scope="col" class="manage-column column-Deals"><?php _e('Deal Code','enmassetxt') ?></th>
                <th  width="20%" align ="center" scope="col" class="manage-column column-date"><?php _e('Deal Name','enmassetxt') ?></th>
                <th width="5%" align ="center" scope="col" class="manage-column column-date"><?php _e('Quantity','enmassetxt') ?></th>
                <th width="10%" align ="center" scope="col" class="manage-column column-date"><?php _e('Buyer Detail','enmassetxt') ?></th>
                <th width="10%" align ="center" scope="col" class="manage-column column-date"><?php _e('Payment Detail','enmassetxt') ?></th>
                <th width="5%" align ="center" scope="col" class="manage-column column-date"><?php _e('Status','enmassetxt') ?></th>
                <th width="20%" align ="center" scope="col" class="manage-column column-date"><?php _e('Created At','enmassetxt') ?></th>
           </thead>
            <tfoot>               
                <th scope="col" align ="center"  class="manage-column "><?php _e('Order ID','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column "><?php _e('Total Paid','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-Deals"><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-date"><?php _e('Deal Name','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-date"><?php _e('Quantity','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-date"><?php _e('Buyer Detail','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-date"><?php _e('Payment Detail','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-date"><?php _e('Status','enmassetxt') ?></th>
                <th scope="col" align ="center" class="manage-column column-date"><?php _e('Created At','enmassetxt') ?></th>               
        	</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($orders as $order)
			{
				$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="order-<?php echo $order->id;?>" class="<?php echo $class; ?>">
				<td class="column-title"><a href="admin.php?page=enmasse_order&action=edit&id=<?php echo  $order->id;?>" title="Edit this item" class="row-title"><strong><?php echo displayOrderDisplayId($order->id); ?></strong></a>
                <div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_order&action=edit&id=<?php echo $order->id;?>" title="Edit this item">Edit</a>  </span></div>
                </td>
                <td class="column-amount" align ="center" ><?php echo $order->_amount; ?></td>
                <td class="column" align ="center" ><?php echo $order->deal_code; ?></td>
                <td class="column" title ="<?php echo $order->deal_name;  ?>" ><?php echo cutWordByChar($order->deal_name,4); ?></td>
                <td class="column" align ="center" ><?php echo $order->unit_qty;?></td>
                <?php
    				$user = get_userdata($order->buyer_id);
     			?>
                <td class="column" align ="center" style="width:100%" ><?php echo $user->user_nicename."</br>(".$user->user_email.")"; // Buyer deatil ?></td>
                <td class="column" align ="center" ><?php echo  $order->pay_name; // Payment deatil ?></td>
                <td class="column" align ="center"><?php echo $order->status; ?></td>
                <td class="column" align ="center" ><?php echo $order->created_at; ?></td>                
			</tr>
            <?php
			}
			?>
            </tbody></table>
        <div class="tablenav <?php echo esc_attr('bottom'); ?>">
           
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
        	<p><?php _e("There are no order in the database yet!", 'enmassetx');?></p>
        <?php
		}
	?>
</div>