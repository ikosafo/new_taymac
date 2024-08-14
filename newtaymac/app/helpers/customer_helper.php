<?php

/**
 * This is a helper function for all activities dealing with customer mamagement
 */

//This function breaks multiple google domains into parts

function breakGoogleDomain($googleid){
    if (strpos($googleid, ',') == false) {

        echo '<a href="'.URLROOT.'/subscriptions/googlesubscriptions/'.$googleid.'">'.$googleid.'</a>';
        }else{
            $array = explode(',', $googleid);
            for($i=0; $i<count($array); $i++){
            echo '<a href="'.URLROOT.'/subscriptions/googlesubscriptions/'.$array[$i].'">'.$array[$i].'</a>'.'<br/>';
            }
    }
}


//linking customers to subscriptions
function sublink($type, $tenantid, $customer,$mscat = 'office'){

    if($mscat == 'office'){
        $method = 'microsoftsubscriptions';
    } elseif($mscat == 'azure'){
        $method = 'azuredata';
    }

    // The next line causes problems in at least the admin view of customers. Why is this here Prince?
    // if($type == 'DE'){ $type = 'Germany';}

    // because of the elimination of the previous line, next line must change also
    if($type == 'Global' || $type == 'DE'){
    return '<a href="'.URLROOT.'/subscriptions/'.$method.'/'.$type.'/'.$tenantid.'">'.$customer.'</a>';
    }
    else{
        return '<a href="">'.$customer.'</a>';
    }
 }


?>
