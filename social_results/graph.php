<?php
require_once("../base/config.php");

function getResults($search){
    $url = "https://graph.facebook.com/search";
    $fields = array(
                'q'=>$search,
          );
    $fields_string = http_build_query($fields);
    //echo $fields_string;
    $url = $url."?".$fields_string;
    $temp = setCurl($url);
    return $temp;
}
$search = $_REQUEST['q'];
$returndata = getResults($search);
echo $returndata;
/*$array = json_decode($returndata, true);
echo "<pre>";
print_r($array);
echo "</pre>";
*/
?>