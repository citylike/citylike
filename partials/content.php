<?php require("helpers/escape.php"); ?>

<div id="header" class="group">
	<div id="header-inner" class="group">
		<form id="search" action="http://dribbble.com/search">
			<input type="search" name="q" placeholder="Поиск... " value=""> 
		</form>
		<ul id="nav">
			<li>
				<a href="#">Призы</a>    
			</li>
			<li>
				<a href="#">Правила</a>
			</li>
			<li>
				<a href="#">Помощь</a>
			</li>
		</ul>

		<div id="nav-user-info">
			<?php if (! $user_info): ?>
			<a class="sign-up modal-switch" href="#login-modal">Войти</a>
			<?php endif; ?>
			
			<?php if ($user_info): ?>
			<a href="?authorization=exit"><?php echo esc_html($user_info['first_name']." ".$user_info['last_name']); ?><img class="net_avatar" src="<?php echo esc_url($user_info['network_avatar']); ?>" ></a>
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
			<?php if ($user_info && !isset($user_info['part_id'])): ?>
			<a class="modal-switch" id="participate-but" href="#participate-modal"><button type="button" class="btn btn-default">Участвовать</button></a>
			<?php endif; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div id="pol-grid">
		<?php foreach ($members as $member) : ?>
		<div class="box">            
			<div class="boxInner">
				<div class="imgWrapper">
					<img src="<?php echo esc_url($member['photo']); ?>" />
				</div>
				
				<div class="titleBox">
					<div class="memberName">
						<a href="#"><?php echo esc_html($member['first_name']); ?> <?php echo esc_html($member['last_name']); ?></a>
					</div>
					
					<div class="statistic">
						<div class="post post_full">
							<div class="post_control like unlike" title="Like"></div>
							<span><?php echo intval($member['votes']); ?></span>
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
<div class="bg-fade"></div>
<div id="login-modal" class="cstm-modal">
	<i class="close_login">Закрыть</i>
	<div class="login-block">
		<div class="modal-dialog login-m-b">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Вход</h4>
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
						</ul>
						
						<p class="separator">или</p>
						
						<form method="post" class="fields" id="login">
							<div class="inputs-group">                   
								<div class="text-input">
									<input type="text" name="login[name]" class="first" placeholder="Эл. почта или логин" value="">
									<i class="error-tooltip first"><span></span></i>
								</div>    
								
								<div class="text-input">
									<input type="password" name="login[password]" class="last" placeholder="Пароль" value="">
									<i class="error-tooltip last"><span></span></i>
								</div>                 
							</div>
							
							<p class="form-error"></p>
							
							<input type="submit" class="btn disabled" value="Войти" >              
						</form>
						
						<p>
							<a id="forgot" href="#">Забыли пароль?</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-dialog recovery-m-b" style="display:none">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Восстановление пароля</h4>
				</div>
				
				<div class="modal-body">
					<div class="login-form">
						<form method="post" class="fields" id="recovery">
							<div class="inputs-group">                   
								<div class="text-input">
									<input type="text" name="user[name]" class="first" placeholder="Имя" value="">
								</div>                     								
							</div>
							<p class="form-status loading"></p>
							<input type="submit" class="btn disabled" value="Сбросить пароль">             
						</form>
						<p class="notification">На указанный вами адрес электронной почты будет выслана инструкция по восстановлению пароля</p>
						<p>
							<a id="back" href="#">← Назад</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="change">
			Еще не зарегистрированы? 
			<a href="#registration-modal" id="switch_registration_form" class="inline-btn green modal-switch">Регистрация</a>
		</div>
	</div>
</div>
<div id="registration-modal" class="cstm-modal">
	<i class="close_login">Закрыть</i>
	<div class="login-block">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Регистрация</h4>
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
						<form method="post" class="fields" id="registration">
							<div class="inputs-group">                   
								<div class="text-input">
									<input type="text" name="user[name]" class="first" placeholder="Имя" value="">
									<i class="error-tooltip first"><span></span></i>
								</div>                   
								<div class="text-input">
									<input type="text" name="user[email]" class="second" placeholder="Эл. почта" value="">
									<i class="error-tooltip second"><span></span></i>
								</div>        
								<div class="text-input">
									<input type="password" name="user[password]" class="last" placeholder="Пароль" value="">
									<i class="error-tooltip last"><span></span></i>
								</div>    								
							</div>
							<p class="form-status loading"></p>
							<input type="submit" class="btn disabled" value="Зарегистрироваться">             
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="change">
			Уже регистрировались? 
			<a href="#login-modal" id="switch_login_form" class="inline-btn green modal-switch">Вход</a>
		</div>
	</div>
</div>
<div id="participate-modal" class="cstm-modal">
	<i class="close_login">Закрыть</i>
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Участвовать</h4>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="upload-block">
						<p>Добро пожаловать на конкурс City-Like! Для того, чтобы стать участнице и выиграть диадему, загрузите Ваше фото</p>
						<button id="UploadButton" type="button" class="btn btn-default">Загрузить фото</button>
					</div>
					<div id="cropBox"></div>
					<div id="participate-share">
						<div class="cropped_member_image col-md-4">
							<img class="member_image" src="" />
						</div>
						<form method="POST" id="participate-member-start">
						<div class="form-field">
							<fieldset class="user_name">
								<label for="user_name">Имя</label>
								<input name="member[first_name]" placeholder="<?php echo esc_html($user_info['first_name']); ?>" value="<?php echo esc_html($user_info['first_name']); ?>" size="30" type="text">
							</fieldset>
							<p class="message">Имя которое будет отображаться на Вашей карточке</p>
						</div>
						
						<div class="form-field">
							<fieldset class="user_name">
								<label for="user_name">Фамилия</label>
								<input name="member[last_name]" placeholder="<?php echo esc_html($user_info['last_name']); ?>" value="<?php echo esc_html($user_info['last_name']); ?>" size="30" type="text">
							</fieldset>
							<p class="message">Фамилия которая будет отображаться на Вашей карточке</p>
						</div>
						
						<div class="form-field">
							<fieldset class="user_name">
								<label for="user_name">Ссылка</label>
								<input name="member[permalink]" placeholder="<?php echo esc_html($user_info['slug']); ?>" value="<?php echo esc_html($user_info['slug']); ?>" size="30" type="text">
								<input type="hidden" id="member_image" name="member[image]" value="">
							</fieldset>
							<p class="message">Ссылка на Вашу персональный профиль</p>
						</div>
						
						<input id="submit-share" type="submit" value="Участвовать">
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>