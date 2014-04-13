<div id="header" class="group">
	<div id="header-inner" class="group">
      <form id="search" action="http://dribbble.com/search">
        <input type="search" name="q" placeholder="Поиск... " value=""> 
      </form>
  <ul id="nav">

    <li>
      <a href="#">
        <span>Призы</span>
</a>    </li>
    <li>
      <a href="#">Правила</a>
    </li>
    <li>
      <a href="#">Помощь</a>
    </li>
  </ul>

	<div id="nav-user-info">
		<?php if (! $user_info): ?>
		<a class="sign-up" data-toggle="modal" data-target="#login-modal" href="#">Войти</a>
		<?php endif; ?>
		
	  	<?php if ($user_info): ?>
		<a href="?authorization=exit"><?php echo $user_info['first_name']; ?> <?php echo $user_info['last_name']; ?> <img class="net_avatar" src="<?php echo $user_info['network_avatar']; ?>" ></a>
		<?php endif; ?>
	</div>
	<div class="clearfix"></div>

</div>
</div>

<div class="wrap">
	<div id="user-interface">
		<div id="filters">
			<button type="button" class="btn btn-default">ТОП 5</button>
			<button type="button" class="btn btn-default">По дате</button>
			<button type="button" class="btn btn-default">По популярности</button>
		</div>
		<div class="clearfix"></div>
	</div>
	<div id="pol-grid">
		<?php foreach ($members as $member) : ?>
		<div class="box">            
			<div class="boxInner">
				<div class="imgWrapper">
					<img src="<?php echo $member['photo']; ?>" />
				</div>
				<div class="titleBox">
					<div class="memberName">
						<a href="#"><?php echo $member['first_name']; ?> <?php echo $member['last_name']; ?></a>
					</div>
					
					<div class="statistic">
						<div class="post post_full">
							<div class="post_control like unlike" title="Like"></div>
							<span><?php echo $member['votes']; ?></span>
						</div>
						<div class="place">
						<span>67 место</span>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	
</div>
  
  <!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true">
	<i class="close_login" data-dismiss="modal">Закрыть</i>
	<div class="login-block">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Вход</h4>
				</div>
				<div class="modal-body">
					<div class="login-form">
						<ul class="social-links">
							<li>
							<a href="https://api.instagram.com/oauth/authorize/?client_id=1658ab65bb8b480a869d1be346857070&amp;redirect_uri=http://city-like.ru&amp;response_type=code" class="ig">Instagram</a>
							</li> 
							<li>
							<a href="javascript:void(0)" onclick="VK.Auth.login(authInfo);" class="vk">Вконтакте</a>
							</li>
							<li>
						</ul>
						<p class="separator">или</p>
						<form action="/session" method="post" class="fields" id="sessions_new" autocomplete="off">
							<div class="inputs-group">                   
								<div class="text-input">
									<input type="text" name="user[email]" class="first" placeholder="Эл. почта или логин" value="">
								</div>                   
								<div class="text-input">
									<input type="password" name="user[password]" class="last" placeholder="Пароль" value="">
								</div>                 
							</div>                 
							<button class="btn disabled" id="signin">Войти</button>               
						</form>
						<p>
							<a href="#" role="toggle_forgot_password_form">Забыли пароль?</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="change">
			Еще не зарегистрированы? 
			<a href="#" id="switch_registration_form" class="inline-btn green">Регистрация</a>
		</div>
	</div>
</div>
<div class="modal fade" id="registration-modal" tabindex="-1" role="dialog" aria-labelledby="registration-modalLabel" aria-hidden="true">
	<i class="close_login" data-dismiss="modal">Закрыть</i>
	<div class="login-block">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Регистрация</h4>
				</div>
				<div class="modal-body">
					<div class="login-form">
						<ul class="social-links">
							<li>
							<a href="https://api.instagram.com/oauth/authorize/?client_id=1658ab65bb8b480a869d1be346857070&amp;redirect_uri=http://city-like.ru&amp;response_type=code" class="ig">Instagram</a>
							</li> 
							<li>
							<a href="javascript:void(0)" onclick="VK.Auth.login(authInfo);" class="vk">Вконтакте</a>
							</li>
							<li>
						</ul>
						<p class="separator">или</p>
						<form action="/session" method="post" class="fields" id="sessions_new" autocomplete="off">
							<div class="inputs-group">                   
								<div class="text-input">
									<input type="text" name="user[name]" class="first" placeholder="Имя" value="">
								</div>                   
								<div class="text-input">
									<input type="password" name="user[emal]" class="last" placeholder="Эл. почта" value="">
								</div>        
								<div class="text-input">
									<input type="password" name="user[password]" class="last" placeholder="Пароль" value="">
								</div>    								
							</div>                 
							<button class="btn disabled" id="signin">Войти</button>               
						</form>
						<p>
							<a href="#" role="toggle_forgot_password_form">Забыли пароль?</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="change">
			Уже регистрировались? 
			<a href="#" id="switch_login_form" class="inline-btn green">Вход</a>
		</div>
	</div>
</div>