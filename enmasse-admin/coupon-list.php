<?php
$actions = array();
$wp_list_table = new WP_List_Table();
$wp_list_table->_actions = $actions;
?>
<div class="wrap">
  <?php			
		if(isset($_REQUEST['message'])){
			$messages = $_REQUEST['message'];
		
			unset($_REQUEST['message']);
			?>
            <div id="message" class="updated"><p>
            <?php if ( $messages )
				if(is_array($messages)) 
				{
					echo join( ' ', $messages );
            	}	
            	else 
            	{
            		echo $messages;
            	}
				unset( $messages );
            ?>
			</p></div>
            <?
		}?>
	<h2><?php _ex("Coupon Editor","CouponEditor CouponEditors");?></h2>
	<form id="addtag" class="validate" method="post" action="admin.php?page=enmasse_couponeditor&noheader=true">
		<input type="hidden" name="page" value="enmasse_couponeditor" />
		<input type="hidden" name="action" value="delete" />
		<input type="hidden" name="noheader" value="true" />
		<tbody id="the-list">
			<table border="0">
				<tr>
					<th><?php _e('Name','enmassetxt')?></th>
					<th><?php _e('X Point','enmassetxt')?></th>
					<th><?php _e('Y Point','enmassetxt')?></th>
					<th><?php _e('Width','enmassetxt')?></th>
					<th><?php _e('Height','enmassetxt')?></th>
					<th><?php _e('Font Size','enmassetxt')?></th>
				</tr>				
					<?php
						$class = '';
						$i=1;
						foreach($coupons as $coupon)
						{							
						?>
							<tr>
								<td><label for="cp-name"><?php echo $coupon->name ?></label></td>
								<td><input name="cp-x<?php echo $i ?>" id="cp-x<?php echo $i ?>" type="text" value="<?php echo $coupon->x ?>" size="20"/></td>
								<td><input name="cp-y<?php echo $i ?>" id="cp-y<?php echo $i ?>" type="text" value="<?php echo $coupon->y ?>" size="20"/></td>
								<td><input name="cp-width<?php echo $i ?>" id="cp-width<?php echo $i ?>" type="text" value="<?php echo $coupon->width ?>" size="20"/></td>
								<td><input name="cp-height<?php echo $i ?>" id="cp-height<?php echo $i ?>" type="text" value="<?php echo $coupon->height ?>" size="20"/></td>
								<td><input name="cp-font_size<?php echo $i ?>" id="cp-font_size<?php echo $i ?>" type="text" value="<?php echo $coupon->font_size ?>" size="20"/></td>
							</tr>
						<?php
							$i++;
						}
					?>
			</table>
			<?php
				submit_button("", 'button' );
			?>
		</tbody>
	</form>
	<form method="post" action="admin.php?page=enmasse_couponeditor&action=upload&noheader=true" enctype="multipart/form-data">
		<label for ="async-upload"><?php _e('Upload your coupon image'); ?></label>
		<input type="file" id="async-upload" name="async-upload">
		<input type="submit" value="Upload" class="button" id="html-upload" name="html-upload">
	</form>
	<form>
			
		
		<div id="divToPrint" class="demo">
				<img src="<?php form_option('coupon_bg_url'); ?>">
				<div id="cpx1" class="demo" name="dealName" style="border-top-color: red; border-right-color: red; border-bottom-color: red; border-left-color: red; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dashed; border-right-style: dashed; border-bottom-style: dashed; border-left-style: dashed; border-image: initial; position: absolute; font-size: <?php echo $coupons[0]->font_size ?>px; width: <?php echo $coupons[0]->width ?>px; height: <?php echo $coupons[0]->height ?>px; cursor: move; z-index: 999; left: <?php echo $coupons[0]->x ?>px; top: <?php echo $coupons[0]->y ?>px; ">[DEALNAME]</div>
				<div id="cpx2" class="demo" name="merchantName" style="border-top-color: red; border-right-color: red; border-bottom-color: red; border-left-color: red; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dashed; border-right-style: dashed; border-bottom-style: dashed; border-left-style: dashed; border-image: initial; position: absolute; font-size: <?php echo $coupons[2]->font_size ?>px; width: <?php echo $coupons[2]->width ?>px; height: <?php echo $coupons[2]->height ?>px; cursor: move; z-index: 999; left: <?php echo $coupons[1]->x ?>px; top: <?php echo $coupons[1]->y ?>px; ">[MERCHANTNAME]</div>
				<div id="cpx3" class="demo" name="highlight" style="border-top-color: red; border-right-color: red; border-bottom-color: red; border-left-color: red; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dashed; border-right-style: dashed; border-bottom-style: dashed; border-left-style: dashed; border-image: initial; position: absolute; font-size: <?php echo $coupons[3]->font_size ?>px; width: <?php echo $coupons[3]->width ?>px; height: <?php echo $coupons[3]->height ?>px; cursor: move; z-index: 999; left: <?php echo $coupons[2]->x ?>px; top: <?php echo $coupons[2]->y ?>px; ">[HIGHLIGHT]</div>
				<div id="cpx4" class="demo" name="personName" style="border-top-color: red; border-right-color: red; border-bottom-color: red; border-left-color: red; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dashed; border-right-style: dashed; border-bottom-style: dashed; border-left-style: dashed; border-image: initial; position: absolute; font-size: <?php echo $coupons[4]->font_size ?>px; width: <?php echo $coupons[4]->width ?>px; height: <?php echo $coupons[4]->height ?>px; cursor: move; z-index: 999; left: <?php echo $coupons[3]->x ?>px; top: <?php echo $coupons[3]->y ?>px; ">[PERSONNAME]</div>
				<div id="cpx5" class="demo" name="term" style="border-top-color: red; border-right-color: red; border-bottom-color: red; border-left-color: red; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dashed; border-right-style: dashed; border-bottom-style: dashed; border-left-style: dashed; border-image: initial; position: absolute; font-size: <?php echo $coupons[5]->font_size ?>px; width: <?php echo $coupons[5]->width ?>px; height: <?php echo $coupons[5]->height ?>px; cursor: move; z-index: 999; left: <?php echo $coupons[4]->x ?>px; top: <?php echo $coupons[4]->y ?>px; ">[TERM]</div>
		</div>
		<div id="button">
			<input type="button" class="button-secondary action" value="Save" onclick="getdiv()"/>
			<input type="button" class="button-secondary action" value="Print" onclick="ClickHereToPrint()"/>
		</div>
	</form>

	