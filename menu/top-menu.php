<nav id="menu">
    <ul class="sf-menu sf-js-enabled sf-shadow">
    <?php
	if(strstr($_SERVER['REQUEST_URI'],"/index.php")){
		echo '<li class="current">';
	}else{
		echo '<li>';
	}
	?>
    <a href="index.php">Dashboard</a>
    </li>
    
	<?php
    if(strstr($_SERVER['REQUEST_URI'],"/form_member.php")){
		echo '<li class="current">';
	}else{
		echo '<li>';
	}
	?>
    <a href="form_member.php">Add new member</a>
    </li>
    <?php
    if(strstr($_SERVER['REQUEST_URI'],"/searcher.php")){
		echo '<li class="current">';
	}else{
		echo '<li>';
	}
	?>
    <a href="searcher.php">Searcher</a>
    </li>
    <?php
    if(strstr($_SERVER['REQUEST_URI'],"/invoices.php")){
		echo '<li class="current">';
	}else{
		echo '<li>';
	}
	?>
    <a href="invoices.php">Invoices</a>
    </li>
    <?php
    if(strstr($_SERVER['REQUEST_URI'],"/setting.php")){
		echo '<li class="current">';
	}else{
		echo '<li>';
	}
	?>
    <a href="setting.php">Setting</a>
    </li>
    </ul>
</nav>