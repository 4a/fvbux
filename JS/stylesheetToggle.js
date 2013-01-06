/**
* Stylesheet toggle variation on styleswitch stylesheet switcher.
* Built on jQuery.
* Under an CC Attribution, Share Alike License.
* By Kelvin Luck ( http://www.kelvinluck.com/ )
**/
var style = 0;
function chatangostyle() {
if (style == 0) {
$('#chatbox,#chatbox2').html('<object width="100%" height="100%" id="obj_1316577201448"><param name="movie" value="http://sfcii-hdr-ce.chatango.com/group"/><param name="wmode" value="transparent"/><param name="AllowScriptAccess" VALUE="always"/><param name="AllowNetworking" VALUE="all"/><param name="AllowFullScreen" VALUE="true"/><param name="flashvars" value="cid=1316577201448&a=1A1A1A&b=2&c=0099FF&d=0099FF&e=1A1A1A&f=71&g=FFFFFF&h=1A1A1A&i=72&j=FFFFFF&k=0099FF&l=333333&m=0099FF&n=FFFFFF&o=75&s=1&t=0&v=0&w=0"/><embed id="emb_1316577201448" src="http://sfcii-hdr-ce.chatango.com/group" width="100%" height="100%" wmode="transparent" allowScriptAccess="always" allowNetworking="all" type="application/x-shockwave-flash" allowFullScreen="true" flashvars="cid=1316577201448&a=1A1A1A&b=2&c=0099FF&d=0099FF&e=1A1A1A&f=71&g=FFFFFF&h=1A1A1A&i=72&j=FFFFFF&k=0099FF&l=333333&m=0099FF&n=FFFFFF&o=75&s=1&t=0&v=0&w=0"></embed></object>');
$('.rpmenu').html('<a href="index.php"><img alt="Fightan /v/idya" src="images/deadforever.png" height="100px"></a><br><a href="stream"><img alt="Stream" src="SI/STREAMs.png"></a><img alt="/" src="SI/SPACE.png"><img alt="Netplay" src="SI/NETPLAYs.png"><img alt="/" src="SI/SPACE.png"><a href="games"><img alt="Games" src="SI/GAMESs.png"></a><img alt="/" src="SI/SPACE.png"><a href="wiki/index.php?title=Skull_Girls#PSN"><img alt="Players" src="SI/PLAYERSs.png"></a><img alt="/" src="SI/SPACE.png"><a href="wiki"><img alt="Guides" src="SI/GUIDESs.png"></a><img alt="/" src="SI/SPACE.png"><a href="img"><img alt="Blame :U" src="SI/BLAMEUs.png"></a>');
style = 1;}
else {
$('#chatbox,#chatbox2').html('<object width="100%" height="100%" id="obj_1328579436411"><param name="movie" value="http://sfcii-hdr-ce.chatango.com/group"><param name="wmode" value="transparent"><param name="AllowScriptAccess" value="always"><param name="AllowNetworking" value="all"><param name="AllowFullScreen" value="true"><param name="flashvars" value="cid=1328579436411&amp;a=000000&amp;b=1&amp;c=FFFFFF&amp;d=0099FF&amp;e=000000&amp;f=50&amp;g=FFFFFF&amp;h=000000&amp;i=45&amp;j=FFFFFF&amp;k=0099FF&amp;l=333333&amp;m=0099FF&amp;n=FFFFFF&amp;q=000000&amp;r=1&amp;s=1&amp;t=0&amp;v=0&amp;w=0"><embed id="emb_1328579436411" src="http://sfcii-hdr-ce.chatango.com/group" width="100%" height="100%" wmode="transparent" allowscriptaccess="always" allownetworking="all" type="application/x-shockwave-flash" allowfullscreen="true" flashvars="cid=1328579436411&amp;a=000000&amp;b=1&amp;c=FFFFFF&amp;d=0099FF&amp;e=000000&amp;f=50&amp;g=FFFFFF&amp;h=000000&amp;i=45&amp;j=FFFFFF&amp;k=0099FF&amp;l=333333&amp;m=0099FF&amp;n=FFFFFF&amp;q=000000&amp;r=1&amp;s=1&amp;t=0&amp;v=0&amp;w=0"></object>');
style = 0;}
}

(function($)
	{
		// Local vars for toggle
		var availableStylesheets = [];
		var activeStylesheetIndex = 0;
		
		// To loop through available stylesheets
		$.stylesheetToggle = function()
		{
			activeStylesheetIndex ++;
			activeStylesheetIndex %= availableStylesheets.length;
			$.stylesheetSwitch(availableStylesheets[activeStylesheetIndex]);
		};
		
		// To switch to a specific named stylesheet
		$.stylesheetSwitch = function(styleName)
		{
			$('link[@rel*=style][title]').each(
				function(i) 
				{
					this.disabled = true;
					if (this.getAttribute('title') == styleName) {
						this.disabled = false;
						activeStylesheetIndex = i;
					}
				}
			);
//			createCookie('style', styleName, 365);
		};
		
		// To initialise the stylesheet with it's 
		$.stylesheetInit = function()
		{
			$('link[rel*=style][title]').each(
				function(i) 
				{
					availableStylesheets.push(this.getAttribute('title'));
				}
			);
			var c = readCookie('style');
			if (c) {
				$.stylesheetSwitch(c);
			}
		};
	}
)(jQuery);

// cookie functions http://www.quirksmode.org/js/cookies.html
function createCookie(name,value,days)
{
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name)
{
	createCookie(name,"",-1);
}
// /cookie functions