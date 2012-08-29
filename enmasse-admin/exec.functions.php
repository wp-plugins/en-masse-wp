<?php
function displayOrderDisplayId($id) {
	return str_pad($id, 10, '0', STR_PAD_LEFT);
}
function enmasse_dropdown_cat ($root = 0, $current = 0,$owner = 0,$prefx = "") {
	global $wpdb;
	$catx = $wpdb->get_results( 'SELECT a.* FROM ' . ENMASSE_CATEGORY . ' a WHERE a.parent_id = '.$root);
	if( !empty($catx)):
		$prefx.= "&nbsp;&nbsp;&nbsp;";
		foreach($catx as $cat):
			if ($cat->id != $owner):
				echo "<option value='".$cat->id."' ";
				if ($cat->id == $current) echo "selected='selected'";
				echo ">".$prefx.$cat->name."</option>";				
				enmasse_dropdown_cat ($cat->id, $current,$owner,$prefx);
			endif;
		endforeach;
	endif;
}
function enmasse_dropdown_loc ($root = 0, $current = 0,$owner = 0,$prefx = "") {
	global $wpdb;
	$catx = $wpdb->get_results( 'SELECT a.* FROM ' . ENMASSE_LOCATION. ' a WHERE a.parent_id = '.$root);
	if( !empty($catx)):
		$prefx.= "&nbsp;&nbsp;&nbsp;";
		foreach($catx as $cat):
			if ($cat->id != $owner):
				echo "<option value='".$cat->id."' ";
				if ($cat->id == $current) echo "selected='selected'";
				echo ">".$prefx.$cat->name."</option>";				
				enmasse_dropdown_loc ($cat->id, $current,$owner,$prefx);
			endif;
		endforeach;
	endif;
}
function enmasse_dropdown_sale_person ($sale_id = null) 
{
	global $wpdb;

	$query ='SELECT * FROM '. ENMASSE_SALES_PERSON;  
	$sales = $wpdb->get_results($query);
	if( !empty($sales))
	{
		foreach ($sales as $sale)
		{
			echo "<option value='".$sale->id."' ";
			if($sale->id == $sale_id) echo "selected='selected'";
			echo ">".$sale->name."</option>";
		}
	}
}
function enmasse_dropdown_merchant ($merchant_id = null) 
{
	global $wpdb;
	$query ='SELECT * FROM '. ENMASSE_MERCHANT_BRANCH;  
	$merchants = $wpdb->get_results($query);
   	if( !empty($merchants))
	{
		foreach ($merchants as $merchant)
		{
			echo "<option value='".$merchant->id."'";
			if ($merchant->id == $merchant_id) echo "selected='selected'";
			echo ">";
			echo $merchant->name;
			echo "</option>";
		}
	}
}
function enmasse_dropdown_deal ($deal_id = null)
{
	global $wpdb;
	$query ='SELECT * FROM '. ENMASSE_DEAL;
	$deals = $wpdb->get_results($query);
	if( !empty($deals))
	{
		
		foreach ($deals as $deal)
		{
			echo "<option value='".$deal->id."'";
			if ($deal->id == $deal_id) echo "selected='selected'";
			echo ">";
			
			echo  cutWordByChar($deal->name);
			echo "</option>";
		}
	}
}

function enmmasse_dropdow_setment_status() {
	$actions = array('Paid_Out' => 'PAY OUT','Not_Paid_Out' => 'BACK TO NOT PAY OUT');
	foreach ($actions as $id => $value )
	{
		echo "<option value='".$id."'";
		if ($id == 'payOut') echo "selected='selected'";
		echo ">";
		echo  $value;
		echo "</option>";
	}
}
function enmmasse_dropdow_deal_status() {
	$actions = array('DealStatus'=>'[Deal Status]','Confirmed' => 'Confirmed','On Sales' => 'On Sales','Closed' => 'Closed');
	foreach ($actions as $id => $value )
	{
		echo "<option value='".$id."'";
		if ($id == 'DealStatus') echo "selected='selected'";
		echo ">";
		echo  $value;
		echo "</option>";
	}
}
function enmasse_dropdown_set_status($status_id = null){
	$status = array('Not_Paid_Out'=>'Not Paid Out','Should_Be_Paid_Out'=>'Should Be Paid Out','Paid_Out'=>'Paid Out');
	foreach ($status as $id => $value)
	{
		echo "<option value='".$id."'";
		if ($id == $status_id) echo "selected='selected'";
		echo ">";
		echo  $value;
		echo "</option>";
	}
}
function enmasse_checkbox_cat ($root = 0, $current = array(),$prefx = "") {
	global $wpdb;
	$catx = $wpdb->get_results( 'SELECT a.* FROM ' . ENMASSE_CATEGORY . ' a WHERE a.parent_id = '.$root);

	if( !empty($catx)):
		$prefx.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		foreach($catx as $cat):
				echo '<li>'.$prefx."<input type='checkbox' name='deal-cat[]' value='".$cat->id."' ";
				if ($cat->id == $current[$cat->id]) echo "checked='checked'";
				echo " / > ".$cat->name."</li>";				
				enmasse_checkbox_cat ($cat->id, $current,$prefx);
		endforeach;
	endif;
}
function enmasse_checkbox_loc ($root = 0, $current = array(),$prefx = "") {
	global $wpdb;
	$locx = $wpdb->get_results( 'SELECT a.* FROM ' . ENMASSE_LOCATION. ' a WHERE a.parent_id = '.$root);
	if( !empty($locx)):
		$prefx.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		foreach($locx as $loc):
				echo '<li>'.$prefx."<input type='checkbox' name='deal-loc[]' value='".$loc->id."' ";
				if ($loc->id == $current[$loc->id]) echo "checked='checked'";
				echo " / > ".$loc->name."</li>";				
				enmasse_checkbox_loc  ($loc->id, $current,$prefx);
		endforeach;
	endif;
}
function  enmasse_dropdown_paypercen($percen = 0){
	
	for($i =0;$i <= 100;$i+=5){
		echo "<option value = '".$i."'";
		if($i == $percen): echo "selected='selected'"; endif;
		echo  ">" ;
		echo $i;
		echo "</option>";
	}
	
}
function get_user_ajax($type = null)
{
	global $wpdb;
	$searchStr = esc_html($_REQUEST['searchStr']);
	if ($type == 'merchant'):
		$query = "SELECT u.*, (SELECT m.meta_value FROM wp_usermeta m WHERE m.user_id = u.ID AND m.meta_key='first_name') first_name, (SELECT m.meta_value FROM wp_usermeta m WHERE m.user_id = u.ID AND m.meta_key='last_name') last_name FROM ".$wpdb->prefix."users u WHERE (u.user_login LIKE '%$searchStr%' OR u.user_email LIKE '%$searchStr%') AND u.ID NOT IN (SELECT m.user_id FROM ".ENMASSE_SALES_PERSON." m)  AND u.ID NOT IN (SELECT s.user_id FROM ".ENMASSE_MERCHANT_BRANCH." s) ORDER BY u.display_name LIMIT 10";
	endif;
	if ($type == 'sale'):
		$query = "SELECT u.*, (SELECT m.meta_value FROM wp_usermeta m WHERE m.user_id = u.ID AND m.meta_key='first_name') first_name, (SELECT m.meta_value FROM wp_usermeta m WHERE m.user_id = u.ID AND m.meta_key='last_name') last_name FROM ".$wpdb->prefix."users u WHERE (u.user_login LIKE '%$searchStr%' OR u.user_email LIKE '%$searchStr%') AND u.ID NOT IN (SELECT m.user_id FROM ".ENMASSE_SALES_PERSON." m)  AND u.ID NOT IN (SELECT m.user_id FROM ".ENMASSE_MERCHANT_BRANCH." m) ORDER BY u.display_name LIMIT 10";
	endif;
	$users = $wpdb->get_results($query);
	$str =  '{';$str.= '"totalResultsCount":'.count($users).',';$str.='"users":[';
	if( !empty($users))
	{
		foreach($users as $user) {
			$str.='{"user_login":"'.$user->user_login.'","display_email":"'.$user->user_email.'"}';
			if (end($users) != $user)$str.=',';
		}
	}			
	$str.=']';$str.='}';
	echo $str;
}
function pagination($totalposts,$p,$lpm1,$prev,$next,$atributes = array())
{
	$strAtribute = "";
	if( !empty($atributes))
	{
		foreach ($atributes as $atribute=>$valute)
		{
			$strAtribute.= "&".$atribute."=".$valute;
		}
	}
	$adjacents = 3;
	if($totalposts > 1)
	{
		$pagination .= "<center><div>";
		//previous button
		if ($p > 1)
			$pagination.= "<a href=\"?pg=$prev$strAtribute\">&laquo; Previous</a> ";
		
		if ($totalposts < 7 + ($adjacents * 2)){
			for ($counter = 1; $counter <= $totalposts; $counter++){
				if ($counter == $p)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= " <a href=\"?pg=$counter$strAtribute\">$counter</a> ";
			}
		}elseif($totalposts > 5 + ($adjacents * 2)){
			if($p < 1 + ($adjacents * 2)){
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if ($counter == $p)
						$pagination.= " <span class=\"current\">$counter</span> ";
					else
						$pagination.= " <a href=\"?pg=$counter$strAtribute\">$counter</a> ";
				}
				$pagination.= " ... ";
				$pagination.= " <a href=\"?pg=$lpm1\">$lpm1</a> ";
				$pagination.= " <a href=\"?pg=$totalposts$strAtribute\">$totalposts</a> ";
			}
			//in middle; hide some front and some back
			elseif($totalposts - ($adjacents * 2) > $p && $p > ($adjacents * 2)){
				$pagination.= " <a href=\"?pg=1\">1</a> ";
				$pagination.= " <a href=\"?pg=2\">2</a> ";
				$pagination.= " ... ";
				for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++){
					if ($counter == $p)
						$pagination.= " <span class=\"current\">$counter</span> ";
					else
						$pagination.= " <a href=\"?pg=$counter$strAtribute\">$counter</a> ";
				}
				$pagination.= " ... ";
				$pagination.= " <a href=\"?pg=$lpm1.$strAtribute\">$lpm1</a> ";
				$pagination.= " <a href=\"?pg=$totalposts.$strAtribute\">$totalposts</a> ";
			}else{
				$pagination.= " <a href=\"?pg=1\">1</a> ";
				$pagination.= " <a href=\"?pg=2\">2</a> ";
				$pagination.= " ... ";
				for ($counter = $totalposts - (2 + ($adjacents * 2)); $counter <= $totalposts; $counter++){
					if ($counter == $p)
						$pagination.= " <span class=\"current\">$counter</span> ";
					else
						$pagination.= " <a href=\"?pg=$counter$strAtribute\">$counter</a> ";
				}
			}
		}
		if ($p < $counter - 1)
			$pagination.= " <a href=\"?pg=$next$strAtribute\">Next &raquo;</a>";
		
		$pagination.= "</center>\n";
	}
	return $pagination;
}
/**
 * Converts a string into a fairly unique, short slug
 *
 * @param string $string String to convert to a slug
 * @return string Slug
 */
function makeSlug($string)
{
	//replace double byte whitespaces by single byte (Far-East languages)
        $str = preg_replace('/\xE3\x80\x80/', ' ', $string);
 
 
        // remove any '_' from the string as they will be used as concatenator.
        // Would be great to let the spaces in but only Firefox is friendly with this
 
        $str = str_replace('_', ' ', $str);
 
        // replace forbidden characters by whitespaces
        $str = preg_replace( '#[:\#\*"@+=;!&%()\]\/\'\\\\|\[]#',"\x20", $str );
 
        //delete all '?'
        $str = str_replace('?', '', $str);
 
        //trim white spaces at beginning and end of alias
        $str = trim( $str );
 
        // remove any duplicate whitespace and replace whitespaces by hyphens
        $str =preg_replace('#\x20+#','_', $str);
        return $str;
}

function  dateFormat($date =null ,$timeStamp = "d-m-Y")
{
	if($date == null)
	{
		$date = date('c');
	}
	else 
	{
		$date = str_replace('/','-',$date);	
		$date = str_replace('PM',' ',$date);
		$date = str_replace('AM',' ',$date);
	}
	
	$dateLabel = new DateTime($date);
	$date = $dateLabel->format ($timeStamp);
	return $date;
}

function cutWordByChar($str, $length = 10, $allowTags = null) {
	$str = strip_tags ( $str, $allowTags );
	$str = explode ( " ", $str );
	if (count ( $str ) <= $length) {
		return implode ( " ", $str );
	}
	return implode ( " ", array_slice ( $str, 0, $length ) ) . '...';
}

/*
 * slice string follow UTF 8 format
* return Array()
* */
function mb_chunk_split($str, $len, $glue)
{
	$string = '';
	do
	{
		$substring = mbStringToArray ( $str, $len );
		$string .= htmlspecialchars_decode ( html_entity_decode ( $substring ['retour'], ENT_QUOTES ) ) . $glue;
		$str = $substring ['the_rest'];
	}
	while ( ! empty ( $substring ['the_rest'] ) );
	return $string;
}
/*
* chunk string follow UTF 8 format
* return string
* */
function mbStringToArray($string, $real_size)
{
		$string = htmlspecialchars_decode ( $string, ENT_QUOTES );
		$length = 0;
		$count = 0;
	
		for($i = 0; $i < mb_strlen ( $string, 'UTF-8' ) && $i < $real_size; $i ++)
		{
		$char = mb_substr ( $string, $i, 1, 'UTF-8' );
		//with chars using 2bytes
		if (mb_strwidth ( $char, 'UTF-8' ) == 2)
		{
		$length += 2.5;
		$count ++;
		}
			else
				{
				$asciinum = ord ( $char );
				$majCharArray = array (128, 142, 143, 144, 146, 153, 154, 157, 158, 165, 168, 169, 170, 171, 172, 219, 220, 223, 225, 226, 228, 229, 230, 232, 233, 234, 236, 239, 244, 245, 247 );
				$wCharArray = array (176, 177, 178 );
				if (($char == 'w') || ($char == 'm') || in_array ( $asciinum, $wCharArray ))
				{
				$length += 2;
				$count ++;
				}
				elseif (in_array ( $char, array ('f', 'j', 'i', 'I', 'l', '|', ':', ';', '.', ',', '\'' ) ))
				{
				$length += 0.5;
				$count += 2;
				}
				elseif ((($asciinum >= 65) && ($asciinum <= 90)) || in_array ( $asciinum, $majCharArray ))
				{
						$length += 1.5;
						$count ++;
						}
						else
						{
						$length += 1;
						$count ++;
				}
				}
				if ($length > $real_size)
				{
				break;
				}
	
				}
				if (mb_strlen ( $string, 'UTF-8' ) > $count) {
						$retour = mb_substr ( html_entity_decode ( $string, ENT_QUOTES ), 0, $count, 'UTF-8' );
						$the_rest = mb_substr ( html_entity_decode ( $string, ENT_QUOTES ), $count, mb_strlen ( $string, 'UTF-8' ), 'UTF-8' );
		}
		else
		{
			$retour = $string;
			$the_rest = '';
		}
		return array ('retour' => $retour, 'the_rest' => $the_rest );
}

/*
 * @todo : validate image file
 */
function  do_validate_file($filtype,$alowtype = array('jpg','png','bnb')) {
	
	$error =array();
	if ( isset($_FILES['async-upload']["file_upload"]["error"]) || $_FILES['async-upload']["file_upload"]["error"] != 0)
	{
		$error[] = "this some error in upload process";
	}
	if ( $_FILES['async-upload']["file_upload"]["size"] > wp_max_upload_size() ) {    //thông báo lỗi
		$error[] ="this is to large file";
	}
	$filename = strtolower(stripslashes($filtype));
	$fileimg = substr($filename, 0, strripos($filename, '.')); // strip filename
	$extension = substr(substr($filename, strripos($filename, '.')), 1); //extention
	
	if(!in_array($extension,$alowtype)) {
		$error[] ="this is not suport file";
	}
	return $error;
}
/*
 *@todo: upload coupon image
 */
function do_upload($upload_dir = null,$filename = null) {
	$upload_file = $upload_dir .'/'. $filename;
	
	if ( move_uploaded_file($_FILES["async-upload"]["tmp_name"], $upload_file) ) {
		return $filename;  
	} 
	else 
	{   
		return null;	
	} 
}

/*
 * generate qr code
 */
function generateBarcode($num ="SERIAL")
{
	
	// Loading Font
	$font = new BCGFont(ENMASSE_LIB.'/barcodegen/class/font/Arial.ttf', 13);
	// The arguments are R, G, B for color.
	$color_black = new BCGColor(0, 0, 0);
	$color_white = new BCGColor(255, 255, 255);
	$drawException = null;
	try {
		$code = new BCGcode128();
		//$code->setScale(1.5); // Resolution
		$code->setThickness(40); // Thickness
		$code->setForegroundColor($color_black); // Color of bars
		$code->setBackgroundColor($color_white); // Color of spaces
		$code->setFont($font); // Font (or 0)
		$code->parse($num); // Text
	} catch(Exception $exception) {
		$drawException = $exception;
	}

	/* Here is the list of the arguments
	 1 - Filename (empty : display on screen)
	2 - Background color */
	$drawing = new BCGDrawing('', $color_white);
	if($drawException) {
		$drawing->drawException($drawException);
	} else {
		$drawing->setBarcode($code);
		$drawing->draw();
	}

	// Header that says it is an image (remove it if you save the barcode to a file)
	header('Content-Type: image/png');

	// Draw (or save) the image into PNG format.
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	die;
}
function generateQrcode($val) {
	header("Content-type: image/png");
	QRcode::png($val);
	die;
}

?>