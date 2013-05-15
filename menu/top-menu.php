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
    <!--
    <li>
    <a class="sf-with-ul" href="styles.html">
    Ejemplo Styles
    <span class="sf-sub-indicator"> »</span>
    </a>
    <ul class="sf-js-enabled sf-shadow" style="float: none; width: 12em; display: none; visibility: hidden;">
    <li style="white-space: normal; float: left; width: 100%;">
    <a href="styles.html" style="float: none; width: auto;">Basic Styles</a>
    </li>
    <li style="white-space: normal; float: left; width: 100%;">
    <a class="sf-with-ul" href="#" style="float: none; width: auto;">
    Sample Pages...
    <span class="sf-sub-indicator"> »</span>
    <span class="sf-sub-indicator"> »</span>
    </a>
    <ul class="sf-js-enabled sf-shadow" style="left: 12em; float: none; width: 12em; display: none; visibility: hidden;">
    <li style="white-space: normal; float: left; width: 100%;">
    <a href="samples-files.html" style="float: none; width: auto;">Files</a>
    </li>
    <li style="white-space: normal; float: left; width: 100%;">
    <a href="samples-products.html" style="float: none; width: auto;">Products</a>
    </li>
    </ul>
    </li>
    </ul>
    </li>
    -->
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