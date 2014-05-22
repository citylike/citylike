	<script type='text/javascript' src='assets/scripts/main.js'></script>
	<script>
	function findById(array, id) {
		for (var i = 0; i < array.length; i++) {
			if (array[i].id_member == id) {
				return i;
			}
		}
	}
	$( ".box .statistic .place span" ).each(function() {
		var mem_id = $(this).closest(".box").attr("data-id");
		var place = findById(members_array, mem_id);
		$(this).html((place+1) + " место");
	});
	</script>
	<script language="javascript">
		VK.init({
		  apiId: 4206762
		});
		function authInfo(response) {
			if (response.session) {
				//alert('user: '+response.session.mid);
				VK.Api.call('users.get', {uids: response.session.mid, fields: "sex,bdate,photo_50,relation"}, function(r) { 
					if(r.response) {
						console.log(r.response[0]);
						var postData = {
							'user_data' : {
								'first_name'  : r.response[0].first_name,
								'last_name'   : r.response[0].last_name,
								'bdate'       : r.response[0].bdate,
								'photo_small' : r.response[0].photo_50,
								'sex'         : r.response[0].sex,
								'uid'         : r.response[0].uid
							}
						};
						$.ajax({
							url: "index.php?authorization=vk",
							type: "post",
							data: postData,
							dataType: 'json',
							success: function(response){
								if (response == '4051'){
									window.location = "http://city-like.ru";
								};
							},
							error:function(){
								alert("failure");
							}
						});
					};
				});
			};
		};
	</script>
	<script>
		var trigger = false;
		// id value we get from href attribute, thats why in jquery selector pass without hash
		var id = '';
		// fade layer
		var fadeLayer = $(".bg-fade");
		var modalConteiner = $(".login-block");
		var modal = $(".cstm-modal");
		// trigger maybe true if want to show modal and false if close, id - modal id you want to show
		function customModal(trigger, id) {
			if (trigger == true) {
				$("body").addClass("modal-overflow-page");
				
				// little hack for show method of crop
				$('[class^="imgareaselect"]').show();
				$(".imgareaselect-selection").parent().css("z-index", "2");
				
				console.log(modal.index());
				fadeLayer.fadeIn(100);
				$(id).show().addClass('animated fadeInDownBig').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass('animated fadeInDownBig');
				});
			}
			
			if (trigger == false) {
				$(id).hide();
				fadeLayer.fadeOut(100);
			}
		};
		
		$(".modal-switch").on('click', function(){
			if  ($(".cstm-modal:visible").length >=1 ){
				$(".cstm-modal:visible").hide();
			}
			// close all previous open modals
			id = $(this).attr('href');
			if ($(id).is(":visible")) {
				trigger = false;
			} else {
				trigger = true;
			}
			
			customModal(trigger, id);
			
			return false;
		});
		
		modal.mousedown(function (e){
			if (!modalConteiner.is(e.target) && modalConteiner.has(e.target).length === 0 && !$(e.target).is('input[type="text"], input[type="password"]')){
				// little hack for participate modal
				if ($(e.target).closest(".modal-content").length == 1) {
					return false;
				}
				
				// little hack for hide method of crop
				$('[class^="imgareaselect"]').hide();
				$(".imgareaselect-selection").parent().css("z-index", "-10");
				$("body").removeClass("modal-overflow-page");
				customModal(false, modal);
			}
		});
		
		$("#forgot").on('click', function(){
			$(".login-m-b").hide();
			$(".recovery-m-b").show().addClass('animated flipInY').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass('animated flipInY');
			});
			return false;
		});
		
		$("#back").on('click', function(){
			$(".recovery-m-b").hide();
			$(".login-m-b").show().addClass('animated flipInY').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass('animated flipInY');
			});
			return false;
		})
	</script>
<script>
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		return pattern.test(emailAddress);
	};
	$("#login input").on("input", function(){
		if ($.trim($("#login input.first").val()) != "" && $.trim($("#login input.last").val()) != ""){
			$("#login input[type='submit']").removeClass("disabled");
		} else {
			$("#login input[type='submit']").addClass("disabled");
		}
	});
	
	$("#registration input").on("input", function(){
		if ($.trim($("#registration input.first").val()) != "" && $.trim($("#registration input.second").val()) != "" && $.trim($("#registration input.last").val()) != "" && isValidEmailAddress($.trim($("#registration input.second").val()))){
			$("#registration input[type='submit']").removeClass("disabled");
		} else {
			$("#registration input[type='submit']").addClass("disabled");
		}
	});
	
	$("#login").submit(function() {
		$(".error-tooltip").hide();
		$("input").removeClass("error");
		$.ajax({
			url: "index.php?authorization=login",
			type: "post",
			data: $("#login").serialize(),
			success: function(response){
				if (response != '4051') $("#login").closest(".modal-dialog").addClass('animated shake').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass('animated shake');
				});
				switch(response)
				{
				case '4051':
					window.location = "http://city-like.ru";
				break;
				case '3':
					$("input.first", "#login").addClass("error");
					$(".error-tooltip.first", "#login").show().find("span").text("Имя должно быть больше 4 символов");
				break;
				case '30':
					$("input.last", "#login").addClass("error");
					$(".error-tooltip.last", "#login").show().find("span").text("Пароль должен быть больше 4 символов");
				break;
				case '33':
					$("input.first", "#login").addClass("error");
					$(".error-tooltip.first", "#login").show().find("span").text("Имя должно быть больше 4 символов");
					$("input.last", "#login").addClass("error");
					$(".error-tooltip.last", "#login").show().find("span").text("Пароль должен быть больше 4 символов");
				break;
				case '300':
					$("input.first", "#login").addClass("error");
					$(".error-tooltip.first", "#login").show().find("span").text("Такого пользователя не существует");
				break;
				case '3000':
					$("input.first", "#login").addClass("error");
					$(".error-tooltip.first", "#login").show().find("span").text("Неверный логин или пароль");
					$("input.last", "#login").addClass("error");
					$(".error-tooltip.last", "#login").show().find("span").text("Неверный логин или пароль");
				break;
				}
			}
		});
		return false;
	});
	
	$("#registration").submit(function() {
		$(".error-tooltip").hide();
		$("input").removeClass("error");
		$.ajax({
			url: "index.php?authorization=email",
			type: "post",
			data: $("#registration").serialize(),
			success: function(response){
				if (response != '4051') $("#registration").closest(".modal-dialog").addClass('animated shake').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass('animated shake');
				});
				switch(response)
				{
				case '4051':
					window.location = "http://city-like.ru";
				break;
				case '1':
					$("input.first", "#registration").addClass("error");
					$(".error-tooltip.first", "#registration").show().find("span").text("Имя должно быть больше 4 символов");
				break;
				case '10':
					$("input.second", "#registration").addClass("error");
					$(".error-tooltip.second", "#registration").show().find("span").text("Неправильный адрес электронной почты");
				break;
				case '100':
					$("input.last", "#registration").addClass("error");
					$(".error-tooltip.last", "#registration").show().find("span").text("Пароль должен быть больше 4 символов");
				break;
				case '11':
					$("input.first", "#registration").addClass("error");
					$(".error-tooltip.first", "#registration").show().find("span").text("Имя должно быть больше 4 символов");
					$("input.second", "#registration").addClass("error");
					$(".error-tooltip.second", "#registration").show().find("span").text("Неправильный адрес электронной почты");
				break;
				case '101':
					$("input.first", "#registration").addClass("error");
					$(".error-tooltip.first", "#registration").show().find("span").text("Имя должно быть больше 4 символов");
					$("input.last", "#registration").addClass("error");
					$(".error-tooltip.last", "#registration").show().find("span").text("Пароль должен быть больше 4 символов");
				break;
				case '110':
					$("input.second", "#registration").addClass("error");
					$(".error-tooltip.second", "#registration").show().find("span").text("Неправильный адрес электронной почты");
					$("input.last", "#registration").addClass("error");
					$(".error-tooltip.last", "#registration").show().find("span").text("Пароль должен быть больше 4 символов");
				break;
				case '111':
					$("input.first", "#registration").addClass("error");
					$(".error-tooltip.first", "#registration").show().find("span").text("Имя должно быть больше 4 символов");
					$("input.second", "#registration").addClass("error");
					$(".error-tooltip.second", "#registration").show().find("span").text("Неправильный адрес электронной почты");
					$("input.last", "#registration").addClass("error");
					$(".error-tooltip.last", "#registration").show().find("span").text("Пароль должен быть больше 4 символов");
				break;
				case '2':
					$("input.first", "#registration").addClass("error");
					$(".error-tooltip.first", "#registration").show().find("span").text("Такое имя уже существует");
				break;
				case '20':
					$("input.second", "#registration").addClass("error");
					$(".error-tooltip.second", "#registration").show().find("span").text("Такой email уже существует");
				break;

				}
			}
		});
		return false;
	});
	
	$(".error-tooltip").hover(function(){
		$(this).find("span").show();
	},
	function(){
		$(this).find("span").hide();
	});
</script>
<script>
	$("#UploadButton").ajaxUpload({
		url : "index.php?upload=true",
		name: "file",
		onSubmit: function() {
			//$('#cropBox').html('Uploading ... ');
		},
		onComplete: function(result) {
			$('.upload-block').hide();
			$('#cropBox').show().html('<img class="crop_image" src="upload_dir/'+result+'" /></br><button id="cropSendButton" type="button" class="btn btn-default">Сохранить</button>');

			var ias = $('img.crop_image').imgAreaSelect({		
				instance: true,
				x1: 0,
				x2: 500,
				y1: 0,
				y2: 700,
				aspectRatio: '3:3',
				handles: true,
				onInit: function(img, selection){
					var square_sizes = 270;
					var naturalImageHeight = $("#cropBox img.crop_image").css('max-height', 'none').css('max-width', 'none').height();
					$("#cropBox img.crop_image").css('max-height', '565px').css('max-width', '610px');
					var coefficientImageSize = naturalImageHeight/$("#cropBox img.crop_image").height();
					console.log(coefficientImageSize);
					
					var loaded_image_width = $("#cropBox img.crop_image").width();
					var loaded_image_heigth = $("#cropBox img.crop_image").height();
					
					if (loaded_image_width >= loaded_image_heigth) square_sizes = loaded_image_heigth;
					if (loaded_image_width < loaded_image_heigth) square_sizes = loaded_image_width;
					
					ias.setOptions({ resizable: false });
					ias.setSelection(0, 0, square_sizes, square_sizes);
					ias.update();
					
					var postData = {
					    'src' : result,
						'x'  : 0,
						'y'  : 0,
						'w'  : square_sizes*coefficientImageSize,
						'h' : square_sizes*coefficientImageSize
					};
					
					$("body").on("click", "#cropSendButton", function(){
						console.log(postData);
						ias.cancelSelection();
						$.ajax({
							url: "index.php?crop=true",
							type: "post",
							data: postData,
							success: function(response){						
								$("#cropBox").hide();
								$("#participate-share").show();
								$("#participate-share .cropped_member_image img").attr("src", response);
								$("#participate-share #member_image").val(response);
							}
						});
					});
				},
				
				onSelectEnd: function (img, selection) {
					
					var naturalImageHeight = $("#cropBox img.crop_image").css('max-height', 'none').css('max-width', 'none').height();
					$("#cropBox img.crop_image").css('max-height', '565px').css('max-width', '610px');
					var coefficientImageSize = naturalImageHeight/$("#cropBox img.crop_image").height();

					var postData = {
					    'src' : result,
						'x'  : selection.x1*coefficientImageSize,
						'y'  : selection.y1*coefficientImageSize,
						'w'  : (selection.x2 - selection.x1)*coefficientImageSize,
						'h' : (selection.y2 - selection.y1)*coefficientImageSize
					};
					
					$("body").on("click", "#cropSendButton", function(){
						console.log(postData);
						ias.cancelSelection();
						$.ajax({
							url: "index.php?crop=true",
							type: "post",
							data: postData,
							success: function(response){
								$("body").removeClass("noselect");
								$("#cropBox").hide();
								$("#participate-share").show();
								$("#participate-share .cropped_member_image img").attr("src", response);
								$("#participate-share #member_image").val(response);
							}
						});
					});
				}
			});
		}
	});
</script>
<script>
$("#participate-member-start").submit(function() {
		$.ajax({
			url: "index.php?participate=true",
			type: "post",
			data: $("#participate-member-start").serialize(),
			success: function(response){
				$("body").addClass("noselect");
				console.log($.parseJSON(response));
				var oMember = $.parseJSON(response);
				console.log(oMember);
				$("#pol-grid").prepend( '<div class="box"><div class="boxInner"><div class="imgWrapper"><img src="'+oMember.image+'" /></div><div class="titleBox"><div class="memberName"><a href="'+oMember.permalink+'">'+oMember.first_name+' '+oMember.last_name+'</a></div><div class="statistic"><div class="post post_full"><div class="post_control like unlike" title="Like"></div><span>10</span></div><div class="place"><span>67 место</span></div></div></div></div></div>' );
				customModal(false, '#participate-modal');
				$("#participate-but").remove();
				$("#participate-modal").remove();
			}
		});
		return false;
	});
</script>
</body>
</html>