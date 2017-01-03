<?php
	function page($filename, $title = null) {
		if (!isset($title)) {
			$title = 'Пониребрик';
			$head_title = $title;
		} else {
			$head_title = "Пониребрик — $title";
		}
    	$document_name = basename($filename, '.php');
    	$content = file_get_contents("./content/$document_name.html");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
		<link rel="apple-touch-icon" sizes="57x57" href="/res/apple-icon-57x57.png" />
		<link rel="apple-touch-icon" sizes="60x60" href="/res/apple-icon-60x60.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="/res/apple-icon-72x72.png" />
		<link rel="apple-touch-icon" sizes="76x76" href="/res/apple-icon-76x76.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="/res/apple-icon-114x114.png" />
		<link rel="apple-touch-icon" sizes="120x120" href="/res/apple-icon-120x120.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="/res/apple-icon-144x144.png" />
		<link rel="apple-touch-icon" sizes="152x152" href="/res/apple-icon-152x152.png" />
		<link rel="apple-touch-icon" sizes="180x180" href="/res/apple-icon-180x180.png" />
		<link rel="icon" type="image/png" sizes="192x192"  href="/res/android-icon-192x192.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="/res/favicon-32x32.png" />
		<link rel="icon" type="image/png" sizes="96x96" href="/res/favicon-96x96.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="/res/favicon-16x16.png" />
		<link rel="manifest" href="/res/manifest.json" />
		<meta name="msapplication-TileColor" content="#1a3c70" />
		<meta name="msapplication-TileImage" content="/res/ms-icon-144x144.png" />
		<meta name="theme-color" content="#1a3c70" />
		<title><?php echo $head_title; ?></title>
		<!--<script type="text/javascript" src="//vk.com/js/api/openapi.js?120"></script>-->
	</head>
	<body>
		<div id="header" class="parallax">
			<!--<div id="header-main">
				<div id="header-top">
					<span id="age-rating">14+</span>
					<span id="event-date"><strong>31</strong> января</span>
				</div>
				<img id="logo" src="./img/Logo_resized_new.png" alt="Лого" />
			</div>-->
			<a href="index.php"><img id="logo-text" src="./img/Logo-text.png" alt="Лого" /></a>
			<div id="title-bar">
				<div>
					<div><a href="index.php">Главная</a></div>
					<div>
						<a href="about.php">О мероприятии</a>
						<div class="dropdown">
							<a href="faq.php" title="FAQ — часто задаваемые вопросы">FAQ</a>
							<a href="rules.php">Правила</a>
						</div>
					</div>
					<div>
						<a href="tickets.php">Билеты</a>
						<div class="dropdown">
							<a href="ticket1.php">Билет «Рядовой Путаница»</a>
							<a href="ticket2.php">Билет «Лейтенант Бардак»</a>
							<a href="ticket3.php">Билет «Капитан Бедлам»</a>
							<a href="ticket4.php">Билет «Генерал Переворот»</a>
						</div>
					</div>
					<div>
						<a href="reg.php">Регистрация</a>
						<div class="dropdown">
							<a href="stands-reg.php">Стенды</a>
							<a href="cosplay-reg.php">Косплей</a>
							<a href="singing-contest-reg.php">Вокальный конкурс</a>
							<a href="press-reg.php">Пресса</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="content" class="overlapping">
			<div>
				<div class="section-title"><?php echo $title; ?></div>
				<div class="section-content">
					<?php
                        echo $content;
                    ?>
				</div>
			</div>
		</div>
		<div id="footer" class="parallax">
			<!--<div id="footer-background">
			</div>-->
			<div>
				<div>
					<span id="age-rating">14+</span>
				</div>
				<div>
					<p>Фестиваль «Пониребрик»<br/>1 апреля 2017<br/><a href="rules.php">Ознакомьтесь с правилами</a></p>
				</div>
				<div id="contacts">
					<a href="https://vk.com/ponirebrik">
						<img src="./img/vk_icon.png" alt="Группа ВКонтакте" />
						<span>/ponirebrik</span>
					</a>
					<br />
					<a href="mailto:ponirebrik@gmail.com">
						<img src="./img/email_icon.png" alt="Электронная почта" />
						<span>ponirebrik@gmail.com</span>
					</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	}
?>