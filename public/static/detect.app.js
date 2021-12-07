
if(typeof blockAdBlock === 'undefined') {
	engageBlock();
} else {
	blockAdBlock.onDetected(engageBlock);
}

blockAdBlock.setOption({
	checkOnLoad: true,
	resetOnEnd: false
});

function engageBlock() {
  $("body").html('');
  $("body").prepend('<div id="detect-app" style="width: 500px;margin: 100px auto;text-align: center""><h3>'+detect.on+'<span style="font-size: 0.8em;display: block;">'+detect.detail+'</span></h3></div>');
  $("#detect-app").css("height", $(document).height()).hide();
  $("#detect-app").fadeIn();
}