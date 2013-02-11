<?php  
require_once("../base/config.php");

$count = array();

function getFbCounts($link){
    $url = "https://graph.facebook.com/fql";
    //$env = "store://datatables.org/alltableswithkeys";
    $query = "SELECT url, normalized_url, share_count, like_count, comment_count, total_count,
commentsbox_count, comments_fbid, click_count FROM link_stat WHERE url=\"$link\"";
    $fields = array(
                'q'=>$query,
          );
    $fields_string = http_build_query($fields);
    //echo $fields_string;
    $url = $url."?".$fields_string;
    $fb_res = setCurl($url);
	 $fb_array = json_decode($fb_res, true);

	 global $count;
	 
    $count['fb_like'] = intval($fb_array['data'][0]['like_count']);
    $count['fb_share'] = intval($fb_array['data'][0]['share_count']);
    $count['fb_comment'] = intval($fb_array['data'][0]['comment_count']);
    $count['fb_click'] = intval($fb_array['data'][0]['click_count']);
}

function getTwitterCounts($link){
    $url = "http://urls.api.twitter.com/1/urls/count.json";
    $fields = array(
                'url'=>$link,
          );
    $fields_string = http_build_query($fields);
    //echo $fields_string;
    $url = $url."?".$fields_string;
    $t_res = setCurl($url);
	 $t_array = json_decode($t_res, true);

	 global $count;
	 
    $count['tw_count'] = intval($t_array['count']);
}

function jsonp_decode($jsonp, $assoc = false) { // PHP 5.3 adds depth as third parameter to json_decode
    if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
       $jsonp = substr($jsonp, strpos($jsonp, '('));
    }
    return json_decode(trim($jsonp,'();'), $assoc);
}

function getLinCounts($link){
    $url = "http://www.linkedin.com/countserv/count/share";
    $fields = array(
                'url'=>$link,
          );
    $fields_string = http_build_query($fields);
    //echo $fields_string;
    $url = $url."?".$fields_string;
    $t_res = setCurl($url);
	 $t_array = jsonp_decode($t_res, true);

	 global $count;
	 
    $count['lin_count'] = intval($t_array['count']);
}


function getPlusCounts($link){
	//$url = 'https://plusone.google.com/u/0/_/+1/fastbutton?count=true&url='.$_REQUEST['q'];
	//$temp = setCurl($url);
	
    $url = "https://plusone.google.com/u/0/_/+1/fastbutton";
    $fields = array(
                'url'=>$link,
                'count'=>'true', 
          );
    $fields_string = http_build_query($fields);
    //echo $fields_string;
    $url = $url."?".$fields_string;
	 //echo "<a href='".$url."'>$url</a>";
    $t_res = setCurl($url);
	 preg_match('/window.__SSR = .c. ([0-9]*).0/', $t_res, $matches);
	 // $t_res = "sdfdkjf dshdvd sdfkjfdsf  fsdfsfjsf this_is_it123456it_is_this fdhjfhdsfkjl dsjhsjfhdskfhjjsfkjs fs";
	 global $count;
	 if (count($matches) >= 2) $count['gplus_count'] = $matches[1];
	 else $count['gplus_count'] = 0;
}


function getCounts($search){
	getFbCounts($search);
	getTwitterCounts($search);
	getLinCounts($search);
	getPlusCounts($search);
}


$search = $_REQUEST['q'];
getCounts($search);
//echo "<pre>";
echo json_encode($count);
//echo "</pre>";
?>
