<div class="wrap">
    <h2>Edit Location</h2>
    <?php
    	if ( isset($_REQUEST['updated']) && (int) $_REQUEST['updated'] ) {
			$messages[] = sprintf( _n( '%s order updated.', '%s locations updated.', $_REQUEST['updated'] ), number_format_i18n( $_REQUEST['updated']) );
			unset($_REQUEST['updated']);
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
    <div class="form-wrap">
    <form id="addtag" method="post" action="admin.php?page=enmasse_order&action=edit&id=<?php echo $order->id; ?>&noheader=true" class="validate">
    <div class="form-field">
        <label for="description"><?php _e('ID','enmassetxt') ?>: <?php echo $order->id;?></label>
  		<input type="hidden" name="orderID" id="orderID" value="<? echo $order->id;?>"  />
    </div>
    <div class="form-field">
        <label for="order-description"><?php _e('Description : ', 'enmassetxt'); ?></label>
        <textarea name="order-description" id="order-description" rows="5" cols="40"></textarea>
    </div>
    <div class="form-field">
        <label for="order-description"><?php _e('Deal Name: ', 'enmassetxt');_e($order->deal_name,'enmassetxt'); ?></label>
        <input type="hidden" id="deal-id" name="deal-id" value="<? echo $order->deal_id?>" />
    </div>
    <div class="form-field">
        <label for="order-description"><?php _e('Quantity: ', 'enmassetxt');_e($order->unit_qty,'enmassetxt'); ?></label>
        <input type="hidden" id="unit_qty" name="unit_qty" value="<? echo $order->unit_qty?>" />
    </div>
    <?php
    	$user = get_userdata($order->buyer_id);
     ?>
    <div class="form-field">
        <label for="order-description"><?php _e('Buyer Detail: ', 'enmassetxt'); ?></label>
        <p>Email:<?php _e($user->user_email, 'enmassetxt'); ?> </p>
        <p>Name:<?php _e($user->user_nicename, 'enmassetxt'); ?></p>
        <p>Date Ordered:<?php _e($order->created_at, 'enmassetxt'); ?></p>
        
    </div>
    <div class="form-field">
        <label for="order-description"><?php _e('Payment Detail: ', 'enmassetxt');_e($order->pay_name, 'enmassetxt'); ?></label>
        
    </div>
    
    <div >
        <label for="order-description"><?php _e('Status:', 'enmassetxt');_e($order->status, 'enmassetxt'); ?></label>
        <style>
        	input[type="radio"] {
    		margin: 0 10px 0 5px;
		}
        </style>
        <?php
        	$html = getStatusButton($order->status);
        	echo $html;
         ?>
    </div>
    <?php
    	submit_button("Save Order", 'button' );
    ?>
    </form></div>            
</div>