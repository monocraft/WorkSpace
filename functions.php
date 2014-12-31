<?php
function status_set($xcrud)
{
    $developer = array("nuen", "admin");
   if ($xcrud->get('primary') !== false)
    {
        
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `Status`,`LoginName` FROM `Employees` WHERE EmployeeID = ' . (int)$xcrud->get('primary');
        $db->query($query);
        $result = $db->result();
        if (!in_array($result[0]['LoginName'], $developer)){
    		if ($result[0]['Status'] == '1')
    		{
    			$query = 'UPDATE Employees SET `Status` = \'0\' WHERE EmployeeID = ' . (int)$xcrud->get('primary');
    		}
    		else
    		{
    			$query = 'UPDATE Employees SET `Status` = \'1\' WHERE EmployeeID = ' . (int)$xcrud->get('primary');
    		}
        
            $db->query($query);
        }
        else {
            return;
        }
		//echo '<pre>'; // This is for correct handling of newlines
		//var_dump($result);
		//echo '</pre>';
    }

}


function publish_action($xcrud)
{	

    if ($xcrud->get('primary'))
    {
        //$db = Xcrud_db::get_instance();
        //$query = 'UPDATE employees SET `status` = \'0\' WHERE id = ' . (int)$xcrud->get('primary');
        //$db->query($query);
    }
}
function unpublish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $xcrud)
{
    // get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
    // set error message
    $xcrud->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud)
{
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload')
    {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function movetop($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != 0)
            {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}
function movebottom($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != $count - 1)
            {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function show_description($value, $fieldname, $primary_key, $row, $xcrud)
{
    $result = '';
    if ($value == '1')
    {
        $result = '<i class="fa fa-check" />' . 'OK';
    }
    elseif ($value == '2')
    {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $xcrud)
{
    return '<input type="text" readonly class="xcrud-input" name="' . $xcrud->fieldname_encode($fieldname) . '" value="' . $value .
        '" />';
}
function unset_val($postdata)
{
    $postdata->del('Paid');
}

function format_phone($new_phone)
{
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $xcrud)
{
    var_dump($list);
}

/* My Custome Function */
function alter_date($value, $fieldname, $primary_key, $row, $xcrud)
{
	$now = time();
    $etime = $now - strtotime($value);

    if ($etime < 1)
    {
        return '0 seconds N';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return ($etime < 500000 ? '<span class="lead-NEW"></span> ' : ''). $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
        }
    }
}

function alter_vt($value, $fieldname, $primary_key, $row, $xcrud)
{
	$vt = '<a href="javascript:void(0);" class="xcrud-action" data-task="edit" data-primary="'.$primary_key.'"><i class="fa fa-male state-'.$row['vendor.VendorType'].'"> '.$value.'</i></a>';
	return $vt;
}
function role_cb($value, $fieldname, $primary_key, $row, $xcrud)
{
	$vt = '<i class="fa fa-male state-'.$row['employees.role'].'"></i>'. $value;
	return $vt;
}
function repl_locations($postdata)
{
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Œ', 'œ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Š', 'š', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Ÿ', '?', '?', '?', '?', 'Ž', 'ž', '?', 'ƒ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'); $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	$arrco = explode(",", $postdata->get('geolocation'));
	$postdata->set('latco', $arrco[0]);
	$postdata->set('lonco', $arrco[1]);
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$arrco[0].",".$arrco[1]."&sensor=false"."&region=NL";
	$json = @file_get_contents($url);
	$data = json_decode($json);
	$status = $data->status;
	$address = '';
		if($status == "OK") {
			$arradr = explode(",", $data->results[0]->formatted_address);
			$address = $arradr[0]; $state = $arradr[1];
		}
	$postdata->set('city', substr(strrchr($state, " "), 1));
	$postdata->set('state', trim($state, " "));
	$postdata->set('address', str_replace($a, $b, $address));
}

function repl_locationslt($postdata)
{
	// geolocation is your MySql field "point type" 
	$arrco = explode(",", $postdata->get('geolocation'));
	// lat and long are your MySql fields 
	$postdata->set('lat', $arrco[0] );
	$postdata->set('long', $arrco[1] );
}

function salt_password($postdata, $xcrud){
	$pass = $postdata->get('LoginPassword');
	$hashpass = hash('sha512', $pass);

	//Random a salt
	$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
	// Create salted password 
	$password = hash('sha512', $hashpass . $random_salt);
	$postdata->set('Salt', $random_salt );
	$postdata->set('LoginPassword', $password );

}
function password_update($postdata, $xcrud){
	$pass = $postdata->get('LoginPassword');
	$salt = $postdata->get('Salt');
	//echo var_dump($salt);
	//echo var_dump($pass);
	if (empty($salt)){
		$salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
	}
	if( !$pass == FALSE ) {  //user did not touch password
		$hashpass = hash('sha512', $pass);
		$password = hash('sha512', $hashpass . $salt);
		$postdata->set('Salt', $salt );
		$postdata->set('LoginPassword', $password );
	}
}