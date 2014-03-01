// DEMO FUNCTIONS
var themeURL = 'http://mythemes.renklibeyaz.com/photodrugshtml';
$(window).load(function(){
	$('#body-wrapper').append($('<div id="palette">\
		<div id="paletteHeader">\
			<div id="colorResult">#D5FF00</div>\
			<a href="javascript:void(0);" class="closeButton"></a>\
			<a href="javascript:void(0);" class="openButton"></a>\
			<div class="clearfix"></div>\
		</div>\
		<div id="paletteBody">\
			<div id="colorPicker"></div>\
			<canvas id="colorPalette" width="150" height="150"></canvas>\
		</div>\
		<div id="ThemeSwitch">\
			<a class="themeBtn light" href="javascript:void(0)" onclick="changeTheme(\'light\')">LIGHT</a>\
			<a class="themeBtn dark selected" href="javascript:void(0)" onclick="changeTheme(\'dark\')">DARK</a>\
		</div>\
	</div>'));
	setTimeout(function(){
		DrawPicker('colorPalette');
		}, 50);
});

var activeTheme = 'dark';
var themeVars = {'@ColorFirst' : '#d5ff00',
				'@ColorInverse' : '#000000',
				'@ColorSecond' : '#ffffff',
				'@ColorSecondInverse' : '#000000',
				'@TextColor' : '#ffffff',
				'@TextColor2' : '#000000',
				'@BackgroundColor' : '#ffffff',
				'@ColorThemeBg' : '#000000',
				'@ColorThemeBgInverse' : '#ffffff',
				'@ThemePrefix': "'"+activeTheme+"'"}
function changeTheme(tn){
	 $('#ThemeSwitch a').removeClass('selected');
	 $('#ThemeSwitch .'+tn).addClass('selected');
	 activeTheme = tn;
	 if(tn=='dark'){
		themeVars['@ColorInverse'] = 			'#000000';
		themeVars['@ColorSecond'] = 			'#ffffff';
		themeVars['@ColorSecondInverse'] =		'#000000';
		themeVars['@TextColor'] = 				'#ffffff';
		themeVars['@TextColor2'] = 				'#000000';
		themeVars['@BackgroundColor'] = 		'#ffffff';
		themeVars['@ColorThemeBg'] = 			'#000000';
		themeVars['@ColorThemeBgInverse'] = 	'#ffffff';
		
		themeVars['@ThemePrefix'] = 	"'"+activeTheme+"'";
		themeVars['@ImagesDir'] = 		"'"+themeURL+'/images/'+"'";
		themeVars['@ImgDir'] = 			"'"+themeURL+'/img/'+"'";
		less.modifyVars(themeVars);
		$('#logo img').attr('src',themeURL+'/images/photodrug-logo.png');
	}else{
		themeVars['@ColorInverse'] = 			'#ffffff';
		themeVars['@ColorSecond'] = 			'#000000';
		themeVars['@ColorSecondInverse'] =		'#ffffff';
		themeVars['@TextColor'] = 				'#111111';
		themeVars['@TextColor2'] = 				'#111111';
		themeVars['@BackgroundColor'] = 		'#f0f0f0';
		themeVars['@ColorThemeBg'] = 			'#ffffff';
		themeVars['@ColorThemeBgInverse'] = 	'#000000';
		
		themeVars['@ThemePrefix'] = 	"'"+activeTheme+"'";
		themeVars['@ImagesDir'] = 		"'"+themeURL+'/images/'+"'";
		themeVars['@ImgDir'] = 			"'"+themeURL+'/img/'+"'";
		$('#logo img').attr('src',themeURL+'/images/photodrug-logo-light.png');
		less.modifyVars(themeVars);
	}
}
  
function DrawPicker(pickerID){

	if(!Modernizr.canvas || Modernizr.touch){
		$('#palette').hide();
		return false;
	}
	
    var ctx = document.getElementById(pickerID).getContext('2d');
    var img = new Image();
    img.src = themeURL+'/img/280.png';
    img.onload = function(){
		ctx.drawImage(img,0,0,150,150);
	}
	
	var defColor = $.cookie("defColor");
	var defColorA = $.cookie("defColorA");
	var defTheme = $.cookie("defTheme");
	var defPalette = $.cookie("defPalette");
	var defPaletteX = $.cookie("defPaletteX");
	var defPaletteY = $.cookie("defPaletteY");
	if(defColor!=null){
		setDemoColor(defColor, defColorA);
		setDemoColorPreview(defColor, defColorA);
	}
	if(defTheme)
		changeTheme(defTheme);
	if(defPalette=='hide')
		hidePalette();
	else if(defPalette==null){
		//if((($(window).width()-940)/2)-40-$('#palette').width()<0){
			hidePalette();
		//}
	}
	if(defPaletteX!=null && defPaletteY!=null){
		if(defPaletteX<20) defPaletteX = 20;
		if(defPaletteY<20) defPaletteY = 20;
		if(defPaletteX>$(window).width()) defPaletteX = $(window).width()-50;
		if(defPaletteY>$(window).height()) defPaletteY = $(window).height()-50;
		$('#palette').css({left:defPaletteX+'px', top:defPaletteY+'px'});
	}
	
	
	$('#paletteHeader .closeButton').click(hidePalette);
	$('#paletteHeader .openButton').click(showPalette);
	  
	$('#'+pickerID+', #colorPicker').bind('selectstart dragstart', rFalse);
	$('#'+pickerID+', #colorPicker').bind('mousedown', function(){
		$('#'+pickerID).bind('mousemove', {pickerID:pickerID},GetColor);
	});

	$('#'+pickerID+', #colorPicker').bind('mouseup', function(){
		$('#'+pickerID).unbind('mousemove', GetColor);
		$.cookie("defColor", $('#colorResult').html(), {path:'/'});
		$.cookie("defColorA", $('#colorResult').attr('rel'), {path:'/'});
		setDemoColor($('#colorResult').html(), $('#colorResult').attr('rel'));
	});
	
	$('#paletteHeader').bind('mousedown', function(e){
		$(document).bind('selectstart dragstart', rFalse);
		if(typeof document.body.style.MozUserSelect!="undefined") //Firefox route
		document.body.style.MozUserSelect="none";
		
		$(document).bind('mouseup', function(){
			$.cookie('defPaletteX', $('#palette').offset().left, {path:'/'});
			$.cookie('defPaletteY', $('#palette').offset().top, {path:'/'});
			$(document).unbind('selectstart dragstart', rFalse);
			$(document).unbind('mousemove', movePalette);
		});
		
		$(document).bind('mousemove', {fX:e.pageX, fY:e.pageY, pX:$('#palette').offset().left, pY:$('#palette').offset().top}, movePalette);
	});	 
}

function hidePalette(){
	$.cookie("defPalette", 'hide', {path:'/'});
	$('#paletteHeader .openButton').show();
	$('#paletteHeader .closeButton').hide();
	$('#paletteBody, #ThemeSwitch, #colorResult').hide();
}
function showPalette(){
	$.cookie("defPalette", 'show', {path:'/'});
	$('#paletteHeader .openButton').hide();
	$('#paletteHeader .closeButton').show();
	$('#paletteBody, #ThemeSwitch, #colorResult').show();
}

function setDemoColor(color, colora){
	themeVars['@ColorFirst'] =  color;
	themeVars['@ColorFirstAlpha'] = colora;
	themeVars['@ImagesDir'] = 		"'"+themeURL+'/images/'+"'";
	less.modifyVars(themeVars);
	$("#contentBox").getNiceScroll().remove();
	$("#contentBox").niceScroll( {cursorcolor:themeVars['@ColorFirst'], cursorborder:'none', cursorborderradius:'none', railpadding:{top:0,right:-20,left:0,bottom:0}});
}
function setDemoColorPreview(color, colora){
	$('#colorResult').html(color);
    $('#colorResult').css('background-color', color);
    $('#colorResult').attr('rel', colora);
}

function movePalette(event){
	var x = (event.pageX-event.data.fX) + event.data.pX;
	var y = (event.pageY-event.data.fY) + event.data.pY;
	$('#palette').css({left:x+'px', top:y+'px'});
}
function GetColor(event){
        var x = event.pageX - $(event.currentTarget).parent().offset().left;
        var y = event.pageY - $(event.currentTarget).parent().offset().top;
        var ctx = document.getElementById(event.data.pickerID).getContext('2d');
        var imgd = ctx.getImageData(x, y, 1, 1);
        var data = imgd.data;
		$('#colorPicker').css({left:(x-5)+'px', top:(y-5)+'px'});
        var hexString = RGBtoHex(data[0],data[1],data[2]);
        setDemoColorPreview('#'+hexString, 'rgba('+data[0]+','+data[1]+','+data[2]+',.7)');
}
function RGBtoHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
function toHex(N) {
      if (N==null) return "00";
      N=parseInt(N); if (N==0 || isNaN(N)) return "00";
      N=Math.max(0,N); N=Math.min(N,255); N=Math.round(N);
      return "0123456789ABCDEF".charAt((N-N%16)/16)
           + "0123456789ABCDEF".charAt(N%16);
}
function rFalse(event){ return false; }
function isCanvasSupported(){
  var elem = document.createElement('canvas');
  return !!(elem.getContext && elem.getContext('2d'));
}