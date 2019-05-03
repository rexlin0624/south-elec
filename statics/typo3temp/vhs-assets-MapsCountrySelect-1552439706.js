(function(a,b,c){function e(a){return a}function f(a){return g(decodeURIComponent(a.replace(d," ")))}function g(a){return 0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\")),a}function h(a){return i.json?JSON.parse(a):a}var d=/\+/g,i=a.cookie=function(d,g,j){if(g!==c){if(j=a.extend({},i.defaults,j),null===g&&(j.expires=-1),"number"==typeof j.expires){var k=j.expires,l=j.expires=new Date;l.setDate(l.getDate()+k)}return g=i.json?JSON.stringify(g):g+"",b.cookie=[encodeURIComponent(d),"=",i.raw?g:encodeURIComponent(g),j.expires?"; expires="+j.expires.toUTCString():"",j.path?"; path="+j.path:"",j.domain?"; domain="+j.domain:"",j.secure?"; secure":""].join("")}for(var m=i.raw?e:f,n=b.cookie.split("; "),o=d?null:{},p=0,q=n.length;q>p;p++){var r=n[p].split("="),s=m(r.shift()),t=m(r.join("="));if(d&&d===s){o=h(t);break}d||(o[s]=h(t))}return o};i.defaults={},a.removeCookie=function(b,c){return null!==a.cookie(b)?(a.cookie(b,null,c),!0):!1}})(jQuery,document);
$(document).ready(function() {


  // if($.cookie('langSettingsEao')) {
  //   // console.log('l: set');
  //
  // }else{
  //   // console.log('langset: not set');

    $.getJSON('https://ipinfo.io?token=960fa4b6ddc00d', function(data){
      var geolocationname = data.country;

    	switch (geolocationname) {
    		case 'GB':
    		case 'DK':
    		case 'JP':
    		case 'PL':
    		$('#language_switch').val('EN');
    		break;

    		case 'CH':
    		case 'DE':
    		case 'AT':
    		$('#language_switch').val('DE');
    		break;

    		case 'US':
    		$('#language_switch').val('EN_US');
    		break;

    		case 'CN':
    		case 'HK':
    		$('#language_switch').val('CN');
    		break;

    		case 'NL':
    		case 'BE':
    		$('#language_switch').val('NL');
    		break;

    		case 'FR':
    		$('#language_switch').val('FR');
    		break;

    		case 'LU':
    		$('#language_switch').val('FR');
    		break;

    		case 'SE':
    		$('#language_switch').val('SE');
    		break;

    		case 'ES':
    		$('#language_switch').val('ES');
    		break;

    		case 'IT':
    		$('#language_switch').val('IT');
    		break;

    		default:
    		$('#language_switch').val('EN');
    	}

    	var land = $('[class='+geolocationname+']');
    	$('[value*='+geolocationname+']').attr('selected', 'selected');

    	$('[data-country*='+geolocationname+']').attr('selected', 'selected');

    	if($.cookie('langSettingsEao')) {
    			// var index = $.cookie('lang');
    			// This is only for testing purposes
    			// $('#countryModal').modal('show');

    			var lng = $.cookie('langNameEao');
    			var lnd = $.cookie('landNameEao');

    			redirectUrlCookie = $("base").attr("href") + lnd + '/' + lng;
    			window.location.href=redirectUrlCookie;
    			console.log('Cookie: set');

    	}else
    	{
    		$('#countryModal').modal('show');
    		console.log('Cookie: na');
    	}

    	$("#submit-country").click(function() {
    		var landesName = $('#landesauswahl').find('option:selected', this).attr('name');
    		var languageName = $('#language_switch').val().toLowerCase();
    		redirectUrl = $("base").attr("href") + landesName + '/' + languageName;
    		$.cookie('langSettingsEao', [languageName,landesName], { expires: 90 , path: '/'});
    		$.cookie('langNameEao', [languageName], { expires: 90 , path: '/'});
    		$.cookie('landNameEao', [landesName], { expires: 90 , path: '/'});
    		window.location.href=redirectUrl;
    	});
    });

  // }
});


