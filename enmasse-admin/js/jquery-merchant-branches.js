// JavaScript Document
function addNewMerchantBranch()
{
	count = jQuery("input[name='num_of_branches']").val();
	count = parseInt(count) + 1;
	jQuery("input[name='num_of_branches']").val(count);
	jQuery("#branches").append(		
        '<table class="branchesRow" style="width: 100%" id="branches' + count + '">\n\
		<tr><th colspan=2># Branch ' + count + '</th></tr>\n\
		<tr>\n\
            <td>Check to remove</td>\n\
            <td><input type="checkbox" onclick="uncheckRequire(this);" name="remove-' + count + '" id="remove-' + count + '"/></td>\n\
			<input type="hidden" id="branchname-' + count + '" name="branchname-' + count + '" value="branch' + count + '"/>\n\
        </tr>\n\
        <tr>\n\
            <td>\n\
            <label for="name-' + count + '">Merchant name</label>\n\
          	</td>\n\
            <td class="form-required" style="width: 100%"><input maxlength="50" type="text" name="name-' + count + '" id="name-' + count + '" size="50" maxlength="250" value="" /></td>\n\
        </tr>\n\
        <tr>\n\
            <td>\n\
            <label for="description-' + count + '">Merchant description</label>\n\
            </td>\n\
            <td style="width: 100%"><textarea name="description-' + count + '" id="description-' + count + '" cols="10" rows="5"></textarea></td>\n\
        </tr>\n\
        <tr>\n\
	        <td>\n\
		        <label for="address-' + count + '">Merchant address</label>\n\
	        </td>\n\
            <td class="form-required" style="width: 100%"><textarea name="address-' + count + '" id="address-' + count + '" cols="10" rows="5"></textarea></td>\n\
        </tr>\n\
        <tr>\n\
	        <td>\n\
		        <label for="telephone-' + count + '">Merchant telephone</label>\n\
	        </td>\n\
        	<td class="form-required" style="width: 100%"><input type="text" name="telephone-' + count + '" id="telephone-' + count + '" size="15" maxlength="250" value="" /></td>\n\
        </tr>\n\
        <tr>\n\
	        <td>\n\
		        <label for="fax-' + count + '">Merchant fax</label>\n\
        	</td>\n\
            <td style="width: 100%"><input type="text" name="fax-' + count + '" id="fax-' + count + '" size="15" maxlength="250" value="" /></td>\n\
        </tr>\n\
        <tr>\n\
	        <td>\n\
		        <label for="google_map_lat-' + count + '">Google map latitude</label>\n\
			</td>\n\
            <td class="form-required" style="width: 100%"><input type="text" name="google_map_lat-' + count + '" id="google_map_lat-' + count + '" size="15" maxlength="250" value="" /></td>\n\
        </tr>\n\
        <tr>\n\
        	<td>\n\
		        <label for="google_map_long-' + count + '">Google map longtitude</label>\n\
			</td>\n\
            <td class="form-required" style="width: 100%"><input type="text" name="google_map_long-' + count + '" id="google_map_long-' + count + '" size="15" maxlength="250" value="" /></td>\n\
        </tr>\n\
        <tr>\n\
        	<td>\n\
        		<label for="goole_map_zoom-' + count + '">Google map zoom</label>\n\
			</td>\n\
            <td style="width: 100%">\n\
                <input type="text" name="google_map_zoom-' + count + '" id="google_map_zoom-' + count + '" size="15" maxlength="250" value="" />\n\
            </td>\n\
        </tr>\n\
        <tr>\n\
            <td colspan="2\"><hr/></td>\n\
        </tr>\n\
		</table>'
);
}

function uncheckRequire(ckb)
{
	var index = ckb.id.substring(ckb.id.length - 1);
	if(ckb.checked){		
		jQuery("#name-" + index).parent().removeClass("form-required");
		jQuery("#telephone-" + index).parent().removeClass("form-required");
		jQuery("#google_map_lat-" + index).parent().removeClass("form-required");
		jQuery("#google_map_long-" + index).parent().removeClass("form-required");
	}
	else{
		jQuery("#name-" + index).parent().addClass("form-required");
		jQuery("#telephone-" + index).parent().addClass("form-required");
		jQuery("#google_map_lat-" + index).parent().addClass("form-required");
		jQuery("#google_map_long-" + index).parent().addClass("form-required");
	}
}