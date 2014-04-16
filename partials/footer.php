	<script type='text/javascript' src='assets/scripts/main.js'></script>
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
			if (!modalConteiner.is(e.target) && modalConteiner.has(e.target).length === 0){
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
</body>
</html>