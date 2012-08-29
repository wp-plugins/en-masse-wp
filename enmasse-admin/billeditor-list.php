<div class="wrap">
	<h2><?php _ex("Bill Template","BillTemplate BillTemplates");?></h2>
    
     <?php 
		if(!empty($bills))
		{	?>    
			<table class="wp-list-table widefat" cellspacing="0">
			<thead>
                <th scope="col" class="manage-column column-cb check-column" ><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc" style="width:500px; text-align:left"><a href="#"><span><?php _e('Template Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Available Attributes','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"></th>
			</thead>
            <tfoot>
                <th scope="col" class="manage-column column-cb check-column" ><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc" style="width:500px; text-align:left"><a href="#"><span><?php _e('Template Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Available Attributes','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"></th>
			</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($bills as $bill)
			{
				$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="bill-<?php echo $bill->id;?>" class="<?php echo $class; ?>">
				<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $bill->id;?>"></th>
				<td class="column-title">
					<a href="admin.php?page=enmasse_billeditor&action=edit&id=<?php echo $bill->id;?>" title="Edit this item" class="row-title"><strong><?php echo $bill->slug_name; ?></strong></a>
					<div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_billeditor&action=edit&id=<?php echo $bill->id;?>" title="Edit this item">Edit</a></span></div>
                </td>				
                <td class="column-atribute"><?php echo $bill->avail_attribute; ?></td>
				<td class="column-preview"><a href="admin.php?page=enmasse_billeditor&action=preview&noheader=true" class="row-title"><strong>Preview</strong></a></td>
			</tr>
            <?php
			}
			?>
            </tbody></table>
        
	 	<?php 
	 	}
		else
		{
		?>
        	<p><?php _e("There are no Bill Templates in the database yet","enmassetxt"); ?></p>
     	<?php
		}
	?>
</div>