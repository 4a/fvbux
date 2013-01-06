<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<title>Fightan' /v/idya</title>
<meta name="description" content="All Waifu, No Fightan"><!--Description for search engines-->
<link rel="shortcut icon" href="FV.ico" >
<link rel="stylesheet" type="text/css" href="CSS/newfightans.css" title="newfightans" media="screen">
<link rel="alternate stylesheet" type="text/css" href="CSS/robotpuke.css" title="robotpuke" media="screen">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="JS/newfightans.js"></script>
<script type="text/javascript" src="JS/stylesheetToggle.js"></script>
<script type="text/javascript">
var update;
function geton() {
    $.get('PHP/data.php?live=1',
      function(data) {
        clearTimeout(update);
        $('#oncont').html(data);
        update = setTimeout(geton,120000);
      })
}
function getoff() {
    $.get('PHP/data.php?live=0',
      function(data) {
        $('#offcont').html(data);
        clearTimeout(update);
      })
}
function getother() {
    $.get('PHP/data.php?live=2',
      function(data) {
        $('#othercont').html(data);
        clearTimeout(update);
      })
}
geton();

function slideonlyone(thechosenone) {
     $('div[title=""]').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).slideDown(400);
          }
          else {
               $(this).slideUp(400);
          }
     });
}
        $(document).ready(pageLoaded);
	$(function()
		{
			// Call stylesheet init so that all stylesheet changing functions 
			// will work.
			$.stylesheetInit();
			
			// This code loops through the stylesheets when you click the link with 
			// an ID of "toggler" below.
			$('#toggler').bind(
				'click',
				function(e)
				{
					$.stylesheetToggle();
					chatangostyle();					
					return false;
				}
			);
			
			// When one of the styleswitch links is clicked then switch the stylesheet to
			// the one matching the value of that links rel attribute.
			$('.styleswitch').bind(
				'click',
				function(e)
				{
					$.stylesheetSwitch(this.getAttribute('rel'));
					return false;
				}
			);
		}
	);
</script>
</head>
<body>

<?php
include 'menu.php';
?>
<div class="rpmenu">

</div>
<p class="center_text">
<a href="javascript:fitwidth()" id="fittog">Fit to Width</a> /
<a href="javascript:hidechat()" id="chattog">Free Chat Box</a>
</p>
<div id="mainbox" class="nodrag">
<div id="streamconstrain">
<div class="nodrag streamwrap">
<div id="STREAMCONTAINER" class="astreamcontainer">
<object type='application/x-shockwave-flash' height='389' width='640' id='live_embed_player_flash' data='http://www.twitch.tv/widgets/live_embed_player.swf?channel=rickdanto'><param name='allowFullScreen' value='true'>
<param name='wmode' value='transparent'>
<param name='allowScriptAccess' value='always'>
<param name='allowNetworking' value='all'>
<param name='movie' value='http://www.twitch.tv/widgets/live_embed_player.swf'>
<param name='flashvars' value='hostname=www.twitch.tv&amp;channel=rickdanto&amp;auto_play=true&amp'></object>

<!--Livestream
<object width="640" height="385" id="lsplayer" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="movie" value="http://cdn.livestream.com/grid/LSPlayer.swf?channel=losermanzero&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc"></param><param name="allowScriptAccess" value="always"></param><param name="allowFullScreen" value="true"></param><embed name="lsplayer" wmode="transparent" src="http://cdn.livestream.com/grid/LSPlayer.swf?channel=losermanzero&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc" width="640" height="385" allowScriptAccess="always" allowFullScreen="true" type="application/x-shockwave-flash"></embed></object>
-->
<input class="sitename hidden" type="text" value="ttv">
</div>

<div class="buttonwrap" style="display:none">
<br>
<div class="c1">
				<span class="newchanbutton">+</span>
				<span class="removebutton">&nbsp;&nbsp;&nbsp;-</span>
</div>

<div class="c2">
				<span class="isactivebutton">&#9733;</span>
				<span class="makeactivebutton">&#9734;</span>
</div>

			<span class="resizewrap c3">
				<span class="resize">&#8644;</span><br>resize
			</span>
<br>
		</div>
</div>
<div id="walllol"></div>
<div id="chatbox2">
<iframe src="http://qchat.rizon.net/?channels=Robotpuke" width="100%" height="100%" frameborder="0"></iframe>
</div>
</div>
<div id="chatbox">
<iframe src="http://qchat.rizon.net/?channels=Robotpuke" width="100%" height="100%" frameborder="0"></iframe>
</div>
</div>

<table class="center_table" width="100%">
<tr><td align='center'>
<a class="streamoption" href="javascript:jtv(urlInput.value);">
<img id="jtv-icon" title="justin/twitch" src="IS/jtv.png" alt="jusintv"></a> 
<a class="streamoption" href="javascript:ust(urlInput.value);">
<img id="ust-icon" title="ustream" src="IS/ust.png" alt="ustream"></a>
<a class="streamoption" href="javascript:lst(urlInput.value);">
<img id="lst-icon" title="livestream" src="IS/lst.png" alt="livestream"></a> 
<a class="streamoption" href="javascript:yut(urlInput.value);">
<img id="yut-icon" title="youtube" src="IS/yut.png" alt="youtube"></a>
<a class="streamoption" href="javascript:o3d(urlInput.value);">
<img id="o3d-icon" title="own3d" src="IS/o3d.png" alt="own3d"></a> 
<a class="streamoption" href="javascript:any(urlInput.value);">
<img id="any-icon" title="html/url" src="IS/any.png" alt="html"></a>
<input class="waifubox" type="search" placeholder="No Waifus Allowed" id="urlInput" onkeydown="if (event.keyCode == 13) waifu(this.value);"> 
<input class="hidden" type="text" id="sitename" value="ttv">
</td></tr>
</table>

<table id="demstreams" class="center_table">
<tr>
<td class="outbtns">
	<div class="slidetitle">
		<a href="javascript:geton();slideonlyone('onboxes')" >Online</a>
	</div>
	<div id="onboxes" title="" class="boxdiv block" style="max-width:750px">
	  <ul class="sc_menu" id="oncont">
          <li></li>
	  </ul>
	</div>
</td>
</tr>
<tr>
<td class="outbtns">
	<div class="slidetitle">
		<a href="javascript:getoff();slideonlyone('offboxes')" >Offline</a>
	</div>
	<div id="offboxes" title="" class="starthide boxdiv" style="max-width:750px">
	  <ul class="sc_menu" id="offcont">
          <?php
          include 'PHP/data.php';
          $live = 0;
          ?>
          </ul>
	</div>
</td>
</tr>
<tr>
<td class="outbtns">
	<div class="slidetitle">
		<a href="javascript:getother();slideonlyone('otherboxes')" >Other</a>
	</div>
	<div id="otherboxes" title="" class="starthide boxdiv" style="max-width:750px">
	  <ul class="sc_menu" id="othercont">
          <li></li>
	  </ul>
	</div>
</td>
</tr>
</table>
	<div id="toggler"><img alt=" " src="images/blnk.gif" height="40px" width="40px"></div>
</body>
</html>