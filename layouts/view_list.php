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
			<table class="bordered-table zebra-striped">
				<thead>
				  <tr>
					<th>#</th>
					<th>{{title}}</th>
					<th>{{updated}}</th>
					<th>{{remove}}</th>
					<th>{{edit}}</th>
				  </tr>
				</thead>
				<tbody>
				  <?php 
					if ( ! empty ( $results ) )
					{
						foreach ($results as $value) 
						{
						?>
							<tr>
								<td><?php echo $value['id']; ?></td>
								<td><?php echo $value['title'];?></td>
								<td><?php echo $value['updated'];?> </td>
								<td><a href="/administrator.php?action=remove_entry&id=<?php echo $value['id']; ?>">{{remove}}</a></td>
								<td><a href="/administrator.php?action=edit_entry&id=<?php echo $value['id']; ?>">{{edit}}</a></td>
							</tr>
						<?php
						}
					}
					?>
				</tbody>
			</table>
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
