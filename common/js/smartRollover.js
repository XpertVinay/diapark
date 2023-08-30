//http://css-happylife.com/archives/2007/0621_0010.php

function smartRollover() {
	if(document.getElementsByTagName) {
		$('.rollover').each(function(){
			var images = $(this);
			if(images.attr('src').match(".")){
				images.mouseover(function(){
					this.setAttribute("src", this.getAttribute("src").replace(".gif", "_on.gif"));
					this.setAttribute("src", this.getAttribute("src").replace(".jpg", "_on.jpg"));
					this.setAttribute("src", this.getAttribute("src").replace(".png", "_on.png"));
				});
				images.mouseout(function(){
					this.setAttribute("src", this.getAttribute("src").replace("_on.gif", ".gif"));
					this.setAttribute("src", this.getAttribute("src").replace("_on.jpg", ".jpg"));
					this.setAttribute("src", this.getAttribute("src").replace("_on.png", ".png"));
				});
			}
		});

	}
}

if(window.addEventListener) {
	window.addEventListener("load", smartRollover, false);
}
else if(window.attachEvent) {
	window.attachEvent("onload", smartRollover);
}