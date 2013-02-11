<?php
require_once("../base/config.php");

function twitterStatusUrlConverter($status,$targetBlank=true,$linkMaxLen=250){
 
  // The target
  $target=$targetBlank ? " target=\"_blank\" " : "";
 
    // convert link to url
    $status = preg_replace("/((http:\/\/|https:\/\/)[^ )
]+)/e", "'<a href=\"$1\" title=\"$1\"  $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);
 
    // convert @ to follow
    $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
 
    // convert # to search
    $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"http://search.twitter.com/search?q=%23$2\" title=\"Search $1\" $target >$1</a>",$status);
 
    // return the status
    return $status;
}

function getResults($search){
    $url = "https://search.twitter.com/search.json";
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

$array = json_decode($returndata, true);

$array['results'];
for ($i = 0; $i < count($array['results']); $i = $i + 1){
	$array['results'][$i]['text'] = twitterStatusUrlConverter($array['results'][$i]['text']);
}
$returndata = str_replace('\\/', '/', json_encode($array));
echo $returndata;
/*$array = json_decode($returndata, true);
echo "<pre>";
print_r($array);
echo "</pre>";
*/
?>
