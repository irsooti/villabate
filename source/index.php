<!DOCTYPE html>

<?php session_start() ?>
<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Villabate Segnala</title>
	<meta name="description" content="Villabate Segnala è un progetto che spinge la comunità a registrare le irregolarità e segnalarle, al fine di aiutare le autorità competenti a trovare una soluzione">
	<meta name="google-site-verification" content="0ZXzKfPLHZX87fPd9a3Sux-2pFEVpuqRA6_aRAtFDPU">
	<meta name="author" content="Daniele Irsuti">
	<!-- shortcut::./source/favicon.png -->
	<meta property="og:title" content="Villabate segnala">
	<meta property="og:site_name" content="Villabate segnala">
	<meta property="og:type" content="website">
	<meta property="og:url" content="http://www.villabate.online">
	<meta property="og:image" content="http://villabate.online/img/villabate.PNG">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-83876258-1', 'auto');
		ga('send', 'pageview');
    	var user = <?php if(isset($_SESSION['user'])!="" )
    		echo json_encode([['name' => $_SESSION['name'], 'id' => $_SESSION['user']]]);
    		else echo '[]' ?>
    </script>
</head>
<body>
<div class="container-fluid">

	<div class="row">

		<div id="userBar" class="btn-group">
  
			<button type="button" class="btn btn-primary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu">
				<li><a id="registrati" href="#">Registrati</a></li>
				<li><a id="loginModal" href="#">Accedi</a></li>
			</ul>
			<button type="button" class="btn btn-primary dropdown-toggle">
				<span id="userLogged">Ospite</span>
				<span> <i class="fa fa-user" aria-hidden="true"></i></span>
			</button>
		</div>

		<aside class="col-lg-9 col-lg-push-3">
		<input id="pac-input" class="controls" type="text" placeholder="Cerca la via...">
			<div class="row" id="map"></div>
			<div id="scrollDown" class="text-center">
				<a href="#"><i class="fa fa-angle-down" aria-hidden="true"></i> Segnalazioni</a>
			</div>
			<div class="clearfix"></div>
		</aside>

		<div class="first-column col-lg-3 col-lg-pull-9">

			<div id="scrollTop" class="text-center row">
				<a href="#"><i class="fa fa-angle-up" aria-hidden="true"></i> Mappa</a>
			</div>
			<header>
				<div class="row">
					<div class="col-sm-12">
						<img id="logo" alt="Villabate segnala! | Segnala le irregolarità, contribuisci a rendere pulita la tua città!" 
						src="./img/logo.png"
						srcset="./img/logo.svg">
					</div>
				</div>
			</header>
			<div class="row" style="color: #FFF; background: #d80027; padding-top: 10px">
				<div class="col-sm-12">
				<p>Segnala le irregolarità, contribuisci a rendere pulita la tua città!</p>
				</div>
			</div>
			<div class="row" style="padding-top: 2em">
				<div class="col-sm-12" id="reports"></div>
			</div>
		</div>


	</div>	
</div>
<div id="modal">
	<div class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Cosa succede qui?</h4>
	      </div>
	      <div class="modal-body">
	        <p id="maybeSuccess" class="form-group">
	        	<input type="text" id="content" class="form-control">
	        	<span id="helpBlock" class="help-block">Sii più specifico, assegna un breve titolo alla zona che stai segnalando</span>
        	</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
	        <button type="button" type="submit" id="closeModal" onclick="App.control.saveMarker(event)" class="btn btn-primary">Segnala!</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

<div id="modal-registration">
	<div class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    <div id="registration-content"></div>
	        <div class="modal-footer">
	      		<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
	        </div>
      </div><!-- /.modal-content -->
	    <!-- Cose -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="inc/request.php"></script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK1BpGwU4duuKhm0tnYqzkzFhNVDjURvg&callback=App.control.render&region=IT&libraries=places">
</script>
</body>
</html> 