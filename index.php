<?php
require $_SERVER['DOCUMENT_ROOT'] . "/articles/includes/authcheck.php";
$title = "Members Home";
include $_SERVER['DOCUMENT_ROOT'] . "/articles/header.php";

//echo "<pre>", print_r($_SESSION), "</pre>";
?>


<table class='centerTable'>
	<tr>
		<td><p><img src="/articles/img/logo.PNG" alt="Archive Logo" width="557" height="467" /></p></td>
	</tr>
</table>

<div id='navItem'>
	<ul>
		<li><a href="/articles/members/archive/articles.php">View articles</a></li>
	</ul>
</div>
