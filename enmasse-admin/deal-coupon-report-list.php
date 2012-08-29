<?
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;

?>	

    <h2><?php _ex('Commision Report', 'Commision Report'); ?>
    </h2>
    <style>
		select {width:auto !important;}
	</style>
  	<div class="">
           <form id="searchForm" action="admin.php?page=enmasse_dealReport&action=search" method="post"  >
           	<?php $filter = $_POST['filter']; 	?>
			<table >
				<tr>
					<td>
					
					<b><?php _e('Deal:'); ?></b>
					<select name="filter[deal_id]" id="deal_id">
						<option value="" ><?php _e('Pelase Select A Deal'); ?></option>
						<?php enmasse_dropdown_deal($filter['deal_id']); ?>
						</select>
						<input type="submit" value="Search" id="btnOk" name="ok">
						<input type="reset" value="Reset">			
						</td>
					</tr>
				</table>
				</form> 
	        </div>    
	    <form action="admin.php">
	    <input type="hidden" name="page" value="enmasse_category" />
	    <input type="hidden" name="action" value="delete" />
	    <input type="hidden" name="noheader" value="true" />
      		<table class="wp-list-table widefat fixed posts" cellspacing="0">
				<thead>
	            <th scope="col" class="manage-column column-tags"><?php _e('Buyer Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Buyer Email','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Sale Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Merchant Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Order Comment','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Purchase Date','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Coupon Serial','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Coupon Status','enmassetxt') ?></th>
           
           </thead>
			 <?php
           
            if( !empty($reports))
            		{	?>
            <tfoot>
                <th scope="col" class="manage-column column-tags"><?php _e('Buyer Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Buyer Email','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Sale Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Merchant Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Order Comment','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Purchase Date','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Coupon Serial','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Coupon Status','enmassetxt') ?></th>
			</tfoot>
			<?php } ?>
			<tbody id="the-list">
            <?php
           
            if( !empty($reports))
            {
	            $total_commission_amount = 0;
				$class = '';
				
			foreach($reports as $i => $report)
			{
			?>
            <tr>
            	<?php
            		$buyer =get_userdata($report->buyer_id);
             	?>
				<td class="column-title"><?php  _e( $buyer->user_nicename) ;?></td>
				<td class="column-title"><?php  _e( $buyer->user_email) ;?></td>
				<td class="column-title"><?php _e( $report->sale_name) ; ?></td>
				<td class="column-title"><?php _e( $report->merchant_name) ; ?></td>
                <td class="column-title"><?php _e( $report->comment) ; ?></td>
                <td class="column-title"><?php _e( dateFormat($report->purcharse_date,'d-m-Y')) ; ?></td>
                <td class="column-title"><?php _e( $report->coupon_serial) ; ?></td>
                <td class="column-title"><?php _e($report->coupon_status) ; ?></td>
    		</tr>
            <?php
			} }
			?>
          </tbody>
       </table>
        <div class="tablenav ">
		
            <div class='tablenav-pages'>
            <?php echo $paging;  ?>
            </div>
            <br class="clear" />
        </div>   
	
