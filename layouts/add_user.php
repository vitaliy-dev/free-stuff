<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width,initial-scale=1">


  <link rel="stylesheet" href="css/bootstrap.css">
  <!-- end CSS-->

  <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>

  <div class="container">
	  <div class="row">
		  <?php require_once 'admin_head.php'; ?>
	  </div>
		  
	  <div class="row">
		  <div class="span11">
			  		  
			    <form method="post" action="/administrator.php">
				<input type="hidden" name="key" value="<?php echo $key?>"/>
				<input type="hidden" name="action" value="add_user"/>
				
				<div class="row">
					<div class="span4">
						<div class="clearfix <?php echo $error_name != '' ? "error" : '';  ?>">
							<label for="name_input">{{input_name}}</label>
							<div class="input">
							<input id="name_input" class="xlarge error" type="text" size="30" name="name_input" value="<?php echo $name_input; ?>" >
							<?php
								if ( !empty ( $error_name ) )
								{
									echo '<span class="help-inline error">'.$error_name.'</span>';
								}
							?>	
							</div>
						</div>						
					</div>
				</div>

				<div class="row">
					<div class="span4">
						<div class="clearfix <?php echo $error_password != '' ? "error" : '';  ?>">
							<label for="password1">{{input_password}}</label>
							<div class="input">
							<input id="password1" class="xlarge error" type="password" size="30" name="password1" value="" >
							<?php
								if ( !empty ( $error_password ) )
								{
									echo '<span class="help-inline error">'.$error_password.'</span>';
								}
							?>	
							</div>
						</div>						
					</div>
				</div>
				
				<div class="row">
					<div class="span4">
						<div class="clearfix <?php echo $error_password != '' ? "error" : '';  ?>">
							<label for="password2">{{retype_password}}</label>
							<div class="input">
							<input id="password2" class="xlarge error" type="password" size="30" name="password2" value="" >
							<?php
								if ( !empty ( $error_password ) )
								{
									echo '<span class="help-inline error">'.$error_password.'</span>';
								}
							?>	
							</div>
						</div>						
					</div>
				</div>				
				
				<div class="row">
					<div class="span4 offset4">
						<input class="btn primary" type="submit" name="submit" value="{{input_submit}}"></input>
					</div>
				</div>
			  </form>

		  </div>
		  <div class="span5">
			  <?php require_once 'admin_side_bar.php'; ?>
		  </div>
	  </div>
	  <div class="row">
		  <?php require_once 'admin_footer.php'; ?>
	  </div>
  </div> <!--! end of #container -->


    <script>document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script>
  <script defer src="js/script.js"></script>
  <!-- end scripts-->

  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
