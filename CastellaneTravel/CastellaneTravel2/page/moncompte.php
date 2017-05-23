<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Clean Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
	<?php include '../include/nav_page.php'; ?>

    <!-- Page Header -->
	<?php include '../include/pageheader_page.php'; ?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Panel with panel-primary class</div>
					<div class="panel-body">
						<form name="sentMessage" id="contactForm" novalidate>
							<div class="row control-group">
								<div class="form-group col-xs-12 floating-label-form-group controls">
									<label>Name</label>
									<input type="text" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-12 floating-label-form-group controls">
									<label>Email Address</label>
									<input type="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-12 floating-label-form-group controls">
									<label>Mot de passe</label>
									<input type="tel" class="form-control" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-12 floating-label-form-group controls">
									<label>Validation du mot de passe</label>
									<textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<br>
							<div id="success"></div>
							<div class="row">
								<div class="form-group col-xs-12">
									<button type="submit" class="btn btn-default center-block">Send</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">Panel with panel-primary class</div>
					<div class="panel-body">Panel Content</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">Panel with panel-primary class</div>
					<div class="panel-body">
						<div class="table-responsive">          
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Firstname</th>
										<th>Lastname</th>
										<th>Age</th>
										<th>City</th>
										<th>Country</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Anna</td>
										<td>Pitt</td>
										<td>35</td>
										<td>New York</td>
										<td>USA</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <hr>

    <!-- Footer -->
    <?php include '../include/footer.php'; ?>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/clean-blog.min.js"></script>

</body>

</html>
