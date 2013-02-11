<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
header('X-Frame-Options: GOFORIT');
require_once("base/config.php");
?>
<html lang="en">

<head>
<link rel="icon" type="image/jpg" href=<?php echo BASE_IMG_PATH ."favicon.png"?>/>
<title>Search v3.0 - Yahoo!, Google, Facebook, Twitter, LinkedIn - All in one place</title>
<link href='http://fonts.googleapis.com/css?family=Port+Lligat+Sans' rel='stylesheet' type='text/css'>
<link href=<?php echo BASE_CSS_PATH . "bootstrap.min.css"?> rel="stylesheet" type="text/css"/>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script src=<?php echo BASE_JS_PATH . "jquery.timeago.js"?> type="text/javascript"></script>
<link href=<?php echo BASE_CSS_PATH . "custom.css"?> rel="stylesheet" type="text/css"/>
</head>
<body >

<div class="navbar">
   <div class="navbar-inner">
    <div class="container">
	
      <a class="brand" href="#">
  Search v3.0
</a>
    </div>
  </div> 
</div>
  <div class="row-fluid" id="logobar">
    <div class="span2"><img src=<?php echo BASE_IMG_PATH ."logo.png"?> style='max-height:150px;'/></div>
    <div class="span6" >
        <!--<form class="well form-search" method="get" action="layout.php" onsubmit="getResults();"> -->
          <input type="text" id="data" class="input search-query" style="margin-top:37px; margin-left:30px;">
          <button type="submit" id="clickme" class="btn btn-primary" onclick="getResults();" style="margin-top:27px;"><i class="icon-search icon-white"></i> </button>
          
       <!-- </form> -->
    </div>
    <div class="span4" >
<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fhackyourworld.org%2F%7Eiitb_pacman%2Fsearch%2F&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=80&amp;appId=201126273248778" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;margin-top:40px;" allowTransparency="true"></iframe>
    </div>
  </div>
<div class="container-fluid">


  <div class="row-fluid">
    <div class="span2" style="margin-left:20px; margin-right:10px; margin-top:10px;">
    <div style="position:fixed;">
    	<h3>Options</h3><br><br>
      <label for="facebook"><img src=<?php echo BASE_IMG_PATH ."facebook1.png"?>> Facebook :</label><input id="facebook" name="facebook" type="range"  min="0" max="100" step="2" value="50" class="slider"/><br/><br/>
        <label for="twitter"><img src=<?php echo BASE_IMG_PATH ."twitter1.png"?>> Twitter :</label><input id="twitter" name="twitter" type="range"  min="0" max="100" step="2" value="50" class="slider"/><br/><br/>
        <label for="gplus"><img src=<?php echo BASE_IMG_PATH ."gplus1.png"?>> Google+ :</label><input id="gplus" name="gplus" type="range"  min="0" max="100" step="2" value="50" class="slider"/><br/><br/>
        <label for="linkedin"><img src=<?php echo BASE_IMG_PATH ."linkedin1.png"?>> LinkedIn :</label><input id="linkedin" name="linkedin" type="range"  min="0" max="100"  step="2" value="50" class="slider"/><br/><br/>
        <button type="submit" id="reset" class="btn btn-primary" onclick="resetSliders();" style="margin-top:10px auto;"><i class="icon-refresh icon-white"></i> Reset</button><br/><br/>
        <input type="checkbox" name="advanced_algo" id="advanced_algo" value="1" /> <label for="advanced_algo">Use Advanced Algorithm</label><br />
        </div>
    </div>
    <div class="span4" style="min-width:600px;min-height:600px;">
    <!--<h2> Search Results </h2><br/> --><br/><br/>
	<div id="results" >
		Welcome to Community Search. To begin, type a query into the search bar. To adjust the weights given to different sharing services, use the sliders in the sidebar.<br><br>
Also, here's a poem :<br>
      Two roads diverged in a yellow wood,<br>
And sorry I could not travel both<br>
And be one traveler, long I stood<br>
And looked down one as far as I could<br>
To where it bent in the undergrowth;<br><br>

Then took the other, as just as fair,<br>
And having perhaps the better claim,<br>
Because it was grassy and wanted wear;<br>
Though as for that the passing there<br>
Had worn them really about the same,<br><br>


And both that morning equally lay<br>
In leaves no step had trodden black.<br>
Oh, I kept the first for another day!<br>
Yet knowing how way leads on to way,<br>
I doubted if I should ever come back.<br><br>

I shall be telling this with a sigh<br>
Somewhere ages and ages hence:<br>
Two roads diverged in a wood, and I--<br>
I took the one less traveled by,<br>
And that has made all the difference.<br><br>
    </div>
    </div>
	<div id="social-results" class="span2">
	</div>
   <div id="social-results2" class="span2">
	</div>
  </div>
</div>
<script type="text/javascript">

	function getURLParameter(name) {
	    return decodeURIComponent(
	        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
	    );
	}

	var prev;
	var prev2;
	var prev3;
	var recd_data;
	var recd_data_soc;
	var data_tw;

	var main_data;
	var fb_data;
	var tw_data;

	var main_divs = new Array();
	var fb_divs = new Array();
	var tw_divs = new Array();
	var score = new Array();
	var pos = new Array();

	var avg = new Array();	

	var lim = 10;


	function resetSliders(){
		$('.slider').val(50);
		displayResults();
		
	}
//*
	function setAverage(){
		res2 = main_data.query.results.bossresponse.web.results.result;
		
		avg['fb_like'] = 0;
		avg['fb_share'] = 0;
		avg['fb_comment'] = 0;
		avg['twt'] = 0;
		avg['gplus'] = 0;
		avg['lin'] = 0;
		avg['sh_count'] = 1;
		avg['com_count'] = 1;
		avg['gp_count'] = 1;
		avg['twt_count'] = 1;
		avg['lin_count'] = 1;
		//console.log(avg['lin']);
		for (i = 0; i < lim; i++){
			res = res2[i].counts;
			if(res.fb_like != 0)
			{
				if(res.fb_share != 0)
				{
					avg['fb_share'] += (1.0*res.fb_like/res.fb_share);
					avg['sh_count'] += 1;
				}
				if(res.fb_comment != 0)
				{
					avg['fb_comment'] += (1.0*res.fb_like/res.fb_comment);
					avg['com_count'] += 1;
				}
				if(res.tw_count != 0)
				{
					avg['twt'] += (1.0*res.fb_like/res.tw_count);
					avg['twt_count'] += 1;
				}
				if(res.gplus_count != 0)
				{
					avg['gplus'] += (1.0*res.fb_like/res.gplus_count);
					avg['gp_count'] += 1;
				}
				if(res.lin_count != 0)
				{
					avg['lin'] += (1.0*res.fb_like/res.lin_count);
					avg['lin_count'] += 1;
				}
				//console.log(i+' '+avg['lin']);
			}
		}
		avg['fb_share'] /= avg['sh_count'];
		avg['fb_comment'] /= avg['com_count'];
		avg['gplus'] /= avg['gp_count'];
		avg['twt'] /= avg['twt_count'];
		avg['lin'] /= avg['lin_count']; 
		//console.log(avg['lin']);
	}
//*/
	function updateScores(){
		for (i = 0; i < lim; i++){
			var A = document.getElementsByClassName('score'+i);
			for (j = 0; j < A.length; j++){
				//alert(i+' '+j+' '+A[j].innerHTML);
				A[j].innerHTML = score[i];
			}
		}
	}
	
	function genResMain(){
		res = main_data.query.results.bossresponse.web.results.result;
		//alert('done');
		for (i = 0; i < res.length; i++){
			if (i >= lim) break;

			like_button_code = '';
			like_button_code = '<iframe src="//www.facebook.com/plugins/like.php?href='+encodeURIComponent(res[i].url)+'&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80&amp;appId=201126273248778" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe><br>';

			plusone_button_code = '';
			plusone_button_code = '<iframe src="social_results/ifr.php?url='+encodeURIComponent(res[i].url)+'" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" style="border:0;width:110px;height:30px;"> </iframe>';
			tweet_button_code = '';
			tweet_button_code = '<iframe allowtransparency="true" frameborder="0" scrolling="no" src="https://platform.twitter.com/widgets/tweet_button.html?url='+ encodeURIComponent(res[i].url) +'" style="width:130px; height:20px; margin-bottom:10px;"></iframe>';
		
			pos[i] = i;
			score[i] = i;
			counts = res[i].counts;
			heading = '<a href="'+res[i].url+'"><h4 class="res_main_header">'+res[i].title.content+'</h4></a>';
			url = '<span class="res_main_url">'+res[i].url+'</span>';
			abstract = '<span class="res_main_abstract">'+res[i].abstract.content+'</span>';
			stats = "<div class='res_main_stats'><span class='badge'>"+(i+1)+"</span> (fb_likes : "+counts.fb_like+", fb_shares : "+counts.fb_share+", fb_comments : "+counts.fb_comment+", twitter_shares : "+counts.tw_count+", google_plusones : "+counts.gplus_count+", linkedin_shares : "+counts.lin_count+") : <b><span class='score"+i+"'>"+score[i].toFixed(2)+"</span></b></div>";

			main_divs[i] = document.createElement('div');
			main_divs[i].setAttribute('class', 'res_main_div');
			
			main_divs[i].innerHTML = heading+''+url+'<br>'+abstract+'<br>'+stats+'<br>'+tweet_button_code+plusone_button_code+'<br>'+like_button_code;
		}
	}

	

	//*
	function calc_score(counts){
		//console.log(document.getElementById("advanced_algo").checked);		
		if (!document.getElementById("advanced_algo").checked){
		score1 = 0;
		score1 += $('#facebook').val()*0.01*(counts.fb_like + counts.fb_share + counts.fb_comment);
		score1 += $('#twitter').val()*0.01*counts.tw_count;
		score1 += $('#linkedin').val()*0.01*counts.lin_count;
		score1 += $('#gplus').val()*0.01*counts.gplus_count;
		return score1;
		}
		else{
			score1 = 0;
		score1 += $('#facebook').val()*0.01*(counts.fb_like + counts.fb_share*avg['fb_share'] + counts.fb_comment*avg['fb_comment'])/3.0;
		score1 += $('#twitter').val()*0.01*counts.tw_count*avg['twt'];
		score1 += $('#linkedin').val()*0.01*counts.lin_count*avg['lin'];
		score1 += $('#gplus').val()*0.01*counts.gplus_count*avg['gplus'];
		return score1;
		}
		
	}
	//*/
/*
	function calc_score(counts){
		score1 = 0;
		score1 += $('#facebook').val()*0.01*(counts.fb_like + counts.fb_share*avg['fb_share'] + counts.fb_comment*avg['fb_comment'])/3.0;
		score1 += $('#twitter').val()*0.01*counts.tw_count*avg['twt_count'];
		score1 += $('#linkedin').val()*0.01*counts.lin_count*avg['lin_count'];
		score1 += $('#gplus').val()*0.01*counts.gplus_count*avg['gplus_count'];
		return score1;
	}
//*/	
/*
	function append_to_results(res, score, counts){
		var res_div = document.createElement('div');
		res_div.setAttribute('class', 'result_div');
		res_div.innerHTML = "<a href = '" + res.url + "'><h4>"+ res.title.content+"</h4></a><br>"+res.url+"<br>"+res.abstract.content+"<br><b>Score : </b>"+score+"<br>(fb_likes : "+counts.fb_like+", fb_shares : "+counts.fb_share+", fb_comments : "+counts.fb_comment+", twitter_shares : "+counts.tw_count+", google_plusones : "+counts.gplus_count+", linkedivar result_array = recd_data.query.results.bossresponse.web.results.result;n_shares : "+counts.lin_count+")<br><br>"+'<iframe src="//www.facebook.com/plugins/like.php?href='+encodeURIComponent(res.url)+'&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80&amp;appId=201126273248778" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe><br>';
*/
/*
		+'<iframe allowtransparency="true" frameborder="0" scrolling="no" src="https://platform.twitter.com/widgets/tweet_button.html?url='+ encodeURIComponent(res.url) +' style="width:130px; height:20px;"></iframe><br>' + '<iframe allowtransparency="true" frameborder="0" hspace="0" id="I1_1307012621585" marginheight="0" marginwidth="0" name="I1_1307012621585" scrolling="no" src="https://plusone.google.com/u/0/_/+1/button?hl=en-US&amp;jsh=s%3Bplusone%3Agoogleapis.client%4021550740_8d71de52%2Fclient%3Bgoogleapis.proxy%4021550740_8d71de52%2Fproxy%3Bplusone%3Agoogleapis.client%3Aiframes-styles-bubble%4021550740_8d71de52%2Fbubble%3Biframes-styles-bubble!plusone%3Agoogleapis.client%4021550740_8d71de52%2Fbubble_only%3Bplusone-unsupported%4021550740_8d71de52%2Funsupported#url='+ encodeURIComponent(res.url) +'&amp;size=medium&amp;count=true&amp;id=I1_1307012621585&amp;parent='+ encodeURIComponent(res.url) +'&amp;rpctoken=982298531&amp;_methods=_ready%2C_close%2C_open%2C_resizeMe" style="width: 82px; height: 20px; position: static; left: 0px; top: 0px; visibility: visible; " tabindex="-1" vspace="0" width="100%"></iframe><br>';

		document.getElementById('results').appendChild(res_div);
	}
*/
	function displayResults(){
		// now sort and display
		setAverage();
		
					var result_array = main_data.query.results.bossresponse.web.results.result;
					//alert(data.query.results.bossresponse.web.results.result[0].url);
					
					
					//limit for sotring
					var lim = 10;
					
					for (i = 0; i < lim; i++){
						//pos[i] = i;
						score[i] = calc_score(result_array[i].counts);
						//alert('done');
						//console.log(i+' '+score[i]+' '+calc_score(result_array[i].counts)+ ' '+pos[i]);
						
						//$('.score'+i).html(score[i]);
						//alert($('.score'+i).html());
					}

					
					
					for (i = 0; i < lim; i++){
						for (j = 0; j < lim - 1; j++){
							if (score[pos[j]] < score[pos[j+1]]){
								a = pos[j];
								pos[j] = pos[j+1];
								pos[j+1] = a;
							}
						}
					}

					$("#results").html("<br>");
					
					for (i = 0; i < lim; i++){
						document.getElementById('results').appendChild(main_divs[pos[i]]);
					}

					updateScores();
					//alert('done');
	}

	function drsocial(){
		var ra = recd_data_soc.data;
		$("#social-results").html("<h3>Facebook Updates</h3><br>");
		for (var i in ra){
			if (i > 9) break;
			//alert(i+'->'+ra[i]);
			var res = document.createElement('div');
			res.setAttribute('class','res_social');
			var picture = "";
			var d = new Date(ra[i].created_time);
			if (ra[i].picture) picture = "<a href=http://facebook.com/"+ra[i].id.replace('_','/posts/')+">"+"<img src="+ra[i].picture+"></a>";
			var msg="";
			if (ra[i].message) msg = ra[i].message.substr(0,100);
			date = "<a class='timestamp' href=http://facebook.com/"+ra[i].id.replace('_','/posts/')+">"+ $.timeago(d)+"</a>";
			res.innerHTML=picture+"<h4 class='social-user'><a href=http://facebook.com/profile.php?id="+ra[i].from.id+">"+ra[i].from.name+"</a></h4>"+date+"<br>"+msg+"<br><br>";
			document.getElementById('social-results').appendChild(res);
		} 
	}

	function drsocial_tw(){
		var ra = data_tw.results;
		$("#social-results2").html("<h3>Twitter Updates</h3><br>");
		for (var i in ra){
			if (i > 9) break;
			//alert(i+'->'+ra[i]);
			var res = document.createElement('div');
			res.setAttribute('class','res_social');
			var picture = "";
			var d = new Date(ra[i].created_at);
			if (ra[i].profile_image_url) picture = "<img src="+ra[i].profile_image_url+"></a>";
			var msg="";
			if (ra[i].text) msg = ra[i].text;
			date = "<a class='timestamp' href=http://twitter.com/"+ra[i].from_user_id+"/status/"+ra[i].id_str+">"+ $.timeago(d)+"</a>";
			res.innerHTML=picture+"<h4 class='social-user'><a href=http://twitter.com/"+ra[i].from_user_id+">"+ra[i].from_user_name+"</a></h4>"+date+"<br>"+msg+"<br><br>";
			document.getElementById('social-results2').appendChild(res);
		} 
	}

	
	
	function getResults(){
		//$.param.querystring(window.location.href, 'q='+$("#data").val());
		location.hash = encodeURIComponent($("#data").val());
		$("#results").html("<img src ='http://demo.marcofolio.net/facebook_loader/images/loading.gif'>");
		$("#social-results").html("<h3>Facebook Updates</h3><br><img src ='http://demo.marcofolio.net/facebook_loader/images/loading.gif'>");
		$("#social-results2").html("<h3>Twitter Updates</h3><br><img src ='http://demo.marcofolio.net/facebook_loader/images/loading.gif'>");
		

		if (prev) prev.abort();
		prev = $.ajax({
				type: "GET",
				dataType: 'json',
				data: "q=" + $("#data").val(),
				url: "social_results/results.php",
				success: function(data){
					recd_data = data;
					main_data = data;
					genResMain();
					displayResults();
					
					//*/
					//$("#results").html(data);
				}
		});

		if (prev2) prev2.abort();
		prev2 = $.ajax({
				type: "GET",
				dataType: 'json',
				data: "q=" + $("#data").val(),
				url: "social_results/graph.php",
				success: function(data){
					recd_data_soc = data;
					drsocial();
					//alert('done');
					//*/
					//$("#results").html(data);
				}
		});

		if (prev3) prev3.abort();
		prev3 = $.ajax({
				type: "GET",
				dataType: 'json',
				data: "q=" + $("#data").val(),
				url: "social_results/tweet.php",
				success: function(data){
					data_tw = data;
					drsocial_tw();
					//alert('done');
					//*/
					//$("#results").html(data);
				}
		});

					
	}
	
	$(document).ready(function(){
		prev = null;
		$("#data").keyup(function () {
			getResults();
			
		});

		$('.slider').change(function(){
			displayResults();
		});

		var q = decodeURIComponent(location.hash.substr(1));
		if (!q) q = "latest news";
		if (q){
			//alert(q);
			$('#data').val(q);
			getResults();
		}
		$("#advanced_algo").change(function(){
			displayResults();
		}); 
/*
		$("input[type=text]").click(function() {
  			$(this).select();
		});​
*/
	
	});
	

    $("#data").autocomplete({
      select:function(event,ui){
         	getResults();
      },
      source: function( request, response ) {
        $.ajax({
          url: 'http://query.yahooapis.com/v1/public/yql',
          dataType: 'JSONP',
          data: {
            format: 'json',
            q: 'select * from xml where url="http://google.com/complete/search?output=toolbar&q=' + escape(request.term) + '"'
          },
          success: function(data) {
            response($.map(data.query.results.toplevel.CompleteSuggestion, function(item) {
            	if (item == null) return null;
              return { label: item.suggestion.data, value: item.suggestion.data };
            }));
          }
        });
      }
    });

</script>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>


</body>

</html>
