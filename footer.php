	<script type='text/javascript' src='assets/scripts/main.js'></script>
	<script type='text/javascript' src='assets/scripts/bootstrap.min.js'></script>
	<script language="javascript">
		VK.init({
		  apiId: 4206762
		});
		function authInfo(response) {
		  if (response.session) {
			alert('user: '+response.session.mid);
		  } else {
			alert('not auth');
		  }
		}
		VK.Auth.getLoginStatus(authInfo);
	</script>
</body>
</html>