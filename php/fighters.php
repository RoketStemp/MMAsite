<?php
session_start();
require_once 'db.php';

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
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
<?php
	$string="";
	if (isset($_GET['filter'])) {
		if($_GET['filter'] == "All Styles"){
			$string="";
		}else{
			$string = "WHERE typeweight.weightID='".$_GET['filter']."'";
		}
	} 
	$query ="SELECT fighterID, name, surname, photo, country, age, statistic, typeweight.typeofWeight AS 'Weight' FROM fighter INNER JOIN typeweight ON fighter.weight=typeweight.weightID ".$string." ORDER BY fighterID DESC";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
	echo "<div class='container'>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<div class='row col-md-6 d-inline-block ml-1'>";
			echo "<div class='card mt-3' style='max-width: 540px;'>";
				echo "<div class='row no-gutters' style='position:relative!important;'>";
					if ($_SESSION['adminNotAUsualUser'] == "admin") {
						echo "<form method='GET'><button id='pencilF' type='submit' name='newsEdit' class='justify-content-center text-center bg-success text-white' value='".$row['fighterID']."'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
						echo "<button id='deleteF' type='submit' name='delete' class='justify-content-center text-center bg-danger text-white' value='".$row['fighterID']."'>X</button></form>";
					}
				    echo "<div class='col-md-4'>";
				      	echo "<img src='".$row['photo']."' class='card-img'>";
				    echo "</div>";
				    echo "<div class='col-md-8'>";
				      	echo "<div class='card-body'>";
				        	echo "<h5 class='card-title'>".$row['name']." ".$row['surname']."</h5>";
				        	echo "<hr>";
				        	echo "<p class='card-text'>Возраст: <span class='text-secondary'>".$row['age']."</span> </p>";
				        	echo "<p class='card-text'>Вес: <span class='text-secondary'>".$row['Weight']."</span> </p>";
				        	echo "<p class='card-text'>Статистика: <span class='text-secondary'>".$row['statistic']."</span> </p>";
				        	echo "<p class='card-text invisible' style='height:10px;'> ".$row['statistic']."</p>";
				        	echo "<p class='card-text text-center bg-dark text-light'> ".$row['country']."</p>";
				     	echo "</div>";
				    echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";	
	}
	echo "</div>";
}
?>
<!------------------------------------Add panel-------------------------------------->
<?php 
if (isset($_POST['add'])) {
	$query="INSERT INTO `fighter`(`fighterID`, `name`, `surname`, `YOB`, `age`, `weight`, `statistic`, `country`, `photo`) VALUES (NULL,'".$_POST['name']."','".$_POST['surname']."','".$_POST['yob']."','".$_POST['age']."','".$_POST['weight']."','".$_POST['statistic']."','".$_POST['country']."','".$_POST['image']."')";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("fighters.php");
}
?>
<!------------------------------------Edit panel-------------------------------------->
<?php 
if (isset($_POST['edit'])) {
	$query="UPDATE `fighter` SET `name`='".$_POST['name']."',`surname`='".$_POST['surname']."',`YOB`='".$_POST['yob']."',`age`='".$_POST['age']."',`weight`='".$_POST['weight']."',`statistic`='".$_POST['statistic']."',`country`='".$_POST['country']."',`photo`='".$_POST['image']."' WHERE `fighterID`='".$_GET['newsEdit']."'";
	var_dump($query);
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("fighters.php");
}
?>
<!------------------------------------Delete panel-------------------------------------->
<?php 
if (isset($_GET['delete'])) {
	$query="DELETE FROM fighter WHERE `fighterID`='".$_GET['delete']."'";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("fighters.php");
}
?>
<div id='add' class=' addStuff bg-success collapse <?php if (isset($_GET['newsEdit']) || $_SESSION['adminNotAUsualUser'] != "admin") {echo "hide";} else {echo "show"; } ?> text-center justify-content-center rounded-circle pb-1 text-white'><p id="plus">+</p></div>
<div id='addFightersField' class='addStuff bg-success collapse <?php if (isset($_GET['newsEdit'])) {echo "show";} else {echo "hide"; } ?> rounded pb-1 text-white'>
	<form method='POST'>
		<div class="form-group mt-3">
			<div class="custom-file col-sm-11 ml-1">
				<span>Имя: </span>
				<input type="text" name="name" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Фамилия: </span>
				<input type="text" name="surname" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<label class="d-inline-block" for="type">Вес:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="type" name="weight">
					<?php 
						$query = "SELECT * FROM typeweight";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['weightID']."'>".$row['typeofWeight']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Возраст: </span>
				<input type="text" name="age" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Год рождения: </span>
				<input type="text" name="yob" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Статистика: </span>
				<input type="text" name="statistic" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Страна: </span>
				<input type="text" name="country" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Картинка: </span>
				<input type="text" name="image" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<button id="droom" type="submit" class="btn btn-secondary mr-5 float-right" name='<?php if (isset($_GET['newsEdit'])) {echo "edit";} else {echo "add"; } ?>'>
			<?php if (isset($_GET['newsEdit'])) {
				echo "Отредактировать бойца";
			} else {
				echo "Добавить бойца";
			} ?>
		</button>
	</form>
</div>
<div class="dropdown" style='position: fixed;right: 2%; top:15%; z-index:10000' >
	<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите вес:</button>
	<form method='GET'>
		<ul class="dropdown-menu m-0 p-0" >
			<?php 
			$query = "SELECT * FROM typeweight";
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
			while ($row = mysqli_fetch_array($result)) {
				echo "<button class='btn btn-secondary'style='font-size:0.9em; width:100%;' type='submit' name='filter' value='".$row['weightID']."'>".$row['typeofWeight']."</button>";
			}
				echo "<button class='btn btn-secondary'style='font-size: 0.9em;width:100%;' type='submit' name='filter' value='All Styles'>Любой вес</button>";
			?>
		</ul>
	</form>
</div>
<!-------------------------------------------------------------------------->
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
<script type="text/javascript">
$(document).ready(function(){
	$("#add").click(function(){
		$("#add").collapse('hide');
		$("#addFightersField").collapse('show');
	});
	$("#pencilF").click(function(){
		$("#add").collapse('hide');
		$("#addFightersField").collapse('show');
	});
	$("#droom").click(function(){
		$("#add").collapse('show');
		$("#addFightersField").collapse('hide');
	});
});
</script>
</body>
</html>