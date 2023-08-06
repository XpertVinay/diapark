var domain = location.hostname;
if(domain){
	$domain = '/html/';
}else{
	$domain = '../html/';	
}
document.write('<script type="text/javascript" src="'+$domain+'common/js/jquery-1.7.2.min.js"></script>');
document.write('<script type="text/javascript" src="'+$domain+'common/js/smartRollover.js"></script>');
document.write('<script type="text/javascript" src="'+$domain+'common/js/jquery-ui-1.8.22.custom.min.js"></script>');
document.write('<script type="text/javascript" src="'+$domain+'common/js/jquery.ui.datepicker-ja.js"></script>');
document.write('<script type="text/javascript" src="'+$domain+'common/js/property.js"></script>');
document.write('<!--[if lte IE 6]>');
document.write('<script type="text/javascript" src="'+$domain+'common/js/DD_belatedPNG_0.0.8a-min.js"></script>');
document.write('<script type="text/javascript" src="'+$domain+'common/js/dopingfix.js"></script>');
document.write('<![endif]-->');
