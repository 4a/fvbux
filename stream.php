<!DOCTYPE HTML>
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
<p class="center_text" style="position:relative;z-index:99999999999999999999999999999999">
<a href="javascript:fitwidth()" id="fittog">Fit to Width</a> /
<a href="javascript:hidechat()" id="chattog">Free Chat Box</a>
</p>
<div id="mainbox" class="nodrag">
<div id="streamconstrain">
<div class="nodrag streamwrap">
<div id="STREAMCONTAINER" class="astreamcontainer" data-site="ttv" data-chan="rickdanto" data-aspect="16:9">

<object type='application/x-shockwave-flash' height='389' width='640' id='live_embed_player_flash' data='http://www.twitch.tv/widgets/live_embed_player.swf?channel=rickdanto'><param name='allowFullScreen' value='true'>
<param name='wmode' value='transparent'>
<param name='allowScriptAccess' value='always'>
<param name='allowNetworking' value='all'>
<param name='movie' value='http://www.twitch.tv/widgets/live_embed_player.swf'>
<param name='flashvars' value='hostname=www.twitch.tv&amp;channel=rickdanto&amp;auto_play=true'></object>
<!-- livesrtedn
<object width="640" height="385" id="lsplayer" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="movie" value="http://cdn.livestream.com/grid/LSPlayer.swf?channel=losermanzero&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc"></param><param name="allowScriptAccess" value="always"></param><param name="allowFullScreen" value="true"></param><embed name="lsplayer" wmode="transparent" src="http://cdn.livestream.com/grid/LSPlayer.swf?channel=losermanzero&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc" width="640" height="385" allowScriptAccess="always" allowFullScreen="true" type="application/x-shockwave-flash"></embed></object>
-->
<input class="sitename hidden" type="text" value="ttv">
</div>

<div class="buttonwrap">
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
<embed id="emb_1328579436412" src="http://sfcii-hdr-ce.chatango.com/group" style="width:100%;height:100%" wmode="transparent" allowscriptaccess="always" allownetworking="all" type="application/x-shockwave-flash" allowfullscreen="true" flashvars="cid=1328579436411&amp;a=000000&amp;b=1&amp;c=FFFFFF&amp;d=0099FF&amp;e=000000&amp;f=50&amp;g=FFFFFF&amp;h=000000&amp;i=45&amp;j=FFFFFF&amp;k=0099FF&amp;l=333333&amp;m=0099FF&amp;n=FFFFFF&amp;q=000000&amp;r=1&amp;s=1&amp;t=0&amp;v=0&amp;w=0"></div>
</div>
<div id="chatbox">
<script id="sid0010000013401695218">(function() {function async_load(){s.id="cid0010000013401695218";s.src='http://st.chatango.com/js/gz/emb.js';s.style.cssText="width:100%;height:100%";s.async=true;s.text='{"handle":"sfcii-hdr-ce","styles":{"a":"000000","b":1,"c":"FFFFFF","d":"0099FF","e":"000000","f":50,"g":"FFFFFF","h":"000000","i":45,"j":"FFFFFF","k":"0099FF","l":"333333","m":"0099FF","n":"FFFFFF","q":"000000","r":1,"s":1,"t":0,"v":0,"w":0}}';var ss = document.getElementsByTagName('script');for (var i=0, l=ss.length; i < l; i++){if (ss[i].id=='sid0010000013401695218'){ss[i].id +='_';ss[i].parentNode.insertBefore(s, ss[i]);break;}}}var s=document.createElement('script');if (s.async==undefined){if (window.addEventListener) {addEventListener('load',async_load,false);}else if (window.attachEvent) {attachEvent('onload',async_load);}}else {async_load();}})();</script>
</div>
</div>

<table class="center_table center_text outbtns">
<tr><td>
<a class="streamoption" href="javascript:jtv(urlInput.value);"><img id="jtv-icon" title="justin/twitch" src="IS/jtv.png" alt="jusintv"></a>
<a class="streamoption" href="javascript:ust(urlInput.value);"><img id="ust-icon" title="ustream" src="IS/ust.png" alt="ustream"></a>
<a class="streamoption" href="javascript:lst(urlInput.value);"><img id="lst-icon" title="livestream" src="IS/lst.png" alt="livestream"></a>
<a class="streamoption" href="javascript:yut(urlInput.value);"><img id="yut-icon" title="youtube" src="IS/yut.png" alt="youtube"></a>
<a class="streamoption" href="javascript:o3d(urlInput.value);"><img id="o3d-icon" title="own3d" src="IS/o3d.png" alt="own3d"></a>
<a class="streamoption" href="javascript:any(urlInput.value);"><img id="any-icon" title="html/url" src="IS/any.png" alt="html"></a>
<input class="waifubox" type="search" placeholder="No Waifus Allowed" id="urlInput" onkeydown="if (event.keyCode == 13) waifu(this.value)"> 
<input class="hidden" type="text" id="sitename" value="ttv">
</td></tr>
</table>

<table id="demstreams" class="center_table">
<tr>
<td class="outbtns">
	<div class="slidetitle">
		<a href="javascript:geton();slideonlyone('onboxes')">Online</a>
	</div>
	<div id="onboxes" title="" class="boxdiv block">
	  <ul class="sc_menu" id="oncont">
	  <li></li>
	  </ul>
	</div>
</td>
</tr>
<tr>
<td class="outbtns">
	<div class="slidetitle">
		<a href="javascript:getoff();slideonlyone('offboxes')">Offline</a>
	</div>
	<div id="offboxes" title="" class="starthide boxdiv">
	  <ul class="sc_menu" id="offcont">
          <?php
          include 'PHP/data.php';
          ?>
          </ul>
	</div>
</td>
</tr>
<tr>
<td class="outbtns">
	<div class="slidetitle">
		<a href="javascript:getother();slideonlyone('otherboxes')">Other</a>
	</div>
	<div id="otherboxes" title="" class="starthide boxdiv">
	  <ul class="sc_menu" id="othercont">
          <li></li>
          </ul>
	</div>
</td>
</tr>
</table>
	<div id="toggler"><img alt=" " src="images/blnk.gif" height="40" width="40"></div>
</body>
</html>