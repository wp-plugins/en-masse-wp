

<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2><?php _e('System Settings') ?></h2>

		<form method="post" action="admin.php?page=enmasse_settings">
		<h3 class="title"><?php _e('Company Details') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="enmasse_company_name"><?php _e('Name') ?></label></th>
				<td >
					<input name="option[enmasse_company_name]" type="text" id="enmasse_company_name" value="<?php form_option('enmasse_company_name'); ?>" aria-required ="true" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_company_adress_1"><?php _e('Address Line 1') ?></label>
				</th>
				<td>
					<input name="option[enmasse_company_adress_1]" type="text" id="enmasse_company_adress_1"  value="<?php form_option('enmasse_company_adress_1'); ?>" aria-required ="true" class="regular-text" />
				</td>
			</tr>
				<tr valign="top">
				<th scope="row">
					<label for="enmasse_company_adress_2"><?php _e('Address Line 2') ?></label>
				</th>
				<td>
					<input name="option[enmasse_company_adress_2]" type="text" id="enmasse_company_adress_2"  value="<?php form_option('enmasse_company_adress_2'); ?>"  class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_company_city"><?php _e('City') ?></label>
				</th>
				<td>
					<input name="option[enmasse_company_city]" type="text" id="enmasse_company_city"  value="<?php form_option('enmasse_company_city'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_company_country"><?php _e('Country') ?></label>
				</th>
				<td>
					<input name="option[enmasse_company_country]" type="text" id="enmasse_company_country"  value="<?php form_option('enmasse_company_country'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_company_state"><?php _e('State') ?></label>
				</th>
				<td>
					<input name="option[enmasse_company_state]" type="text" id="enmasse_company_state"  value="<?php form_option('enmasse_company_state'); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		<h3 class="title"><?php _e('Currency Details') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="enmasse_currency_symbol"><?php _e('Currency Prefix') ?></label></th>
				<td >
					<input name="option[enmasse_currency_symbol]" type="text" id="enmasse_currency_symbol" value="<?php form_option('enmasse_currency_symbol'); ?>"  class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_currency_decimal_place"><?php _e('Number of Decimal Places *') ?></label>
				</th>
				<td>
					<input name="option[enmasse_currency_decimal_place]" type="text" id="enmasse_currency_decimal_place"  value="<?php form_option('enmasse_currency_decimal_place'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_currency_decimal_place"><?php _e('Currency Type') ?></label>
				</th>
				<td>
				 <?php $enmasse_currency_type = get_option('enmasse_currency_type') ; ?>
					<select name="option[enmasse_currency_type]">
					    <option  <?php if ( $enmasse_currency_type == "prefix" ) echo 'selected="selected"' ?> value="prefix" >prefix</option>
					    <option  <?php if ( $enmasse_currency_type == "surfix" ) echo 'selected="selected"' ?> value="surfix" >surfix</option>
					</select>
			</td>
			</tr>
		</table>
		<h3 class="title"><?php _e('Tax Details') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="enmasse_taxnumber_1"><?php _e('Tax number 1') ?></label></th>
				<td >
					<input name="option[enmasse_taxnumber_1]" type="text" id="enmasse_taxnumber_1" value="<?php form_option('enmasse_taxnumber_1'); ?>"  class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_taxnumber_2"><?php _e('Tax number 2') ?></label>
				</th>
				<td>
					<input name="option[enmasse_taxnumber_2]" type="text" id="enmasse_taxnumber_2"  value="<?php form_option('enmasse_taxnumber_2'); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		
		<h3 class="title"><?php _e('Bill Setting') ?></h3>
		<table class="form-table">
			
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_bill_setting"><?php _e('Sending Bill Auto?') ?></label>
				</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e( 'Sending Bill Auto?' ); ?> </span>
						</legend>
						<p>
							<label><input name="option[enmasse_bill_setting]"  type="radio" value="1" <?php checked( 1, get_option( 'enmasse_bill_setting' ) ); ?>	/> <?php _e( 'Yes' ); ?></label>
							
							<label>
								<input name="option[enmasse_bill_setting]" type="radio" value="0" <?php checked( 0, get_option( 'enmasse_bill_setting' ) ); ?> /> <?php _e( 'No' ); ?>
							</label>
						</p>
					</fieldset>
				</td>
			</tr>
		</table>
		<h3 class="title"><?php _e('SMTP Setting') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_smtp_port"><?php _e('SMTP Port') ?></label>
				</th>
				<td>
					<input name="option[enmasse_smtp_port]" type="text" id="enmasse_smtp_port"  value="<?php form_option('enmasse_smtp_port'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_smtp_secure"><?php _e('SMTP Secure') ?></label>
				</th>
				<td>
					<input name="option[enmasse_smtp_secure]" type="text" id="enmasse_smtp_secure"  value="<?php form_option('enmasse_smtp_secure'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_smtp_host"><?php _e('SMTP Host Name') ?></label>
				</th>
				<td>
					<input name="option[enmasse_smtp_host]" type="text" id="enmasse_smtp_host"  value="<?php form_option('enmasse_smtp_host'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_smtp_email"><?php _e('Your Email') ?></label>
				</th>
				<td>
					<input name="option[enmasse_smtp_email]" type="text" id="enmasse_smtp_email"  value="<?php form_option('enmasse_smtp_email'); ?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="enmasse_email_pass"><?php _e('Email Password') ?></label>
				</th>
				<td>
					<input name="option[enmasse_email_pass]" type="text" id="enmasse_email_pass"  value="<?php form_option('enmasse_email_pass'); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
		</form>

</div>

