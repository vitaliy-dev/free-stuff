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
		  <?php require_once 'front_head.php'; ?>
	  </div>
	  <div class="row">
		  <div class="span14">
					<div class="row">
						<div class="span14 border">
							<div class="row">
								<div class="span4">
									<a href="/img/<?php echo $entry['image']?>" target="_blank"><img class="thumbnail imgsmall" src="/img/<?php echo $entry['image'] ?>"></a>
								</div>
								<div class="span10">
									<div>
										<h2>
											<a href="/<?php echo urlencode(str_replace(" ", '-', $entry['title'] ))?>" ><?php echo htmlspecialchars( $entry['title'] );?></a>
										</h2> 
									</div>
									<div>
										<?php echo $entry['updated']; ?>
									</div>
									<div>
										<?php echo $entry['tags']; ?>
									</div>
								</div>
							</div>
						
							<div class="row">
								<div class="span14">
									<?php echo htmlspecialchars( $entry['description'] );?>
								</div>
							</div>
							<div class="row">
								<div class="span14">
									<a target="_blank" href="<?php echo prep_url( str_replace(" ", '-', $entry['url'] ) ) ?>" ><?php echo htmlspecialchars(prep_url( $entry['url'] ) );?></a>
								</div>
							</div>
						</div>
						<!-- comments block -->
						<?php
							if ( ! empty ( $comments ) )
							{
								foreach ( $comments as $comment )
								{
									?>
									<div class="span14 border">
									<div class="row">
										<div class="span14">
											<?php echo $comment['name']; ?>
										</div>
										<div class="span14">
											<?php echo $comment['email']; ?>
										</div>
										<div class="span14">
											<?php echo $comment['updated']; ?>
										</div>
										<div class="span14">
											<?php echo $comment['text']; ?>
										</div>
									</div>
								</div>
								<?php	
								}
							}
						?>	
					</div>
			  		<form method="post" action="/index.php">
				<input type="hidden" name="key" value="<?php echo $key?>"/>
				<input type="hidden" name="action" value="add_comment"/>
				<input type="hidden" name="id" value=" <?php echo $entry['id'];?>"/>
				
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
						<div class="clearfix <?php echo $error_email != '' ? "error" : '';  ?>">
							<label for="email_input">{{input_email}}</label>
							<div class="input">
							<input id="email_input" class="xlarge error" type="text" size="30" name="email_input" value="<?php echo $email_input; ?>" >
							<?php
								if ( !empty ( $error_email ) )
								{
									echo '<span class="help-inline error">'.$error_email.'</span>';
								}
							?>	
							</div>
						</div>						
					</div>
				</div>

				<div class="row">
					<div class="span4">

						<div class="clearfix <?php echo $error_comment != '' ? "error" : '';  ?>">
							<label for="textarea">{{input_comment}}</label>
							<div class="input">
							<textarea id="textarea" class="xlarge"  rows="3" name="email"><?php echo $text_comment; ?></textarea>
							<?php
								if ( !empty ( $error_comment ) )
								{
									echo '<span class="help-inline error">'.$error_comment.'</span>';
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

		  <div class="span2">
				<?php require_once 'front_side_bar.php'; ?>
		  </div>
	  </div>
	  <div class="row">
		  <?php require_once 'front_footer.php'; ?>
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
