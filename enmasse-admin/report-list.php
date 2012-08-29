<?
$actions = array();
$actions['delete'] = __( 'Delete Permanently' );
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;

?>	
<script type="text/javascript">
				jQuery(document).ready(function (){ 
	
					jQuery("#calendar1, #calendar2").calendar();
	
					jQuery("#calendar1_alert").click(function(){alert(popUpCal.parseDate(jQuery('#calendar1').val()))});
	
				});
	</script>
<div class="wrap">
    <h2><?php _ex('Commision Report', 'Commision Report'); ?>
    </h2>
    <style>
		select {width:auto !important;}
	</style>
  	<div class="">
           <form id="searchForm" action="admin.php?page=enmasse_report&action=search" method="post"  >
           	<?php $filter = $_POST['filter'];	?>
			<table >
				<tr>
					<td>
					<label for="filter[dealcode]"><?php _e("Deal Code:");?></label>
					<input type="text" value="<?php echo $filter['code']; ?>" name="filter[dealcode]">
					<label for="filter[name]"><?php _e("Deal Name:"); ?></label>
					<input type="text" value="<?php echo $filter['dealname']; ?>" id="filterName" name="filter[dealname]">
					<b>Sale Person: </b>
					<select name="filter[saleperson_id]" id="filtersaleperson_id">
						<option value="" >--ALL--</option>
						<?php enmasse_dropdown_sale_person($filter['saleperson_id']); ?>
					</select>
					<b>Merchant: </b>
					<select name="filter[merchant_id]" id="filtermerchant_id">
					<option value="" >--ALL--</option>
						<?php enmasse_dropdown_merchant($filter['merchant_id']); ?>
					</select>
					<b>From date: </b><input type="text" readonly="readonly" value="<?php if($filter['fromdate']) { echo dateFormat($filter['fromdate'],"d/m/Y H:i:s A"); }  ?>" id="calendar1" name="filter[fromdate]" title=""><b>To date: </b>
					<input type="text" readonly="readonly" value="<?php if($filter['todate']) { echo dateFormat($filter['todate'],"d/m/Y H:i:s A");  } ?>" id="calendar1" name="filter[todate]" title="">
					</td>
				</tr>
				<tr>
					<td align="right">
					
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
                <th scope="col" class="manage-column column-tags"><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Deal Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Sale Person','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Merchant','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Quantity Sold','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Unit Price','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Total Sales','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-categories"><?php _e('Commission Percentage','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Total Commission Amount','enmassetxt') ?></th>
			</thead>
			 <?php
           
            if( !empty($reports))
            		{	?>
            <tfoot>
                <th scope="col" class="manage-column column-tags"><?php _e('Deal Code','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Deal Name','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Sale Person','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Merchant','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Quantity Sold','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Unit Price','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Total Sales','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-categories"><?php _e('Commission Percentage','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Total Commission Amount','enmassetxt') ?></th>
			</tfoot>
			<?php } ?>
			<tbody id="the-list">
            <?php
           
            if( !empty($reports))
            {
	            $total_commission_amount = 0;
				$class = '';
				
			foreach($reports as $report)
			{
				$total_sales = $report->price * $report->cur_sold_qty;
				$total_amount = ($total_sales * $report->commission_percent) / 100;
			$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr>
				<td class="column-title"><?php  echo $report->deal_code;?></td>
				<td class="column-title" title="<?php echo $report->name; ?>" ><?php echo cutWordByChar($report->name,4); ?></td>
				<td class="column-title"><?php echo $report->sale_name; ?></td>
				<td class="column-title"><?php echo $report->merchant_name; ?></td>
                <td class="column-title"><?php echo $report->cur_sold_qty; ?></td>
                <td class="column-title"><?php echo $report->price; ?></td>
                <td class="column-title"><?php echo $total_sales; ?></td>
                <td class="column-title"><?php echo $report->commission_percent; ?></td>
                <td class="column-title"><?php echo $total_amount; ?></td>
                
			</tr>
            <?php
            $total_commission_amount = $total_commission_amount + $total_amount;
			} 
			
			}
			if($total_commission_amount > 0) {
			 ?>
			
			<tr>
				<td style="text-align: right"  colspan="8" >
					Total:
				</td>
				<td  >
					<?php echo $total_commission_amount; ?>
				</td>
			</tr>
			<?php } ?>
            </tbody></table>
           
		 <div class="tablenav ">
		 <?php if( !empty($reports)) { ?>
		 	<div class="alignleft actions" >
		 		<a href="admin.php?page=enmasse_report&action=pdf&noheader=true" style="cursor:pointer;"><img alt="" src="<?=plugins_url(). '/' .plugin_basename(dirname(__FILE__))?>/images/admin/IconPDF.png"></a>
		 		<a href="admin.php?page=enmasse_report&action=excel&noheader=true"  style="cursor:pointer;" href="#" style="cursor: default;"><img alt="" src="<?=plugins_url(). '/' .plugin_basename(dirname(__FILE__))?>/images/admin/excel_icon.gif"></a>
		 	</div>
		 	<?php } ?>
            <div class='tablenav-pages'>
            <?php echo $paging;  ?>
            </div>
            <br class="clear" />
        </div>   
	
</div>