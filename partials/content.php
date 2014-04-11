<div id="menu" style="display:none">
	<button type="button" class="btn btn-primary">Правила</button>
	<button type="button" class="btn btn-primary">Призы</button>
	<button type="button" class="btn btn-primary">О Проекте</button>
	<input type="search" placeholder="Search">
	<button type="button" class="btn btn-primary">Топ 5</button>
	<button type="button" class="btn btn-primary">Рейтинг</button>
	<?php if (! $user_info): ?>
		<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-lg">Login</button>
	<?php endif; ?>
	<?php if ($user_info): ?>
	<a href="?authorization=exit"><?php echo $user_info['first_name']; ?> <?php echo $user_info['last_name']; ?> <img class="net_avatar" src="<?php echo $user_info['network_avatar']; ?>" ></a>
	<?php endif; ?>
</div>
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
</div></div>

<div class="wrap">
	
	<?php foreach ($members as $member) : ?>
    <div class="box">            
      <div class="boxInner">
        <div class="imgWrapper">
          <img src="<?php echo $member['photo']; ?>" />
        </div>
        <div class="titleBox">        
            <a href="#" class="memberName"><?php echo $member['first_name']; ?> <?php echo $member['last_name']; ?></a>
            <div class="heartWrapper">
                    <div class="post_full">
                <div class="post_control  icon-heart-1 like" title="Like"> 
                </div>
            </div>
            <span><?php echo $member['votes']; ?></span>
          </div>
        </div>
      </div>
    </div>
	<?php endforeach; ?>
	
</div>
  
  <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Вход</h4>
			</div>
			<div class="modal-body">
				<ul class="social-links">
					<li>
					<a href="/auth/facebook" class="fb">Facebook</a>
					</li> 
					<li>
					<a href="javascript:void(0)" onclick="VK.Auth.login(authInfo);" class="vk">Вконтакте</a>
					</li>
					<li>
					<a href="/auth/twitter" class="tw">Twitter</a>
					</li>
					<li>
					<a href="/auth/google_oauth2" class="gplus">Google +</a>
					</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>