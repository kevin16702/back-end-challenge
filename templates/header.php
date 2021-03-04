<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Back end challenge</title>
    <meta name="description" content="It's a task lists system, where users can create delete and modify tasks">
    <meta name="author" content="Kevin Bouwmeester">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 	
</head>
<body style="overflow:scroll; display:flex;flex-direction:column">
	<nav class="col-2 h-100" style="position:fixed; overflow-x:hidden; z-index:1; background-color: #d1d1d1">
	<ul style="list-style:none">
		<li class="btn"><h1><a href="<?= URL ?>home/index">Home</a></h1></li>
		
		<div class="btn dropdown show">
			<a class="dropdown-toggle text-primary" style="font-size: 2.5em;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="<?= URL ?>student/index">Manege</a>
				<div class="dropdown-menu text-center" aria-labelledby="dropdownMenuLink">
					<h3 class="dropdown-item text-primary"><a href="<?= URL ?>student/index">Home</a></h3>
					<h3 class="dropdown-item text-primary"><a href="<?= URL ?>lists/overview-lists">Relatie beheer</a></h3>
		</div>
	</ul>
	</nav>
	<div class="container mx-auto border-rounded border col-8" style="border-radius:15px; background-color:whitesmoke">
