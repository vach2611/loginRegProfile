$(function() {
	// $('#img').change(function(){
	//         var file = this.files[0];
	//         if (file.name!=""){
	//         	$("#form1").click();
	// 		}

	// });

	$(window).mousemove(function(event) {
	  $(".first").css({
	    "margin-left": -(event.pageX * 0.02),
	    "margin-top": -(event.pageY * 0.02)
	  });
	});





	var reader = new FileReader();
	reader.onload = function (e) {
	    $('#prof_img').attr('src', e.target.result);
	}
	   
	   function readURL(input) {
	        if (input.files && input.files[0]) {
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
	    
	    $("#img").change(function(){
	        readURL(this);
	    });



	// $('#form2').click(function(){
	// 	$('#form1').submit();
	// })



});




