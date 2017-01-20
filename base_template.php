<?php
	$localized_strings = array(
		'ru' => array(
			'ponirebrik' => 'Пониребрик',
			'main-page' => 'Главная',
			'about' => 'О мероприятии',
			'faq-menu' => 'FAQ',
			'faq-tooltip' => 'FAQ — часто задаваемые вопросы',
			'faq' => 'Часто задаваемые вопросы',
			'rules' => 'Правила',
			'tickets' => 'Билеты',
			'ticket1' => 'Билет «Рядовой Путаница»',
			'ticket2' => 'Билет «Лейтенант Бардак»',
			'ticket3' => 'Билет «Капитан Бедлам»',
			'ticket4' => 'Билет «Генерал Переворот»',
			'reg' => 'Регистрация',
			'stands' => 'Стенды',
			'cosplay' => 'Косплей',
			'singing-contest' => 'Вокальный конкурс',
			'press' => 'Пресса',
			'stands-reg' => 'Регистрация стендов',
			'cosplay-reg' => 'Регистрация косплееров',
			'singing-contest-reg' => 'Регистрация на вокальный конкурс',
			'press-reg' => 'Регистрация прессы',
			'footer-title' => 'Фестиваль «Пониребрик»',
			'footer-date' => '1 апреля 2017',
			'footer-rules' => 'Ознакомьтесь с правилами'
		),
		/*'en' => array(
			'ponirebrik' => 'Ponirebrik'
		),*/
		'cs' => array(
			'ponirebrik' => 'Ponirebrik',
			'main-page' => 'Domů',
			'about' => 'O události',
			'faq-menu' => 'FAQ',
			'faq-tooltip' => 'FAQ — Často kladené dotazy',
			'faq' => 'Často kladené dotazy',
			'rules' => 'Pravidla',
			'tickets' => 'Vstupenky',
			'ticket1' => 'Vstupenka "Voják Zmatek"',
			'ticket2' => 'Vstupenka "Lt. Bordel"',
			'ticket3' => 'Vstupenka "Kapitán Blázinec"',
			'ticket4' => 'Vstupenka "General Převrat"',
			'reg' => 'Registrace',
			'stands' => 'Stánky',
			'cosplay' => 'Cosplay',
			'singing-contest' => 'Vokální soutěž',
			'press' => 'Média',
			'stands-reg' => 'Registrace stánků',
			'cosplay-reg' => 'Registrace cosplayerů',
			'singing-contest-reg' => 'Registrace účastníků pěvecké soutěže',
			'press-reg' => 'Registrace zátupců médií',
			'footer-title' => 'Festival Ponirebrik',
			'footer-date' => '1.dubna 2017',
			'footer-rules' => 'Podívejte se na pravidla'
		)
	);

	$default_language = 'ru';

	session_start();

	function get_lang_code() {
		global $localized_strings;

		if (isset($_GET['lang']) && isset($localized_strings[$_GET['lang']])) {
			return $_GET['lang'];
		}

		if (isset($_COOKIE['lang_code']) && isset($localized_strings[$_COOKIE['lang_code']])) {
			return $_COOKIE['lang_code'];
		}

		$available_languages = array_keys($localized_strings);

		return prefered_language($available_languages, $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	}

	function prefered_language(array $available_languages, $http_accept_language) {
		global $default_language;
		$available_languages = array_flip($available_languages);
		$langs;
		preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
		foreach($matches as $match) {
			list($a, $b) = explode('-', $match[1]) + array('', '');
			$value = isset($match[2]) ? (float) $match[2] : 1.0;
			if(isset($available_languages[$match[1]])) {
				$langs[$match[1]] = $value;
				continue;
			}
			if(isset($available_languages[$a])) {
				$langs[$a] = $value - 0.1;
			}
		}
		if($langs) {
			arsort($langs);
			return key($langs);
		}
		return $default_language;
	}

	function get_referer() {
		if (isset($_SERVER['HTTP_REFERER'])) {
			$ref = $_SERVER['HTTP_REFERER'];
			if ( !isset( $_SESSION["origURL"] ) )
    			$_SESSION["origURL"] = $ref;
			return $ref;
		}
		return '';
	}

	function get_orig_referer() {
		if (isset($_SESSION["origURL"]))
			return $_SESSION["origURL"];
		return '';
	}

	function page($filename, $title = null, $raw_title = null, $content = null) {
		global $localized_strings;
		global $redirect_to;

		$lang_code = get_lang_code();
		setcookie('lang_code', $lang_code, time() + 60*60*24*60);

		if (!isset($title)) {
			$title = $localized_strings[$lang_code]['ponirebrik'];
			$head_title = $title;
		} else {
			$title = $localized_strings[$lang_code][$title];
			$head_title = "{$localized_strings[$lang_code]['ponirebrik']} — $title";
		}

		if (isset($raw_title)) {
			$title = $raw_title;
			$head_title = $raw_title;
		}

    	$document_name = basename($filename, '.php');
		if (!isset($content)) {
    		$content = file_get_contents("./content/$lang_code/$document_name.html");
		}

		$time = time();
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
		$ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		$referer = get_referer();
		$orig_referer = get_orig_referer();
		$log_entry = "$time -- $document_name -- $user_agent -- $ip_address -- $referer -- $orig_referer -- $lang_code\n";
		file_put_contents("./logs/site-access.txt", $log_entry, FILE_APPEND | LOCK_EX);
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
					<div>
						<a href="select-language.php?redir=<?php echo $document_name; ?>"><img class="lang-select-flag" src="./img/flag-<?php echo $lang_code; ?>.png" /> <?php echo strtoupper($lang_code); ?> <span id="lang-select-arrow">▼</span></a>
						<div class="dropdown">
							<a href="select-language.php?lang=ru&redir=<?php echo $document_name; ?>"><img class="lang-select-flag" src="./img/flag-ru.png" /> RU</a>
							<a href="select-language.php?lang=cs&redir=<?php echo $document_name; ?>"><img class="lang-select-flag" src="./img/flag-cs.png" /> CS</a>
						</div>
					</div>
				</div>
				<div>
					<div><a href="index.php"><?php echo $localized_strings[$lang_code]['main-page']; ?></a></div>
					<div>
						<a href="about.php"><?php echo $localized_strings[$lang_code]['about']; ?></a>
						<div class="dropdown">
							<a href="faq.php" title="<?php echo $localized_strings[$lang_code]['faq-tooltip']; ?>"><?php echo $localized_strings[$lang_code]['faq-menu']; ?></a>
							<a href="rules.php"><?php echo $localized_strings[$lang_code]['rules']; ?></a>
						</div>
					</div>
					<div>
						<a href="tickets.php"><?php echo $localized_strings[$lang_code]['tickets']; ?></a>
						<div class="dropdown">
							<a href="ticket1.php"><?php echo $localized_strings[$lang_code]['ticket1']; ?></a>
							<a href="ticket2.php"><?php echo $localized_strings[$lang_code]['ticket2']; ?></a>
							<a href="ticket3.php"><?php echo $localized_strings[$lang_code]['ticket3']; ?></a>
							<a href="ticket4.php"><?php echo $localized_strings[$lang_code]['ticket4']; ?></a>
						</div>
					</div>
					<div>
						<a href="reg.php"><?php echo $localized_strings[$lang_code]['reg']; ?></a>
						<div class="dropdown">
							<a href="stands-reg.php"><?php echo $localized_strings[$lang_code]['stands']; ?></a>
							<a href="cosplay-reg.php"><?php echo $localized_strings[$lang_code]['cosplay']; ?></a>
							<a href="singing-contest-reg.php"><?php echo $localized_strings[$lang_code]['singing-contest']; ?></a>
							<a href="press-reg.php"><?php echo $localized_strings[$lang_code]['press']; ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="content" class="overlapping">
			<div>
				<h1 class="section-title<?php if ($lang_code == 'cs') echo ' altfont'; ?>"><?php echo $title; ?></h1>
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
					<p><?php echo $localized_strings[$lang_code]['footer-title']; ?><br/><?php echo $localized_strings[$lang_code]['footer-date']; ?><br/><a href="rules.php"><?php echo $localized_strings[$lang_code]['footer-rules']; ?></a></p>
				</div>
				<div id="contacts">
					<a href="https://vk.com/ponirebrik">
						<img src="./img/vk_icon.png" alt="Группа ВКонтакте" />
						<span>/ponirebrik</span>
					</a>
					<br />
					<a href="mailto:mail@ponirebrik.ru">
						<img src="./img/email_icon.png" alt="Электронная почта" />
						<span>mail@ponirebrik.ru</span>
					</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	}
?>