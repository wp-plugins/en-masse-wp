<?php
$actions = array();
$wp_list_table = new WP_List_Table();
?>
<script>
	jQuery(document).ready(function(){
		jQuery('#changesatus').unbind('click').bind('click', function(e) {
			jQuery(.ajax({
				'url':'admin.php?page=enmasse_merchantsettlement&action=changestatus&noheader=true',
				'type':'POST',
				'data':jQuery('#mainForm').serialize(),
				'success': function(msg){
					window.location.href = "admin.php?page=enmasse_merchantsettlement";
					var url='admin.php?page=enmasse_merchantsettlement&action=dowload&noheader=true'; 
					window.open(url,'Download');
					}	
				});
			
	});
	});
</script>	
<div class="wrap">
    <h2><?php _ex('Merchant Settlement', 'Merchant Settlement'); ?> </h2>
  	  		 <style>
		select {width:auto !important;}
	</style>
  	<div class="">
           <form id="searchForm" action="admin.php?page=enmasse_merchantsettlement&action=search" method="post"  >
           	<?php  $filter = $_POST['filter'];	?>
			<table >
				<tr>
					<td>
					<label for="filter[code]"><?php _e("Merchant :");?></label>
					<select name="filter[merchant_id]" id="filtermerchant_id">
					<option value="" >--ALL--</option>
						<?php enmasse_dropdown_merchant($filter['merchant_id']); ?>
					</select>
					<label for="filter[code]"><?php _e("Deal :");?></label>
					<select name="filter[deal_id]" id="filtermerchant_id">
					<option value="" >--ALL--</option>
						<?php enmasse_dropdown_deal($filter['deal_id']); ?>
					</select>	
					<label for="set_status"><?php _e("Settlement Status :"); ?></label>
					<select name="filter[set_status]" id="set_status">
						<option value="" >--ALL--</option>
						<?php enmasse_dropdown_set_status($filter['set_status']); ?>
					</select>
					<input type="submit" value="Search" id="btnOk" name="ok">
					<input type="reset" value="Reset">
					</td>
				</tr>
				</table>
			</form> 
        </div>  
  	<form action="admin.php?page=enmasse_merchantsettlement&action=changestatus" method="post" id='mainForm' >  
			<table class="wp-list-table widefat fixed posts" cellspacing="0">
			<thead>
                <th scope="col"  class="manage-column column-cb check-column" scope ="col" style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column "><?php _e('Coupon ID','enmassetxt') ?></span><span class="sorting-indicator"></th>
                 <th scope="col" class="manage-column "><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" class="manage-column "><?php _e('Buyer Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Deals"><?php _e('Buyer Email','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Order Comment','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Purchase Date','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Coupon Price','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Coupon Serial','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Coupon Status','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Settlement Status','enmassetxt') ?></th>
			</thead>
            <tfoot>
              <?php		
			if( !empty($merchants))
			{	?>
                 <th scope="col"  class="manage-column column-cb check-column"style=""><input type="checkbox"></th>
                <th scope="col" class="manage-column "><a href="#"><span><?php _e('Coupon ID','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                 <th scope="col" class="manage-column "><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" class="manage-column "><?php _e('Buyer Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-Deals"><?php _e('Buyer Email','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Order Comment','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Purchase Date','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Coupon Price','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Coupon Serial','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Coupon Status','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Settlement Status','enmassetxt') ?></th>
               <?php } ?> 
			</tfoot>
			<tbody id="the-list">
            <?php
            if(! empty($merchants)) {
			$class = '';
			foreach($merchants as $merchant)
			{
				$class = ($class == 'alternate') ? '' : 'alternate';
				$buyer = get_userdata($merchant->buyer_id);
			?>
            <tr id="cat-<?php echo $deal->id;?>" class="<?php echo $class; ?>">
            	<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $merchant->coupon_id;?>"></th>
            	<td class="column-tags"><?php echo $merchant->coupon_id; ?></td>
			    <td class="column-tags"><?php echo $merchant->deal_code; ?></td>
                <td class="column-tags"><?php echo $buyer->user_nicename; ?></td>
                <td class="column-tags"><?php echo $buyer->user_email; ?></td>
                <td class="column-tags"><?php echo $merchant->order_description; ?></td>
                <td class="column-tags"><?php echo dateFormat($merchant->created_at,'m-d-Y'); ?></br>(<?php echo dateFormat($merchant->created_at,'h:i:s A');  ?>)</td>
                <td class="column-tags"><?php echo $merchant->unit_price; ?></td>
                <td class="column-tags"><?php echo $merchant->coupon_serial; ?></td>
                <td class="column-tags"><?php echo $merchant->coupon_status; ?></td>
                <td class="column-date"><?php echo $merchant->coupon_settlement_status; ?></td>
			</tr>
            <?php
			}
            }
			else
			{
			?>
				<tr> <td colspan="11">
	        	<p><?php _e("There are no Deals in the database yet!", 'enmassetx');?></p>
	        	</td>
	        <?php
			} ?>
            </tbody></table>
        	<div class="tablenav <?php echo esc_attr('bottom'); ?>">
            <div class="alignleft actions">
            	<select name = 'status_action' >
                	<?php enmmasse_dropdow_setment_status();  ?>
                </select>
               	<input type="button" value="Change Status" class="button-secondary action" id="changesatus" name="changesatus">
            </div>
            <div class='tablenav-pages'>
            <?php echo $paging;  ?>
            </div>
            <br class="clear" />
        </div>   
		
</div>

