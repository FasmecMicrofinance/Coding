<?php 
    session_start();
	include_once '_config_inc.php';
	include_once BASE_PATH.'_libs/site_class.php';
	$db = new gen_class($configs);
	
	include_once BASE_PATH.'_libs/counter.php';
	$counter = new CT_COUNTER($db->getConnection());
	$counter->run();
	
	$main_page = 'home';
	if(isset($_GET['p']) && $_GET['p']!=''){
		$main_page = $db->filter($_GET['p']);
	}
	
	$main_id = '';
	if(isset($_GET['id']) && $_GET['id']!=''){
		$main_id = $db->filter($_GET['id']);
	}
    
    $lang = 'en';
	if(isset($_GET['lang']) && $_GET['lang']!=''){
		$lang = $db->filter($_GET['lang']);
	}
    $BASE_URL = BASE_URL;
    
    //$db->getTitles($lang);
	// INITIAL BUFFER STORE
	$_mainContent='';
	// INITIAL META VALUE
    $_metaTags = array();	
	// GET BUFFER OUTPUT
	$filePath = 'views/'.$main_page.'.php';
	if(file_exists($filePath))
	{
        ob_start();
		include $filePath;
        $_mainContent = ob_get_contents();
        ob_end_clean();
	}
?>
<!DOCTYPE html>
<html>
<head >
	<meta charset="UTF-8"/>

	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> -->
	<?php $_SITE_INFO = $db->getOne("tbl_site_description"); ?>
	<title><?php if(!empty($_metaTags['title'])){ echo $_metaTags['title'];}else{ echo  ucfirst($_SITE_INFO['title']); }; echo ' - '.$_SITE_INFO['site_name']; ?></title>
    <meta name="keywords" content="<?php echo $_SITE_INFO['key_word']; ?>">
    <meta name="description" content="<?php echo $_SITE_INFO['description']; ?>"><?php 
		if(empty($_metaTags['image'])){
			$_metaTags['image'] = BASE_URL . 'files/site_description/'.$_SITE_INFO['image'];
		}
        $_metaTags['site_name']= $_SITE_INFO['site_name'];
        $_metaTags['url']= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        echo $db->site_meta($_metaTags);		
		//unset($_SITE_INFO);
		$_SESSION['received_mail'] = $_SITE_INFO['received_mail'];
    ?>
		
	<link rel="shortcut icon" href="<?php echo BASE_URL; ?>images/logoHeader.png"/>

	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/animate.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/jquery.fancybox.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/camera.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/template.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/style-date.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/jquery-ui-date.css"/>
	

	<?php
		if($lang == 'kh') {
			echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.'css/kh_css.css"/>';
		}
		if($lang == 'jp') {
			echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.'css/jp_css.css"/>';
		}
	?>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>js/bootstrap.min.js"></script>    
    <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.fancybox.js"></script> 
    <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.mobile.customized.min.js"></script> 
    <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.easing.1.3.js"></script> 
    <script type="text/javascript" src="<?php echo BASE_URL; ?>js/camera.min.js"></script> 
    <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-ui-date.js"></script> 

    <style>
		table {
		    border-collapse: collapse;
		    width: 100%;
		}

		th, td {
		    text-align: left;
		    padding: 8px;
		}

		tr:nth-child(even){background-color: #f5faf6}

		th {
		    background-color: #005aa9;
		    color: white;
		}
		p    {
			padding: 5px;

		}
	</style>
    
</head>

<body style="position:relative;background-color: rgb(245, 250, 246)";>
	<header  style="position:relative;">			
		<?php include BASE_PATH.'views/header.php'; ?>				
		<?php include BASE_PATH.'views/main_menu.php'; ?>				
	</header>
	
	<?php if($main_page=='home') include BASE_PATH.'views/slide_show.php'; ?>

	<?php
	if($main_id == ''){
	?>

	<?php
	}	
	?>

	<section>
		<?php echo $_mainContent; ?>
	</section>
	
	<div style="clear:both;"></div>	 
	
	<footer>
		<?php include BASE_PATH.'views/footer.php'; ?>
	</footer>

	<script>
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip();
		});
	</script>

	<script>
	    $(function(){
			$(".dropdown").hover(            
				function() {
					$('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
					$(this).toggleClass('open');
					$('b', this).toggleClass("caret caret-up");                
				},
				function() {
					$('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
					$(this).toggleClass('open');
					$('b', this).toggleClass("caret caret-up");                
				});
		});
	</script>

	<script>
		var carouselContainer = $('.carousel');
		var slideInterval = 5000;
			
		carouselContainer.carousel({
			interval: slideInterval, cycle: true, pause: "hover"}
		)
		.on('slide.bs.carousel slid.bs.carousel',
			function(){
				$('.toggleHeading').hide();
				var title_animate = $('.carousel').find('.item.active').find('.toggleHeading').attr('animate');


				var caption = carouselContainer.find('.active').find('.toggleHeading').addClass('animated '+ title_animate +'').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
				function (){
					$(this).removeClass('animated '+ title_animate +'')
				});
				caption.slideToggle();
			}).trigger('slide.bs.carousel')
		.on('slide.bs.carousel slid.bs.carousel', 
			function toggleC(){
				$('.toggleCaption').hide();					
				var detail_animate = $('.carousel').find('.item.active').find('.toggleCaption').attr('animate');
				var caption = carouselContainer.find('.active').find('.toggleCaption').addClass('animated '+ detail_animate +'').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
				function (){
					$(this).removeClass('animated '+ detail_animate +'')
				});
				caption.slideToggle();
			}).trigger('slide.bs.carousel');	 
	</script>

	<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();
		});
	</script>	

	<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
	        document.getElementById("myBtn").style.display = "block";
	    } else {
	        document.getElementById("myBtn").style.display = "none";
	    }
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
	    document.body.scrollTop = 0;
	    document.documentElement.scrollTop = 0;
	}
	</script>

</body>
</html>