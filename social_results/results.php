<?php  
require_once("../base/config.php");

function getResults($search){
    $url = "https://query.yahooapis.com/v1/public/yql";
    $env = "store://datatables.org/alltableswithkeys";
    $query = 'select * from boss.search(2) where q="'. $search .'" and ck="dj0yJmk9YWF3ODdGNWZPYjg2JmQ9WVdrOWVsWlZNRk5KTldFbWNHbzlNVEEyTURFNU1qWXkmcz1jb25zdW1lcnNlY3JldCZ4PTUz" and secret="a3d93853ba3bad8a99a175e8ffa90a702cd08cfa"';
    $fields = array(
                'q'=>$query,
                'format'=>'json',
                'env'=>$env,
          );
    $fields_string = http_build_query($fields);
    //echo $fields_string;
    $url = $url."?".$fields_string;
    $temp = setCurl($url);
    return $temp;
}

$search = $_REQUEST['q'];
$returndata = getResults($search);
//return the JSON
//echo $returndata;
//*
$array = json_decode($returndata, true);
//echo "<pre>";
//print_r($array);

foreach($array['query']['results']['bossresponse']['web']['results']['result'] as $index => &$result){
	//echo $index." : ".$result['url']."<br/>";
	if (intval($index) < 10){
//*
	//echo $index." : ".$result['url']."<br/>";
	$url = "http://hackyourworld.org/~iitb_pacman/get_counts.php";
	$fields = array(
                'q'=>$result['url'],
          );
    $fields_string = http_build_query($fields);
    $url = $url."?".$fields_string;
    $temp = setCurl($url);
	//echo "<br><br>" . $temp . "<br><br>";
    $result['counts'] = json_decode($temp, true);
//*/
    }
}

//echo json_encode($array);
echo str_replace('\/','/',json_encode($array));
//echo "<pre>".print_r($array)."</pre>";
//*/
?>
