<?
if (isset($_GET['id'])){$id=$_GET['id'];}
if(!preg_match("/^[\d]+$/",$id)){ exit("<p>Говноурл</p>");}
include 'database_serial.php';
$database= mysql_query("SELECT * FROM season WHERE id='$id'",$db);
$serial=mysql_fetch_array($database);

 ?>
 <!DOCTYPE html>
      <html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Расписание сериала <?php echo $serial['title']; ?>, - график выхода новых серий" />
    <title><?php echo $serial['title']." / ".$serial['original']." - расписание новых серий и даты выхода новых эпизодов"; ?></title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	</head>
<body>
<?php $flag = 2;
     include 'header.php'
	 ?>
<div class='container'>
		<article class='row' style='background:#eee;'>
			<h1 class='alert alert-success'><?php echo $serial['title']." / ".$serial['original']." - TV Сериал"; ?> </h1>
			<div class='col-lg-6 col-md-6 col-xs-12' >
			<div class='row' >
				<div class='hidden-xs col-lg-4 col-md-3 col-sm-3'><div style='position: absolute;    bottom: 0;    width: 100%;    left: 0;    text-align: center;'>
				<span class='imdbRatingPlugin'  data-title='<?php echo $serial['imdb'];?>' data-style='p2'>
						<a href='http://www.imdb.com/title/<?php echo $serial['imdb'];?>'
						><img alt='<?php echo $serial['title'];?>on IMDb' src='http://g-ecx.images-amazon.com/images/G/01/imdb/plugins/rating/images/imdb_46x22.png'>
						</a></span><script>
						(function(d,s,id){var js,stags=d.getElementsByTagName(s)[0];
						if(d.getElementById(id)){return;}js=d.createElement(s);js.id=id;
						js.src='http://g-ec2.images-amazon.com/images/G/01/imdb/plugins/rating/js/rating.min.js';
						stags.parentNode.insertBefore(js,stags);})(document,'script','imdb-rating-api');    
						</script></div><img class="img-thumbnail" src='<?php echo $serial["image"];?>' alt='<?php echo($serial['title'])." poster"; ?>' title='<?php echo($serial['title'])." poster"; ?>'/>
						</div>
						
				<div class='col-lg-8 col-md-9 col-sm-9 col-xs-12'>
				<h2>Сюжет:</h2>
					<?php echo $serial['text'];?>
				</div>
			</div>
			<div  class='trailer row text-center'>
				<?php echo $serial['trailer']; ?>
			</div>
			</div>
			<div id="release" class='col-lg-6 col-md-6 col-xs-12' >
				<h2>Расписание серий:</h2><p>Ниже представлен посезонный список серий ну и само-собой даты выхода новых эпизодов замечательного сериала <?php echo $serial['title'];?> =) И конечно не забудьте рассказать друзьям.</p>
				<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
				<div class='row'>
					<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="very_big" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yashareTheme="counter"></div><br>
				</div>
						<?php	
						$id=$serial['id'];
						$database= mysql_query("SELECT *, DATE_FORMAT(`date`, '%d.%m.%Y') AS date FROM seria WHERE id_season='$id' ORDER BY id DESC",$db);
						echo mysql_error();
						
						//$seria= mysql_fetch_array($database);
						$fl=0;
						$flag=1;
						while($seria=mysql_fetch_array($database))
						{
                                                    if($seria[date]=='01.01.2099'){
                                                        $date="Скоро";
                                                    }else{
                                                        $date=$seria['date'];
                                                    }
								if($fl!=1){ //Проверка на закрытия тегов 
									echo("<div  class='row alert alert-info'><h4  style='cursor: pointer;'>Сезон ".$seria['number_seas']."</h4><ul class='list-group'>");
									$flag=$seria['number_seas'];
									echo ("<li class='list-group-item'><div class='row'>
									<div class='col-lg-2 col-md-2 col-sm-2 col-xs-6'>".$seria[number_seria]."</div><div class='col-lg-6 col-md-6 col-sm-6 hidden-xs' ><strong>".$seria[title]."</strong></div><div class='col-lg-4 col-md-4 col-sm-4 col-xs-6 text-right' >".$date."</div></div></li>");
									$fl=1;
								}
								else{
									if($flag==$seria['number_seas']){ //серии того же сезона
										echo ("<li class='list-group-item'><div class='row'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-6' >".$seria[number_seria]."</div><div class='col-lg-6 col-md-6 col-sm-6 hidden-xs' ><strong>".$seria[title]."</strong></div><div class='col-lg-4 col-md-4 col-sm-4 col-xs-6 text-right'  >".$date."</div></div></li>");
									}
									else{
										echo("</ul></div><div class='row alert alert-info'><h4 style='cursor: pointer;'>Сезон ".$seria['number_seas']."</h4><ul class='list-group'>");
										$flag=$seria['number_seas'];
										echo ("<li class='list-group-item'><div class='row'><div class='col-lg-2 col-md-2 col-sm-2 col-xs-6' >".$seria[number_seria]."</div><div class='col-lg-6 col-md-6 col-sm-6 hidden-xs' ><strong>".$seria[title]."</strong></div><div class='col-lg-4 col-md-4 col-sm-4 col-xs-6 text-right' >".$date."</div></div></li>");
									}
								}
						}
						echo("</ul></div></div>"); ?>
						</article>
						<footer class='row'>
						<?php include'block/footer.php';?>

						</footer>	
			</div>
			
	

</body>
<?php include 'block/javascripts.php';?>
           
<script type="text/javascript">
$(document).ready(function(){
$('#release .row > ul').hide();
$('#release .row ul:first').show();
$('#release .row h4').click(function(){
$(this).next().toggle('slow');
});
  });

  </script>	
  			<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
			<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
</html>