<div class="wrap">
	<h2><?php _ex("Email Template","EmailTemplate EmailTemplates");?>
    </h2>
     <?php 
		if(!empty($email_tmps))
		{	?>
			<table class="wp-list-table widefat" cellspacing="0">
			<thead>
                <th scope="col" class="manage-column column-cb check-column" ><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc"><a href="#"><span><?php _e('Slug Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Subject','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Available Attribute','enmassetxt') ?></th>
			</thead>
            <tfoot>
                <th scope="col" class="manage-column column-cb check-column"><input type="checkbox"></th>
                <th scope="col" class="manage-column column-title sortable asc"><a href="#"><span><?php _e('Slug Name','enmassetxt') ?></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-tags"><?php _e('Subject','enmassetxt') ?></th>
                <th scope="col" class="manage-column column-date"><?php _e('Available Attribute','enmassetxt') ?></th>
			</tfoot>
			<tbody id="the-list">
            <?php
			$class = '';
			foreach($email_tmps as $email_tmp)
			{
				$class = ($class == 'alternate') ? '' : 'alternate';
			?>
            <tr id="pay-gty-<?php echo $email_tmp->id;?>" class="<?php echo $class; ?>">
				<th scope="row" class="check-column"><input type="checkbox" name="id[]" value="<?php echo $email_tmp->id;?>"></th>
				<td class="column-title"><a href="admin.php?page=enmasse_emailtemplate&action=edit&id=<?php echo $email_tmp->id;?>" title="Edit this item" class="row-title"><strong><?php echo $email_tmp->slug_name; ?></strong></a>
                <div class="row-actions"><span class='edit'><a href="admin.php?page=enmasse_emailtemplate&action=edit&id=<?php echo $email_tmp->id;?>" title="Edit this item">Edit</a></span></div></td>
                <td class="column-tags" ><?php echo $email_tmp->subject; ?></td>
                <td class="column-tags"><?php echo $email_tmp->avail_attribute; ?></td>
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
        	<p><?php _e("There are no Email Templates in the database yet","enmassetxt"); ?></p>
     	<?php
		}
	?>
</div>