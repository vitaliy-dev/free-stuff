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
				<input type="hidden" name="action" value="add_new_entry"/>
				<div class="row">
					
					<div class="span4">

						<div class="clearfix <?php echo $error_title != '' ? "error" : '';  ?>">
							<label for="title_input">${{input_title}}</label>
							<div class="input">
							<input id="title_input" class="xlarge error" type="text" size="30" name="title_input" value="<?php echo $title_input; ?>" >
							<?php
								if ( !empty ( $error_text ) )
								{
									echo '<span class="help-inline error">'.$error_title.'</span>';
								}
							?>	
							</div>
						</div>						
					</div>
				</div>

				<div class="row">
					<div class="span4">

						<div class="clearfix <?php echo $error_description != '' ? "error" : '';  ?>">
							<label for="textarea">${{input_description}}</label>
							<div class="input">
							<textarea id="textarea" class="xlarge"  rows="3" name="description"></textarea>
							<?php
								if ( !empty ( $error_text ) )
								{
									echo '<span class="help-inline error">'.$error_description.'</span>';
								}
							?>	
							</div>
						</div>						
					</div>
				</div>
				  
			  </form>

		  </div>
		  <div class="span5">
			  <div>
				  <a href="/administrator.php?">${{all_entries}}</a>
			  </div>
			  <div>
				  <a href="/administrator.php?action=add_new_entry">${{add_new_entry}}</a>
			  </div>
			  <div>
				  <a href="/administrator.php?action=add_user">${{add_user}}</a>
			  </div>
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
