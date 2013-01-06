var fit = 0, chat = 0;

function pageLoaded(){//note--can place a stream function in here to auto-select stream
	streamwrap = $(".streamwrap");
	setChannelListeners(streamwrap);
	$(".makeactivebutton").hide();
	$(".playbutton").hide();
	$("body").mouseup(endResize);
}

function newChannel(target){
	jqt = $(target);
	streamwrap = jqt.parents(".streamwrap");
	newstream = streamwrap.clone();
	newstream.insertBefore("#walllol");
	newstream.ready(function(){
		setChannelListeners(newstream);
		newstream.find(".makeactivebutton").show();
		newstream.find(".isactivebutton").hide();
		newstream.find(".astreamcontainer").removeAttr("id");//clears ID on the new channel
	});
}

function setChannelListeners(jqt){
	jqt.find(".resize").mousedown(function(event){startResize(event.target)});
	jqt.find(".newchanbutton").click(function(event){newChannel(event.target)});
	jqt.find(".makeactivebutton").click(function(event){makeActive(event.target)});
	jqt.find(".removebutton").click(function(event){removeChannel(event.target)});
	//jqt.find(".playbutton").click(function(event){resume(event.target)});
	//jqt.find(".pausebutton").click(function(event){pause(event.target)});
}

function makeActive(target){
	oldactive = $("#STREAMCONTAINER").parent();
	oldactive.find(".isactivebutton").hide();
	oldactive.find(".makeactivebutton").show();
	$("#STREAMCONTAINER").removeAttr("id");
	console.log("Making active...");
	newactive = $(target).parents(".streamwrap");
	newactive.find(".astreamcontainer").attr("id", "STREAMCONTAINER");
	newactive.find(".isactivebutton").show();
	newactive.find(".makeactivebutton").hide();
}

function makePassive(target){
	jqt = $(target);
}

function removeChannel(target){
	jqt = $(target).parents(".streamwrap");
	jqt.remove();
}

function startResize(target){
    var mainW = document.getElementById("mainbox").offsetWidth;
    var chatW = document.getElementById("chatbox").offsetWidth;
    var streamW = document.getElementById("streamconstrain").offsetWidth;
    var playerW = mainW - chatW;
    var playerH = (playerW / (16 / 9));
	var streamObj = $(target).parents('.streamwrap').find('object');
	var streamEmb = $(target).parents('.streamwrap').find('embed');
	var streamIfr = $(target).parents('.streamwrap').find('iframe');	
	window.resizeX = null;
	window.resizeY = null;
	$("body").mousemove(function(event){
		if(window.resizeX != null){
			xDif = event.pageX - window.resizeX;
			window.resizeX = event.pageX;
			yDif = event.pageY - window.resizeY;
			window.resizeY = event.pageY;
			if (streamIfr.length) {
			curWidth = parseInt(streamIfr.attr("width"), 10);
			curHeight = parseInt(streamIfr.attr("height"), 10);
			} else {
			curWidth = parseInt(streamObj.attr("width"), 10);
			curHeight = parseInt(streamObj.attr("height"), 10);}
			newWidth = xDif + curWidth;
			if (newWidth > playerW) {
			constrainWidth = playerW;}
			else if (newWidth <= ((playerW / 2) + 10) && newWidth >= ((playerW / 2) - 10)) {
			constrainWidth = (playerW / 2);}
			else if (newWidth <= ((playerW / 3) + 10) && newWidth >= ((playerW / 3) - 10)) {
			constrainWidth = (playerW / 3);}
			else if (newWidth <= ((playerW * (2 / 3)) + 10) && newWidth >= ((playerW * (2 / 3)) - 10)) {
			constrainWidth = (playerW * (2 / 3));}
			else {
			constrainWidth = newWidth;}
			newHeight = yDif + curHeight;
			if (streamObj.length) {
			streamObj.attr("width", constrainWidth);
			streamObj.attr("height", newHeight);}
			if (streamEmb.length) {
			streamEmb.attr("width", constrainWidth);
			streamEmb.attr("height", newHeight);}
			if (streamIfr.length) {
			streamIfr.attr("width", constrainWidth);
			streamIfr.attr("height", newHeight);}
		} else {
			window.resizeX = event.pageX;
			window.resizeY = event.pageY;
		}
	});
}

function endResize(){
	$("body").unbind('mousemove');
}

function fitwidth() {
    "use strict";
    var availW, mainW, chatW, constrainW, newconstrainW, embedCode, i, len, streamW, playerW, playerH, bar;
    availW = $(window).width();
    $('#mainbox').css('max-width', 'none');
    $('#streamconstrain').css('max-width', 'none');
    if (fit === 0) {
        $('#mainbox').width(availW - 70);
        if ($('#mainbox').width() < 970) {
            $('#chatbox').width(330);
        } else {
            $('#chatbox').width(400);
        }
        $('#fittog').html("Center");
        fit = 1;
    } else if (fit === 1) {
        $('#mainbox').width(970);
        $('#chatbox').width(330);
        $('#fittog').html("Fit to Width");
        fit = 0;
    } else {
        return false;
    }
    mainW = $('#mainbox').width();
    chatW = $('#chatbox').width();
    constrainW = $('#streamconstrain').width();
    newconstrainW = mainW - chatW;
    embedCode = $('.streamwrap');
    for (i = 0, len = embedCode.length; i < len; i += 1) {
        streamW = $('.streamwrap:eq(' + i + ')').width();
        if (embedCode.length === 1) {
            playerW = newconstrainW;
        } else {
            playerW = Math.floor(newconstrainW * (streamW / constrainW));
        }
        playerH = (playerW / (16 / 9));
        if ($('.streamwrap:eq(' + i + ')').find('.sitename').val() === "ttv") {
            bar = 29;
        } else if ($('.streamwrap:eq(' + i + ')').find('.sitename').val() === "jtv") {
            bar = 29;
        } else if ($('.streamwrap:eq(' + i + ')').find('.sitename').val() === 'ust') {
            bar = 32;
        } else if ($('.streamwrap:eq(' + i + ')').find('.sitename').val() === 'lst') {
            bar = 25;
        } else {
            bar = 0;
        }
        if (embedCode[i].getElementsByTagName("object").length) {
            embedCode[i].getElementsByTagName("object")[0].setAttribute("width", playerW);
            embedCode[i].getElementsByTagName("object")[0].setAttribute("height", (playerH + bar));
        }
        if (embedCode[i].getElementsByTagName("embed").length) {
            embedCode[i].getElementsByTagName("embed")[0].setAttribute("width", playerW);
            embedCode[i].getElementsByTagName("embed")[0].setAttribute("height", playerH + bar);
        }
        if (embedCode[i].getElementsByTagName("iframe").length) {
            embedCode[i].getElementsByTagName("iframe")[0].setAttribute("width", playerW);
            embedCode[i].getElementsByTagName("iframe")[0].setAttribute("height", playerH);
        }
    }
    $('#streamconstrain').width(newconstrainW);
}

function hidechat() {
	if (chat == 0) {
		$('#chatbox').hide();
		$('#chatbox2').show();
		$('#fittog').html("Disabled");
		document.getElementById("mainbox").style.maxWidth = "100%";
	        document.getElementById("streamconstrain").style.maxWidth = "100%";
		document.getElementById("mainbox").style.width = "100%";
		document.getElementById("streamconstrain").style.width = "100%";
		$('#chattog').html("Hide Chat Box");
		fit = 2;
		chat = 1;
		mainW = document.getElementById("mainbox").offsetWidth;
		chatW = document.getElementById("chatbox").offsetWidth;
		playerW = mainW - chatW;
		document.getElementById("streamconstrain").style.width = playerW;
	} else if (chat == 1) {
		$('#chatbox2').hide();
		$('#chattog').html("Fixed Chat Box");
		$('#fittog').html("Center");
		fit = 1;
		chat = 2;
		mainW = document.getElementById("mainbox").offsetWidth;
		chatW = document.getElementById("chatbox").offsetWidth;
		playerW = mainW - chatW;
		document.getElementById("streamconstrain").style.width = playerW;
	} else {
		$('#chatbox').show();
		$('#chattog').html("Free Chat Box");
		chat = 0;
		mainW = document.getElementById("mainbox").offsetWidth;
		chatW = document.getElementById("chatbox").offsetWidth;
		playerW = mainW - chatW;
		document.getElementById("streamconstrain").style.width = playerW;
	}
}

function jtv(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = $("#STREAMCONTAINER").width();
    var playerH = (playerW / (16 / 9)) + 29;
    var a = document.createElement('a');
    if ((obj.toLowerCase().substr(0, 9) === "justin.tv") || (obj.toLowerCase().substr(0, 10) === "justin.tv/") || (obj.toLowerCase().substr(0, 13) === "www.justin.tv") || (obj.toLowerCase().substr(0, 14) === "www.justin.tv/") || (obj.toLowerCase().substr(0, 9) === "twitch.tv") || (obj.toLowerCase().substr(0, 10) === "twitch.tv/") || (obj.toLowerCase().substr(0, 13) === "www.twitch.tv") || (obj.toLowerCase().substr(0, 14) === "www.twitch.tv/")) {
        a.href = 'http://' + obj;
    }
    else if ((obj.toLowerCase().substr(0, 17) !== "http://justin.tv/") && (obj.toLowerCase().substr(0, 18) !== "https://justin.tv/") && (obj.toLowerCase().substr(0, 21) !== "http://www.justin.tv/") && (obj.toLowerCase().substr(0, 22) !== "https://www.justin.tv/") && (obj.toLowerCase().substr(0, 17) !== "http://twitch.tv/") && (obj.toLowerCase().substr(0, 18) !== "https://twitch.tv/") && (obj.toLowerCase().substr(0, 21) !== "http://www.twitch.tv/") && (obj.toLowerCase().substr(0, 22) !== "https://www.twitch.tv/")) {
        a.href = 'http://justin.tv/' + obj;
    }
    else {
        a.href = obj;
    }
    var urlPath = a.pathname.split("/");
    if ((a.pathname.toLowerCase().substr(0, 1) !== "/")) {
        var channel = urlPath[0];
        var archive = urlPath[2];
        var archiveindex = 2;
    } else {
        var channel = urlPath[1];
        var archive = urlPath[3];
        var archiveindex = 3;
    }
    if (urlPath.length > archiveindex) {
        $("#STREAMCONTAINER").html("<object bgcolor='#000000' data='http://www.justin.tv/widgets/archive_embed_player.swf' height='" + playerH + "' id='clip_embed_player_flash' type='application/x-shockwave-flash' width='" + playerW + "'><param name='movie' value='http://www.justin.tv/widgets/archive_embed_player.swf'><param name='allowScriptAccess' value='always'><param name='allowNetworking' value='all'><param name='allowFullScreen' value='true'><param name='flashvars' value='channel=" + channel + "&auto_play=true&archive_id=" + archive + "&hostname=www.justin.tv'></object><input class='sitename hidden' type='text' value='jtv'>");
    }
    else {
        $("#STREAMCONTAINER").html("<object type='application/x-shockwave-flash' height='" + playerH + "' width='" + playerW + "' id='live_embed_player_flash' data='http://www.justin.tv/widgets/live_embed_player.swf?channel=" + channel + "' bgcolor='#000000'><param name='wmode' value='opaque' /><param name='allowFullScreen' value='true' /><param name='allowScriptAccess' value='always' /><param name='allowNetworking' value='all' /><param name='movie' value='http://www.justin.tv/widgets/live_embed_player.swf' /><param name='flashvars' value='channel=" + channel + "&auto_play=true' /></object><input class='sitename hidden' type='text' value='ttv'>");
    }
    document.getElementById("sitename").setAttribute("value", "jtv");
    $("#ust-icon,#lst-icon,#yut-icon,#o3d-icon,#any-icon").attr('class', '');
    $("#jtv-icon").attr('class', 'streamoption_selected');         
}

function ttv(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = $("#STREAMCONTAINER").width();
    var playerH = (playerW / (16 / 9)) + 29;
    var a = document.createElement('a');
    if ((obj.toLowerCase().substr(0, 9) === "justin.tv") || (obj.toLowerCase().substr(0, 10) === "justin.tv/") || (obj.toLowerCase().substr(0, 13) === "www.justin.tv") || (obj.toLowerCase().substr(0, 14) === "www.justin.tv/") || (obj.toLowerCase().substr(0, 9) === "twitch.tv") || (obj.toLowerCase().substr(0, 10) === "twitch.tv/") || (obj.toLowerCase().substr(0, 13) === "www.twitch.tv") || (obj.toLowerCase().substr(0, 14) === "www.twitch.tv/")) {
        a.href = 'http://' + obj;
    }
    else if ((obj.toLowerCase().substr(0, 17) !== "http://justin.tv/") && (obj.toLowerCase().substr(0, 18) !== "https://justin.tv/") && (obj.toLowerCase().substr(0, 21) !== "http://www.justin.tv/") && (obj.toLowerCase().substr(0, 22) !== "https://www.justin.tv/") && (obj.toLowerCase().substr(0, 17) !== "http://twitch.tv/") && (obj.toLowerCase().substr(0, 18) !== "https://twitch.tv/") && (obj.toLowerCase().substr(0, 21) !== "http://www.twitch.tv/") && (obj.toLowerCase().substr(0, 22) !== "https://www.twitch.tv/")) {
        a.href = 'http://twitch.tv/' + obj;
    }
    else {
        a.href = obj;
    }
    var urlPath = a.pathname.split("/");
    if ((a.pathname.toLowerCase().substr(0, 1) !== "/")) {
        var channel = urlPath[0];
        var archive = urlPath[2];
        var archiveindex = 2;
    } else {
        var channel = urlPath[1];
        var archive = urlPath[3];
        var archiveindex = 3;
    }
    if (urlPath.length > archiveindex) {
        $("#STREAMCONTAINER").html("<object bgcolor='#000000' data='http://www.twitch.tv/widgets/archive_embed_player.swf' height='" + playerH + "' id='clip_embed_player_flash' type='application/x-shockwave-flash' width='" + playerW + "'><param name='movie' value='http://www.twitch.tv/widgets/archive_embed_player.swf'><param name='allowScriptAccess' value='always'><param name='allowNetworking' value='all'><param name='allowFullScreen' value='true'><param name='flashvars' value='channel=" + channel + "&auto_play=true&archive_id=" + archive + "&hostname=www.twitch.tv'></object><input class='sitename hidden' type='text' value='ttv'>");
    }
    else {
        $("#STREAMCONTAINER").html("<object type='application/x-shockwave-flash' height='" + playerH + "' width='" + playerW + "' id='live_embed_player_flash' data='http://www.twitch.tv/widgets/live_embed_player.swf?channel=" + channel + "' bgcolor='#000000'><param name='wmode' value='opaque' /><param name='allowFullScreen' value='true' /><param name='allowScriptAccess' value='always' /><param name='allowNetworking' value='all' /><param name='movie' value='http://www.twitch.tv/widgets/live_embed_player.swf' /><param name='flashvars' value='channel=" + channel + "&auto_play=true' /></object><input class='sitename hidden' type='text' value='ttv'>");
    }
    document.getElementById("sitename").setAttribute("value", "ttv");
    $("#ust-icon,#lst-icon,#yut-icon,#o3d-icon,#any-icon").attr('class', '');
    $("#jtv-icon").attr('class', 'streamoption_selected');          
}

function ust(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = $("#STREAMCONTAINER").width();
    var playerH = (playerW / (16 / 9)) + 32;
    var a = document.createElement('a');
    if ((obj.toLowerCase().substr(0, 19) === "ustream.tv/channel/") || (obj.toLowerCase().substr(0, 23) === "www.ustream.tv/channel/") || (obj.toLowerCase().substr(0, 20) === "ustream.tv/recorded/") || (obj.toLowerCase().substr(0, 24) === "www.ustream.tv/recorded/")) {
        a.href = 'http://' + obj;
    }
    else if ((obj.toLowerCase().substr(0, 8) === "channel/") || (obj.toLowerCase().substr(0, 9) === "recorded/")) {
        a.href = "http://www.ustream.tv/" + obj;
    }
    else if ((obj.toLowerCase().substr(0, 9) === "/channel/") || (obj.toLowerCase().substr(0, 10) === "/recorded/")) {
        a.href = "http://www.ustream.tv" + obj;
    }
    else if ((obj.toLowerCase().substr(0, 26) === "http://ustream.tv/channel/") || (obj.toLowerCase().substr(0, 27) === "http://ustream.tv/recorded/") || (obj.toLowerCase().substr(0, 27) === "https://ustream.tv/channel/") || (obj.toLowerCase().substr(0, 28) === "https://ustream.tv/recorded/") || (obj.toLowerCase().substr(0, 30) === "http://www.ustream.tv/channel/") || (obj.toLowerCase().substr(0, 31) === "http://www.ustream.tv/recorded/") || (obj.toLowerCase().substr(0, 31) === "https://www.ustream.tv/channel/") || (obj.toLowerCase().substr(0, 32) === "https://www.ustream.tv/recorded/")) {
        a.href = obj;
    }
    else {
        a.href = "http://www.ustream.tv/channel/" + obj;
    }
    var urlPath = a.pathname.split("/");
    if ((a.pathname.toLowerCase().substr(0, 1) !== "/")) {
        var channel = urlPath[0];
        var id = urlPath[1];
        var codeeindex = 1;
    } else {
        var channel = urlPath[1];
        var id = urlPath[2];
        var archiveindex = 2;
    }
    if (channel === "recorded") {
        $("#STREAMCONTAINER").html("<object width='" + playerW + "' height='" + playerH + "' data='http://www.ustream.tv/embed/recorded/" + id + "?v=3&amp;autoplay=true''></object><input class='sitename hidden' type='text' value='ust'>");
    }
    else {
        $("#STREAMCONTAINER").html("<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='" + playerW + "' height='" + playerH + "' id='utv799408'><param name='flashvars' value='autoplay=true&amp;brand=embed&amp;cid=" + id + "'/><param name='wmode' value='opaque'></param><param name='allowfullscreen' value='true'/><param name='allowscriptaccess' value='always'/><param name='movie' value='http://www.ustream.tv/flash/viewer.swf'/><embed flashvars='autoplay=true&amp;brand=embed&amp;cid=" + id + "' width='" + playerW + "' height='" + playerH + "' wmode='opaque' allowfullscreen='true' allowscriptaccess='always' id='utv799408' name='utv_n_274276' src='http://www.ustream.tv/flash/viewer.swf' type='application/x-shockwave-flash' /></object><input class='sitename hidden' type='text' value='ust'>");
    }
    document.getElementById("sitename").setAttribute("value", "ust");
    $("#jtv-icon,#lst-icon,#yut-icon,#o3d-icon,#any-icon").attr('class', '');
    $("#ust-icon").attr('class', 'streamoption_selected');
}

function lst(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = $("#STREAMCONTAINER").width();
    var playerH = (playerW / (16 / 9)) + 25;
    var a = document.createElement('a');
    if ((obj.toLowerCase().substr(0, 15) === "livestream.com/") || (obj.toLowerCase().substr(0, 19) === "www.livestream.com/")) {
        a.href = 'http://' + obj;
    }
    else if ((obj.toLowerCase().substr(0, 22) === "http://livestream.com/") || (obj.toLowerCase().substr(0, 23) === "https://livestream.com/") || (obj.toLowerCase().substr(0, 26) === "http://www.livestream.com/") || (obj.toLowerCase().substr(0, 27) === "https://www.livestream.com/")) {
        a.href = obj;
    }
    else {
        a.href = "http://www.livestream.com/" + obj;
    }
    var urlPath = a.pathname.split("/");
    var urlQuery = [],
        hash;
    var q = a.href.split('?')[1];
    if (q !== undefined) {
        q = q.split('&');
        for (var i = 0; i < q.length; i++) {
            hash = q[i].split('=');
            urlQuery.push(hash[1]);
            urlQuery[hash[0]] = hash[1];
        }
    }
    if ((a.pathname.toLowerCase().substr(0, 1) !== "/")) {
        var channel = urlPath[0];
        var archive = urlPath[1];
        var archiveindex = 1;
    } else {
        var channel = urlPath[1];
        var archive = urlPath[2];
        var archiveindex = 2;
    }
    var clipId = urlQuery['clipId'];
    if (archive === "video" || archive === "share") {
        $("#STREAMCONTAINER").html("<object width='" + playerW + "' height='" + playerH + "' id='lsplayer' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'><param name='movie' value='http://cdn.livestream.com/grid/LSPlayer.swf?channel=" + channel + "&amp;clip=" + clipId + "&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc'></param><param name='allowScriptAccess' value='always'></param><param name='allowFullScreen' value='true'></param><embed name='lsplayer' wmode='opaque' src='http://cdn.livestream.com/grid/LSPlayer.swf?channel=" + channel + "&amp;clip=" + clipId + "&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc' width='" + playerW + "' height='" + playerH + "' allowScriptAccess='always' allowFullScreen='true' type='application/x-shockwave-flash'></embed></object><input class='sitename hidden' type='text' value='lst'>");
    }
    else {
        $("#STREAMCONTAINER").html("<object width='" + playerW + "' height='" + playerH + "' id='lsplayer' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'><param name='movie' value='http://cdn.livestream.com/grid/LSPlayer.swf?channel=" + channel + "&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc'></param><param name='allowScriptAccess' value='always'></param><param name='allowFullScreen' value='true'></param><embed name='lsplayer' wmode='opaque' src='http://cdn.livestream.com/grid/LSPlayer.swf?channel=" + channel + "&amp;color=0x000000&amp;autoPlay=true&amp;mute=false&amp;iconColorOver=0xe7e7e7&amp;iconColor=0xcccccc' width='" + playerW + "' height='" + playerH + "' allowScriptAccess='always' allowFullScreen='true' type='application/x-shockwave-flash'></embed></object><input class='sitename hidden' type='text' value='lst'>");
    }
    document.getElementById("sitename").setAttribute("value", "lst");
    $("#jtv-icon,#ust-icon,#yut-icon,#o3d-icon,#any-icon").attr('class', '');
    $("#lst-icon").attr('class', 'streamoption_selected');
}

function yut(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = $("#STREAMCONTAINER").width();
    var playerH = (playerW / (16 / 9));
    var a = document.createElement('a');
    if ((obj.toLowerCase().substr(0, 12) === "youtube.com/") || (obj.toLowerCase().substr(0, 16) === "www.youtube.com/") || (obj.toLowerCase().substr(0, 23) === "youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 27) === "www.youtube.googleapis.com/")) {
        a.href = 'http://' + obj;
    }
    else if ((obj.toLowerCase().substr(0, 4) === "user") || (obj.toLowerCase().substr(0, 2) === "v/") || (obj.toLowerCase().substr(0, 8) === "playlist") || (obj.toLowerCase().substr(0, 5) === "watch") || (obj.toLowerCase().substr(0, 7) === "results")) {
        a.href = "http://www.youtube.com/" + obj;
    }
    else if ((obj.toLowerCase().substr(0, 5) === "/user") || (obj.toLowerCase().substr(0, 3) === "/v/") || (obj.toLowerCase().substr(0, 9) === "/playlist") || (obj.toLowerCase().substr(0, 6) === "/watch") || (obj.toLowerCase().substr(0, 8) === "/results")) {
        a.href = "http://www.youtube.com" + obj;
    }
    else if ((obj.toLowerCase().substr(0, 1) === "/") && (obj.toLowerCase().substr(0, 5) !== "/user") && (obj.toLowerCase().substr(0, 3) !== "/v/") && (obj.toLowerCase().substr(0, 9) !== "/playlist") && (obj.toLowerCase().substr(0, 6) !== "/watch") && (obj.toLowerCase().substr(0, 8) !== "/results")) {
        a.href = "http://www.youtube.com" + obj;
    }
    else if ((obj.toLowerCase().substr(0, 19) === "http://youtube.com/") || (obj.toLowerCase().substr(0, 30) === "http://youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 20) === "https://youtube.com/") || (obj.toLowerCase().substr(0, 31) === "https://youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 23) === "http://www.youtube.com/") || (obj.toLowerCase().substr(0, 34) === "http://www.youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 24) === "https://www.youtube.com/") || (obj.toLowerCase().substr(0, 35) === "https://www.youtube.googleapis.com/")) {
        a.href = obj;
    }
    else if ((obj.length === 11) && (obj.indexOf(' ') === -1)) {
        a.href = "http://www.youtube.com/watch?v=" + obj;
    }
    else {
        a.href = "http://www.youtube.com/results?search_query=" + obj;
    }
    var urlPath = a.pathname.split("/");
    var urlQuery = [],
        hash;
    var q = a.href.split('?')[1];
    if (q !== undefined) {
        q = q.split('&');
        for (var i = 0; i < q.length; i++) {
            hash = q[i].split('=');
            urlQuery.push(hash[1]);
            urlQuery[hash[0]] = hash[1];
        }
    }
    if ((a.pathname.toLowerCase().substr(0, 1) !== "/")) {
        var channel = urlPath[0];
        var video = urlPath[1];

    } else {
        var channel = urlPath[1];
        var video = urlPath[2];
    }
    if (channel === "v") {
        var v = video;
    } else {
        var v = urlQuery['v'];
    }
    var list = urlQuery['list'];
    var search = urlQuery['search_query'];
    if (channel === "playlist") {
        $("#STREAMCONTAINER").html("<iframe width='" + playerW + "' height='" + playerH + "' src='http://www.youtube.com/embed/videoseries?list=" + list + "&amp;autoplay=1&amp;hl=en_US&amp;color=white&amp;vq=hd720' frameborder='0' allowfullscreen></iframe><input class='sitename hidden' type='text' value='yut'>");
    }
    else if (channel === "results") {
        $("#STREAMCONTAINER").html("<iframe width='" + playerW + "' height='" + playerH + "' src='http://www.youtube.com/embed?listType=search&list=" + search + "&amp;autoplay=1&amp;hl=en_US&amp;color=white' frameborder='0' allowfullscreen></iframe><input class='sitename hidden' type='text' value='yut'>");
    }
    else if (channel === "user") {
        $("#STREAMCONTAINER").html("<iframe width='" + playerW + "' height='" + playerH + "' src='http://www.youtube.com/embed?listType=user_uploads&list=" + video + "&amp;autoplay=1&amp;hl=en_US&amp;color=white' frameborder='0' allowfullscreen></iframe><input class='sitename hidden' type='text' value='yut'>");
    }    
    else if ((channel !== "watch") && (channel !== "v") && (channel !== "playlist") && (channel !== "results") && (channel !== "user")) {
        $("#STREAMCONTAINER").html("<iframe width='" + playerW + "' height='" + playerH + "' src='http://www.youtube.com/embed?listType=user_uploads&list=" + channel + "&amp;autoplay=1&amp;hl=en_US&amp;color=white' frameborder='0' allowfullscreen></iframe><input class='sitename hidden' type='text' value='yut'>");
    }
    else {
        $("#STREAMCONTAINER").html("<object width='" + playerW + "' height='" + playerH + "'><param name='movie' value='http://www.youtube.com/v/" + v + "?version=3&amp;hl=en_US&autoplay=1&autohide=1'></param><param name='allowFullScreen' value='true'></param><param name='wmode' value='opaque'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/" + v + "?version=3&amp;hl=en_US&autoplay=1&autohide=1' wmode='opaque' type='application/x-shockwave-flash' width='" + playerW + "' height='" + playerH + "' allowscriptaccess='always' allowfullscreen='true'></embed></object><input class='sitename hidden' type='text' value='yut'>");
    }
    document.getElementById("sitename").setAttribute("value", "yut");
    $("#jtv-icon,#ust-icon,#lst-icon,#o3d-icon,#any-icon").attr('class', '');
    $("#yut-icon").attr('class', 'streamoption_selected');
}

function o3d(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = $("#STREAMCONTAINER").width();
    var playerH = (playerW / (16 / 9));
    var a = document.createElement('a');
    if ((obj.toLowerCase().substr(0, 9) === "own3d.tv/") || (obj.toLowerCase().substr(0, 13) === "www.own3d.tv/")) {
        a.href = 'http://' + obj;
    }
    else if ((obj.toLowerCase().substr(0, 16) === "http://own3d.tv/") || (obj.toLowerCase().substr(0, 17) === "https://own3d.tv/") || (obj.toLowerCase().substr(0, 20) === "http://www.own3d.tv/") || (obj.toLowerCase().substr(0, 21) === "https://www.own3d.tv/")) {
        a.href = obj;
    }
    else if ((obj.toLowerCase().substr(0, 2) === "w/") || (obj.toLowerCase().substr(0, 6) === "watch/") || (obj.toLowerCase().substr(0, 2) === "v/") || (obj.toLowerCase().substr(0, 6) === "video/") || (obj.toLowerCase().substr(0, 2) === "l/") || (obj.toLowerCase().substr(0, 5) === "live/")) {
        a.href = "http://www.own3d.tv/" + obj;
    }
    else if ((obj.toLowerCase().substr(0, 3) === "/w/") || (obj.toLowerCase().substr(0, 7) === "/watch/") || (obj.toLowerCase().substr(0, 3) === "/v/") || (obj.toLowerCase().substr(0, 7) === "/video/") || (obj.toLowerCase().substr(0, 3) === "/l/") || (obj.toLowerCase().substr(0, 6) === "/live/")) {
        a.href = "http://www.own3d.tv" + obj;
    }
    else {
        a.href = "http://www.own3d.tv/live/" + obj;
    }
    var urlPath = a.pathname.split("/");
    if ((a.pathname.toLowerCase().substr(0, 1) != "/")) {
        if ((urlPath[0] !== "l") && (urlPath[0] !== "live") && (urlPath[0] !== "w") && (urlPath[0] !== "watch") && (urlPath[0] !== "v") && (urlPath[0] !== "video")) {
            var channel = urlPath[1];
            var id = urlPath[2];
        } else {
            var channel = urlPath[0];
            var id = urlPath[1];
        }
    } else {
        if ((urlPath[1] !== "l") && (urlPath[1] !== "live") && (urlPath[1] !== "w") && (urlPath[1] !== "watch") && (urlPath[1] !== "v") && (urlPath[1] !== "video")) {
            var channel = urlPath[2];
            var id = urlPath[3];
        } else {
            var channel = urlPath[1];
            var id = urlPath[2];
        }
    }
    if ((channel === "v") || (channel === "video") || (channel === "w") || (channel === "watch")) {
        $("#STREAMCONTAINER").html("<object width='" + playerW + "' height='" + playerH + "'><param name='movie' value='http://www.own3d.tv/stream/" + id + ";autoplay=true' /><param name='allowscriptaccess' value='always' /><param name='allowfullscreen' value='true' /><param name='wmode' value='opaque' /><embed src='http://www.own3d.tv/stream/" + id + ";autoplay=true' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='always' width='" + playerW + "' height='" + playerH + "' wmode='opaque'></embed></object><input class='sitename hidden' type='text' value='o3d'>");
    }
    else {
        $("#STREAMCONTAINER").html("<object width='" + playerW + "' height='" + playerH + "'><param name='movie' value='http://www.own3d.tv/livestream/" + id + ";autoplay=true' /><param name='allowscriptaccess' value='always' /><param name='allowfullscreen' value='true' /><param name='wmode' value='opaque' /><embed src='http://www.own3d.tv/livestream/" + id + ";autoplay=true' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='always' width='" + playerW + "' height='" + playerH + "' wmode='opaque'></embed></object><input class='sitename hidden' type='text' value='o3d'>");
    }
    document.getElementById("sitename").setAttribute("value", "o3d");
    $("#jtv-icon,#ust-icon,#lst-icon,#yut-icon,#any-icon").attr('class', '');
    $("#o3d-icon").attr('class', 'streamoption_selected');
}

function any(obj) {
    urlInput = document.getElementById('urlInput');
    var playerW = document.getElementById("STREAMCONTAINER").offsetWidth;
    var playerH = (playerW / (16 / 9));
    if ((obj.toLowerCase().substr(0, 7) == "http://") || (obj.toLowerCase().substr(0, 8) == "https://")) {
        document.getElementById("STREAMCONTAINER").innerHTML = "<object data='" + obj + "' width='" + playerW + "' height='" + playerH + "'></object><input class='sitename hidden' type='text' value='any'>";
    }
    else {
        document.getElementById("STREAMCONTAINER").innerHTML = obj + "<input class='sitename hidden' type='text' value='any'>";
    }
    document.getElementById("sitename").setAttribute("value", "any");
    $("#jtv-icon,#ust-icon,#lst-icon,#yut-icon,#o3d-icon").attr('class', '');
    $("#any-icon").attr('class', 'streamoption_selected');
}

function waifu(obj) {
    if ((obj.toLowerCase().substr(0, 1) == "<") || (obj.toLowerCase().substr(0, 7) == "http://") || (obj.toLowerCase().substr(0, 8) == "https://") || (obj.toLowerCase().substr(0, 10) === "justin.tv/") || (obj.toLowerCase().substr(0, 14) === "www.justin.tv/") || (obj.toLowerCase().substr(0, 10) === "twitch.tv/") || (obj.toLowerCase().substr(0, 14) === "www.twitch.tv/") || (obj.toLowerCase().substr(0, 11) === "ustream.tv/") || (obj.toLowerCase().substr(0, 15) === "www.ustream.tv/") || (obj.toLowerCase().substr(0, 15) === "livestream.com/") || (obj.toLowerCase().substr(0, 19) === "www.livestream.com/") || (obj.toLowerCase().substr(0, 12) === "youtube.com/") || (obj.toLowerCase().substr(0, 16) === "www.youtube.com/") || (obj.toLowerCase().substr(0, 23) === "youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 27) === "www.youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 9) === "own3d.tv/") || (obj.toLowerCase().substr(0, 13) === "www.own3d.tv/")) {
        if ((obj.toLowerCase().substr(0, 17) === "http://justin.tv/") || (obj.toLowerCase().substr(0, 18) === "https://justin.tv/") || (obj.toLowerCase().substr(0, 21) === "http://www.justin.tv/") || (obj.toLowerCase().substr(0, 22) === "https://www.justin.tv/") || (obj.toLowerCase().substr(0, 10) === "justin.tv/") || (obj.toLowerCase().substr(0, 14) === "www.justin.tv/")) {
            jtv(obj);
        }
        else if ((obj.toLowerCase().substr(0, 17) === "http://twitch.tv/") || (obj.toLowerCase().substr(0, 18) === "https://twitch.tv/") || (obj.toLowerCase().substr(0, 21) === "http://www.twitch.tv/") || (obj.toLowerCase().substr(0, 22) === "https://www.twitch.tv/") || (obj.toLowerCase().substr(0, 10) === "twitch.tv/") || (obj.toLowerCase().substr(0, 14) === "www.twitch.tv/")) {
            ttv(obj);
        }
        else if ((obj.toLowerCase().substr(0, 18) === "http://ustream.tv/") || (obj.toLowerCase().substr(0, 19) === "https://ustream.tv/") || (obj.toLowerCase().substr(0, 22) === "http://www.ustream.tv/") || (obj.toLowerCase().substr(0, 23) === "https://www.ustream.tv/") || (obj.toLowerCase().substr(0, 11) === "ustream.tv/") || (obj.toLowerCase().substr(0, 15) === "www.ustream.tv/")) {
            ust(obj);
        }
        else if ((obj.toLowerCase().substr(0, 22) === "http://livestream.com/") || (obj.toLowerCase().substr(0, 23) === "https://livestream.com/") || (obj.toLowerCase().substr(0, 26) === "http://www.livestream.com/") || (obj.toLowerCase().substr(0, 27) === "https://www.livestream.com/") || (obj.toLowerCase().substr(0, 15) === "livestream.com/") || (obj.toLowerCase().substr(0, 19) === "www.livestream.com/")) {
            lst(obj);
        }
        else if ((obj.toLowerCase().substr(0, 19) === "http://youtube.com/") || (obj.toLowerCase().substr(0, 30) === "http://youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 20) === "https://youtube.com/") || (obj.toLowerCase().substr(0, 31) === "https://youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 23) === "http://www.youtube.com/") || (obj.toLowerCase().substr(0, 34) === "http://www.youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 24) === "https://www.youtube.com/") || (obj.toLowerCase().substr(0, 35) === "https://www.youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 12) === "youtube.com/") || (obj.toLowerCase().substr(0, 16) === "www.youtube.com/") || (obj.toLowerCase().substr(0, 23) === "youtube.googleapis.com/") || (obj.toLowerCase().substr(0, 27) === "www.youtube.googleapis.com/")) {
            yut(obj);
        }
        else if ((obj.toLowerCase().substr(0, 16) === "http://own3d.tv/") || (obj.toLowerCase().substr(0, 17) === "https://own3d.tv/") || (obj.toLowerCase().substr(0, 20) === "http://www.own3d.tv/") || (obj.toLowerCase().substr(0, 21) === "https://www.own3d.tv/") || (obj.toLowerCase().substr(0, 9) === "own3d.tv/") || (obj.toLowerCase().substr(0, 13) === "www.own3d.tv/")) {
            o3d(obj);
        }
        else {
            any(obj);
        }
    }
    else {
        window[document.getElementById('sitename').value](obj);
    }
}