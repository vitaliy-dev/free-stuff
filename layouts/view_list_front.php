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
			  <?php 
				foreach ($results as $entry)
				{
					?>
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
					</div>
					<?php
				}
			  ?>
			<div class="row">
					<div class="span14">
							<?php
								if ( $pagination != 0 )
								{
									?>
								    <div class="pagination">
										<ul>							
									<?php
										
									if ($offsset_pagination != 0)
									{
										echo '<li class="prev "><a href="/?start_offset='.($offsset_pagination - 1).'">&larr; {{previous}}</a></li>';		
									}
											

									
										for ( $i = 0; $i <= $pagination; $i++)
										{
											if ($i == $offsset_pagination)
											{
												echo '<li class="active"><a href="/?start_offset='.$i.'">'.$i.'</a></li>';
											}
											else
											{
												echo '<li class=""><a href="/?start_offset='.$i.'">'.$i.'</a></li>';
											}
										
										}
									
									if ($offsset_pagination != $pagination)
									{
										echo '<li class="next"><a href="/?start_offset='.($offsset_pagination + 1).'">{{next}} &rarr;</a></li>';
									}
									
									?>
										</ul>
									</div>											
									<?php
									
								}
							?>

						
					</div>
			</div>
			 
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
