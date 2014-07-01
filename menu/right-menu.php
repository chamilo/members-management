<aside class="column width2">
    <div id="rightmenu">
    <header>
    <h3>Your Account</h3>
    </header>
    <dl class="first">
    <dt>
    <img width="16" height="16" src="img/key.png" alt="">
    </dt>
    <dd>
    <a href="profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']); ?>)</a>
    </dd>
    <dd class="last"><?php echo htmlspecialchars($_SESSION['email']); ?></dd>
    </dl>
    </div>
    <div class="content-box">
    <header style="cursor: s-resize;">
    <h3>Chamilo Community</h3>
    </header>
    <section>
    <?php
	$link = conectar();
	$sql = "SELECT * FROM links";
    $result_link = $link->query($sql);
	while($aux_link = $result_link->fetch_assoc()){
		echo '<dl>';
		echo '<dt>'.$aux_link['title'].'</dt>';
		echo '<dd>';
		$enlace = (strpos($aux_link['enlace'],'http') === false)?('http://'.$aux_link['enlace']):($aux_link['enlace']);
		echo '<a href="'.$enlace.'">'.$aux_link['description'].'</a>';
		echo '</dd>';
	}
    $result_link->free();
	?>    
    </dl>
    </section>
    </div>
</aside>