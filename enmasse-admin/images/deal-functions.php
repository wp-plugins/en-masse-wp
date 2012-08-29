<?php
function deal_submit_meta_box () {
	global $deal;
	$datef = __( 'M j, Y @ G:i' );
	if ( 0 != $deal->id ) {
		if ( 'future' == $deal->post_status ) { // scheduled for publishing at a future date
			$stamp = __('Scheduled for: <b>%1$s</b>');
		} else if ( 'publish' == $deal->post_status || 'private' == $deal->post_status ) { // already published
			$stamp = __('Published on: <b>%1$s</b>');
		} else if ( '0000-00-00 00:00:00' == $deal->post_date_gmt ) { // draft, 1 or more saves, no date specified
			$stamp = __('Publish <b>immediately</b>');
		} else if ( time() < strtotime( $deal->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
			$stamp = __('Schedule for: <b>%1$s</b>');
		} else { // draft, 1 or more saves, date specified
			$stamp = __('Publish on: <b>%1$s</b>');
		}
		$date = date_i18n( $datef, strtotime( $deal->post_date ) );
	} else { // draft (no saves, and thus no date specified)
		$stamp = __('Publish <b>immediately</b>');
		$date = date_i18n( $datef, strtotime( current_time('mysql') ) );
	}
	
?>
	<script type="text/javascript">
				jQuery(document).ready(function (){ 
	
					jQuery("#calendar1, #calendar2").calendar();
	
					jQuery("#calendar1_alert").click(function(){alert(popUpCal.parseDate(jQuery('#calendar1').val()))});
	
				});
		function keypress(e){
			var keypressed = null;
		
			if (window.event)
			{
				keypressed = window.event.keyCode; //IE
			}
			else
			{
				keypressed = e.which; //NON-IE, Standard
			}
		
			if (keypressed < 48 || keypressed > 57){
		
				if (keypressed == 8 || keypressed == 9 || keypressed == 127 || keypressed == 44 || keypressed == 46){
					return;
				}
		
				return false;
			}
		
		}
	</script>
<div class="submitbox1" id="submitpost">
	<div id="minor-publishing">
    	<div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span class="submitdelete deletion">
                <?php _e('Original Price') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-origin-price" type="text" id="origin_price" onkeypress="return keypress(event);" size="5" aria-required="true"  value="<?php if (isset($_SESSION['data']['origin_price'])) {echo  $_SESSION['data']['origin_price']; } else if(isset($deal->origin_price)){echo $deal->origin_price;} ?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span class="submitdelete deletion">
                <?php _e('Price') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-price" type="text" id="price" onkeypress="return keypress(event);" aria-required="true" size="5"  value="<?php if(isset($_SESSION['data']['price'])){echo $_SESSION['data']['price'];} else if(isset( $deal->price)){echo $deal->price;} ?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span class="submitdelete deletion">
                <?php _e('Start at') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-start-at" id="calendar1" aria-required="true" type="text" id="deal_start_at" size="30"  value="<?php if(isset($_SESSION['data']['start_at'])){echo dateFormat($_SESSION['data']['start_at'],"d/m/Y H:i:s A");}elseif(isset($deal->start_at )){echo dateFormat($deal->start_at,"d/m/Y H:i:s A");}?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span class="submitdelete deletion">
                <?php _e('End at') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-end-at" id="calendar1" aria-required="true" type="text" id="deal_end_at" size="30"  value="<?php if(isset($_SESSION['data']['end_at'])){echo dateFormat($_SESSION['data']['end_at'],"d/m/Y H:i:s A");} elseif(isset($deal->end_at )){echo dateFormat($deal->end_at,"d/m/Y H:i:s A");}?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span class="submitdelete deletion">
                <?php _e('Min Quantity') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-min-needed-qty" type="text" aria-required="true" onkeypress="return keypress(event);"  id="deal-min-needed-qty" size="5"  value="<?php if(isset($_SESSION['data']['min_needed_qty'])){echo $_SESSION['data']['min_needed_qty'];} elseif(isset ($deal->min_needed_qty)){echo $deal->min_needed_qty;} ?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Max purchased / User') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-max-buy-qty" type="text" id="deal_max_buy_qty" onkeypress="return keypress(event);" size="5"  value="<?php if(isset($_SESSION['data']['max_buy_qty'])){echo $_SESSION['data']['max_buy_qty'];} elseif(isset($deal->max_buy_qty)){echo $deal->max_buy_qty;} else echo 9999; ?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Max Coupon Quantity') ?>
                </span>
                <span class="form-input-right">
            		<input name="deal-max-coupon-qty" type="text" id="max_coupon_qty" onkeypress="return keypress(event);" size="5"  value="<?php if(isset($_SESSION['data']['max_coupon_qty'])){echo $_SESSION['data']['max_coupon_qty'];} elseif(isset($deal->max_coupon_qty)){echo $deal->max_coupon_qty;} else echo 9999; ?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Current Sold Quantity') ?>
                </span>
                <span class="form-input-right">
            		<input disabled="true" name="deal-current-slod-qty" type="text" id="currrent_sold_qty" size="5"  value="<?php if(isset($deal->cur_sold_qty)) {echo $deal->cur_sold_qty; } ?>" />
            	</span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span class="submitdelete deletion">
                <?php _e('Sale Person') ?>
                </span>
                <span class="form-input-right">
		        	<select name="deal-sale-person-id">
		            	<option value="0">None</option>
		                <?php enmasse_dropdown_sale_person(isset($_SESSION['data']['sales_person_id']) ? $_SESSION['data']['sales_person_id'] : $deal->sales_person_id);?>
		            </select>
		        </span>
                <div class="clear"></div>                
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Published') ?>
                </span>
                <span class="form-input-right">
                	<label for="published1">Yes</label>
		        	<input type="radio" value="1" name="published" id="published1"  <?php if(isset($deal->published) && $deal->published == 1 ) { ?> checked="checked" <?php } else { ?>checked="checked"  <?php } ?>  />
		        	<label for="published0">No</label>
		        	<input type="radio" value="0" name="published" <?php if(!$deal->published) { ?> checked="checked" <?php } ?> id="published0"   />
		        </span>
                <div class="clear"></div>                
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Auto Confirm') ?>
                </span>
                <span class="form-input-right">
                	<label for="confirm1">Yes</label>
		        	<input type="radio" value="1" name="confirm" id="confirm1"<?php if(isset($deal->auto_confirm) && $deal->auto_confirm == 1 ) { ?> checked="checked" <?php } else { ?>checked="checked"  <?php } ?> />
		        	<label for="confirm0">No</label>
		        	<input type="radio" value="0" name="confirm" id="confirm0" <?php if(!$deal->auto_confirm) { ?> checked="checked" <?php } ?> />
		        </span>
                <div class="clear"></div>                
            </div>
       		<div class="clear"></div>
        </div>
        <div id="misc-publishing-actions">
            <div class="misc-pub-section form-required">
                <span>
                <?php _e('Merchant') ?>
                </span>
                <span class="form-input-right">
		        	<select name="deal-merchant-id">
		            	<option value="0">None</option>
		                <?php enmasse_dropdown_merchant(isset($_SESSION['data']['merchant_id']) ? $_SESSION['data']['merchant_id'] : $deal->merchant_id);?>
		            </select>
		        </span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
        <!-- 
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Prepay Percent') ?>
                </span>
                <span class="form-input-right">
		        	<select name="deal-prepay-percen" >
		           		<?php enmasse_dropdown_paypercen($deal->prepay_percent);?>
		            </select>
		        </span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>  -->
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">
                <span>
                <?php _e('Commission Percent') ?>
                </span>
                <span class="form-input-right">
		        	<select name="deal-commission-percent">
		            	<?php enmasse_dropdown_paypercen($deal->commission_percent);?>
		            </select>
		        </span>
                <div class="clear"></div>
            </div>
       		<div class="clear"></div>
        </div>
    	<div id="misc-publishing-actions">
            <div class="misc-pub-section curtime misc-pub-section-last">
                <span id="timestamp">
                <?php printf($stamp, $date); ?></span>
                <a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex='4'><?php _e('Edit') ?></a>
                <div id="timestampdiv" class="hide-if-js"><?php touch_time(($action == 'edit'),1,4); ?></div>
            </div>
       		<div class="clear"></div>
        </div>
    </div>
    <div id="minor-publishing">    
        <div id="major-publishing-actions">
            <div id="delete-action">
                <input name="submit" type="submit" class="button-primary" id="preview" tabindex="5" accesskey="p" value="Preview"/>
            </div>
            <div id="publishing-action">
            	<input name="submit" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Publish"/>
            </div>
       	 	<div class="clear"></div>
        </div>
    </div>
</div>	

<?
}
function deal_cat_meta_box () {
global  $cats;

?>

<div class="form-field">
        <p><ul>
		<?php enmasse_checkbox_cat(0,$cats);?>
        	</ul>
        </p>
</div>
<?php
	unset($cats); 
}

function deal_loc_meta_box () {
	global  $locs;
?>
<div class="form-field form-required">
    <p><ul>
	<?php enmasse_checkbox_loc(0,$locs);?>
        </ul>
    </p>
</div>
<?php
	unset ($locs);
 }

function getNewDealCode()
{
	global $wpdb;
	$text = "DE" .date('ym', time());
	$query = "SELECT COUNT(id) as Num  FROM ".ENMASSE_DEAL.
			   " WHERE deal_code LIKE '$text%'";              
	$result = $wpdb->get_results($query);
	$num = $result[0]->Num;

	$str = (string)($num + 1);

	if (strlen($str) < 5) {

		$str = str_repeat('0', 5 - strlen($str)).$str;

	}

	return $text.'-'.$str;
}
function status_of_deal($start_at,$end_at) {
		$start_at = strtotime($start_at);
		$end_at = strtotime($end_at);
		if ($start_at > time()) {
			$status_of_deal = 'Upcoming';
		} else {
			if ($end_at <= time()) {
				$status_of_deal = 'Closed';
			} else if($_POST['deal_status'] != 'Confirmed'){
				$status_of_deal = 'On Sales';
			} else{
				$status_of_deal = $_POST['deal_status'];
			}
		}
		return $status_of_deal;
}
?>