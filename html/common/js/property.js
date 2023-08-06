(function($) {
	$(function() {
		//スクロール
		$('a[href^=#]').click(function() {
		  // スクロールの速度
		  var speed = 400;// ミリ秒
		  // アンカーの値取得
		  var href= $(this).attr("href");
		  // 移動先を取得
		  var target = $(href == "#" || href == "" ? 'html' : href);
		  // 移動先を数値で取得
		  var position = target.offset().top;
		  // スムーススクロール
		  $($.browser.safari ? 'body' : 'html').animate({scrollTop:position}, speed, 'swing');
		  return false;
	   });
		
		if($("#hdMember").size()){
			Rnd = Math.floor( Math.random() * 99999 );
			$("#hdMember").load("/english/member/login/check_login_en/"+Rnd);
			
		}
		
	});
	$(function() {
    var topBtn = $('#pageTop');    
    topBtn.hide();
    //スクロールが100に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
	});
})(jQuery);