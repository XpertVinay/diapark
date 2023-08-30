//カレンダー表示
(function($) {
	var month_en = new Array("","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	$(function() {
		$("#datepicker1").datepicker();
		$("#datepicker1").datepicker("option", "minDate", 0);
		$("#datepicker1").datepicker("option", "maxDate",365);
		$("#datepicker1").datepicker("option", "showOn", 'button');
		$("#datepicker1").datepicker("option", "buttonImageOnly", true);
		$("#datepicker1").datepicker("option", "buttonImage", '/image/home_bt_calendar.gif');
		$("#datepicker1").datepicker("option", "buttonText", '');
		$('#datepicker1').bind("change", function() {
			setDatePulldown1($(this).val());
		});
		
		$('#start_month').bind("change", function() {
			setDateHidden1();
		});
		
		$('#start_day').bind("change", function() {
			setDateHidden1();
		});
		
		$('#search_button').click(function(){
			$("#arrive_date").val($("#start_month option:selected").val()+'/'+$("#start_day option:selected").val());
			$("#depart_date").val($("#end_month option:selected").val()+'/'+$("#end_day option:selected").val());
			$("#to_synxis").submit();
		});
		
		$("#datepicker2").datepicker();
		$("#datepicker2").datepicker("option", "minDate", 0); ///カレンダー最小値 0は今日。昨日は-1、明日は1。又は下記maxDateと同様のフォーマットも可
		$("#datepicker2").datepicker("option", "maxDate", 365);///カレンダー最大値プログラムから動的に出してももいいですね。
		$("#datepicker2").datepicker("option", "showOn", 'button');
		$("#datepicker2").datepicker("option", "buttonImageOnly", true);
		$("#datepicker2").datepicker("option", "buttonImage", '/image/home_bt_calendar.gif');
		$("#datepicker2").datepicker("option", "buttonText", '');
		$('#datepicker2').bind("change", function() {
			setDatePulldown2($(this).val());
		});
		
		$('#end_month').bind("change", function() {
			setDateHidden2();
		});
		
		$('#end_day').bind("change", function() {
			setDateHidden2();
		});
	});
	
////Datepickerの日付がクリックされた時にプルダウンを変更させる関数
	function setDatePulldown1(date) {
		$("#arrive_date").val(date);
		var dates = date.split('/');
		$("#start_month").val(dates[0]+'/'+dates[1]);
		//$("#m").val(dates[1]);
		$("#start_day").val(dates[2]);
		//トップページ
		if($("#dk0-start_day").size()){
			
			$("#dk1-combobox").text(month_en[dates[1]]+' '+dates[0]);
			$("#dk0-combobox").text(dates[2]);
		}
		//$( "#datepicker2" ).datepicker( "option", "minDate", date );
		var month = $("#end_month").val();
		var yearmonth = month.split('/');
		var day = parseInt($("#end_day").val());
		var date1 = new Date(dates[0],dates[1] - 1,dates[2]);
		var date2 = new Date(yearmonth[0], yearmonth[1] - 1, day);
		if(date1 >= date2){
			//選択した日の次の日
			var myDate = new Date(dates[0],dates[1] - 1,dates[2]);
			var dayOfMonth = myDate.getDate();
			myDate.setDate(dayOfMonth + 1);
			dates[0] = myDate.getFullYear();
			dates[1] = myDate.getMonth()+1;
			dates[2] = myDate.getDate();
			var newdate = dates[0]+'/'+dates[1]+'/'+dates[2];
			$('#datepicker2').val(newdate);
			$("#depart_date").val(newdate);
			$("#end_month").val(dates[0]+'/'+dates[1]);
			$("#end_day").val(dates[2]);
			if($("#dk2-end_day").size()){
				$("#dk3-combobox").text(month_en[dates[1]]+' '+dates[0]);
				$("#dk2-combobox").text(dates[2]);
			}
		}
		
	}
	function setDatePulldown2(date) {
		$("#depart_date").val(date);
		var dates = date.split('/');
		$("#end_month").val(dates[0]+'/'+dates[1]);
		//$("#m").val(dates[1]);
		$("#end_day").val(dates[2]);
		//トップページ
		if($("#dk2-end_day").size()){
			$("#dk3-combobox").text(month_en[dates[1]]+' '+dates[0]);
			$("#dk2-combobox").text(dates[2]);
		}
		
		//$( "#datepicker1" ).datepicker( "option", "maxDate", date );
		var month = $("#start_month").val();
		var yearmonth = month.split('/');
		var day = parseInt($("#start_day").val());
		var date1 = new Date(dates[0],dates[1] - 1,dates[2]);
		var date2 = new Date(yearmonth[0], yearmonth[1] - 1, day);
		if(date1 <= date2){
			//指定日の1日前
			var myDate = new Date(dates[0],dates[1] - 1,dates[2]);
			var dayOfMonth = myDate.getDate();
			myDate.setDate(dayOfMonth - 1);
			dates[0] = myDate.getFullYear();
			dates[1] = myDate.getMonth()+1;
			dates[2] = myDate.getDate();
			var newdate = dates[0]+'/'+dates[1]+'/'+dates[2];
			$('#datepicker1').val(newdate);
			$("#arrive_date").val(newdate);
			$("#start_month").val(dates[0]+'/'+dates[1]);
			$("#start_day").val(dates[2]);
			//トップページ
			if($("#dk0-start_day").size()){
				$("#dk1-combobox").text(month_en[dates[1]]+' '+dates[0]);
				$("#dk0-combobox").text(dates[2]);
			}
		}
		
	}
////プルダウンが変更されたときに日付をDatepickerに反映させる関数
	function setDateHidden1() {
		if ($("#start_month").val() == '' || $("#start_day").val() == '') {return;}
　　　　	//var year = parseInt($("#start_month").val());
		var month = $("#start_month").val();
		var yearmonth = month.split('-');
		var day = parseInt($("#start_day").val());
		var newdate =month + "/" + day;
		$('#datepicker1').val(newdate);
		$("#arrive_date").val(newdate);
	}
	function setDateHidden2() {
		if ($("#end_month").val() == '' || $("#end_day").val() == '') {return;}
　　　　	//var year = parseInt($("#start_month").val());
		var month = $("#end_month").val();
		var day = parseInt($("#end_day").val());
		var newdate = month + "/" + day;
		$('#datepicker2').val(newdate);
		$("#depart_date").val(newdate);
	}
	setDateHidden1();
	setDateHidden2();
})(jQuery);