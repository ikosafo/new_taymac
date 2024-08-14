<?php

function months(){
    $mtharr  = array('Jan'=>'01', 'Feb'=>'02',
    'Mar'=>'03','Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07','Aug'=>'08',
    'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12');
    return $mtharr;
}




function getYear(){

    for($y=2015; $y<=date('Y'); $y++){
        $years[] = $y;
    }

    return $years;

}


function is_valid_xml($xml) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument('1.0', 'utf-8');
    $doc->loadXML($xml);
    $errors = libxml_get_errors();
    return empty($errors);
}

function isValidXML($xml) {
    $doc = @simplexml_load_string($xml);
    if ($doc) {
        return 'Valid'; //this is valid
    } else {
        return 'Invalid'; //this is not valid
    }
}


function recursive($array){
    foreach($array as $key => $value){
        //If $value is an array.
        if(is_array($value)){
            //We need to loop through it.
            recursive($value);
        } else{
            //It is not an array, so print it out.
            echo print_r($value), '<br>';
        }
    }
}

function roundCentsUp($value, $places)
{
	$mult = pow(10, abs($places));
	return $places < 0 ?
		ceil($value / $mult) * $mult :
		ceil($value * $mult) / $mult;
}


?>
