function Ajx(ajax,btn,div){
	ajax.requestFile = "../../../../ajax.php";
	ajax.method = "POST";
	ajax.onCompletion = function(){
		var text = ajax.response;
		eval(text);
		if (typeof(btn)==='undefined' || btn === null || btn == '') { btn = ''; } else {
			$('#' + btn).prop("disabled",false);
			$('#' + btn + ' > i').remove('.fa-cog');
		}		
		if (typeof(div)==='undefined' || div === null || div == '') { div = ''; } else {
			$('#' + div).addClass("hide");
			$('#' + div).hide();
		}
	};
	ajax.runAJAX();
	if (typeof(btn)==='undefined' || btn === null || btn == '') { btn = ''; } else {
		$('#' + btn).prop("disabled",true);
		$('#' + btn).prepend('<i class="fa fa-cog fa-spin"></i> ');
	}
	if (typeof(div)==='undefined' || div === null || div == '') { div = ''; } else {
		$('#' + div).removeClass("hide");
		$('#' + div).show();
	}
}
function Pipeline() {
    setTimeout(function() {
	    var ajax = new sack();
	    ajax.setVar("op","pipeline");
	    Ajx(ajax);
	}, 2000);
}