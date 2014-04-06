	<script type='text/javascript' src='assets/scripts/main.js'></script>
	<script type='text/javascript' src='assets/scripts/bootstrap.min.js'></script>
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
							success: function(){
								alert("success");
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
</body>
</html>