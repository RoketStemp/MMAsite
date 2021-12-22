<?php
session_start();
require_once 'db.php'; 

if (isset($_POST['enter'])) {
	if ($_POST['login']=="admin" && $_POST['password'] == "123") {
		$_SESSION['adminNotAUsualUser'] = $_POST['login'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="alisa">
	<div class="container">
		<ul class="nav justify-content-center mt-3" style="max-height: 50px;">
		    <a href="/index.php"><img id="ufc" src="images/logo.png"></a>
		</ul>
	</div>
	<hr>
	<div id='uno' class="container col-md-6 collapse mt-3 justify-content-center text-center">
	  	<li class="row d-inline-block col-sm-3 bg-light">
	       	<a id='qq' class="nav-link ff" href="/php/events.php">События</a>
	    </li>
	    <li class="row d-inline-block col-sm-3 ml-3 bg-light">
	        <a id='ee' class="nav-link ff" href="/php/fighters.php">Бойцы</a>
	    </li>
	    <li class="row d-inline-block col-sm-3 ml-3 bg-light">
	        <a id='ww' class="nav-link ff" href="/php/rates.php">Рейтинги</a>
	    </li>
	</div>
</div>
<form method='POST'>
	<input type="text" name="login">
	<input type="text" name="password">
	<button type="submit" name="enter">Вход</button>
</form>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#ufc").mouseenter(function(){
		$("#uno").collapse('show');
	});
	$("#alisa").mouseleave(function(){
		$("#uno").collapse('hide');
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#ee").mouseenter(function(){
		$("#ee").css('color','red');
	});
	$("#qq").mouseenter(function(){
		$("#qq").css('color','red');
	});
	$("#ww").mouseenter(function(){
		$("#ww").css('color','red');
	});
	$("#qq").mouseleave(function(){
		$("#qq").css('color','black');
	});
	$("#ee").mouseleave(function(){
		$("#ee").css('color','black');
	});
	$("#ww").mouseleave(function(){
		$("#ww").css('color','black');
	});
});
</script>
</body>
</html>
