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
			'footer-rules' => 'Ознакомьтесь с правилами',
			'volunteers' => 'Волонтёры',
			'volunteers-reg' => 'Регистрация волонтеров'
		),
		'en' => array(
			'ponirebrik' => 'Ponirebrik',
			'main-page' => 'Home',
			'about' => 'About',
			'faq-menu' => 'FAQ',
			'faq-tooltip' => 'Frequently Asked Questions',
			'faq' => 'Frequently Asked Questions',
			'rules' => 'Rules',
			'tickets' => 'Tickets',
			'ticket1' => 'Private Havoc\'s Ticket',
			'ticket2' => 'Lieutenant Shambles\' Ticket',
			'ticket3' => 'Captain Bedlam\'s Ticket',
			'ticket4' => 'General Meltdown\'s Ticket',
			'reg' => 'Registration',
			'stands' => 'Booths',
			'cosplay' => 'Cosplay',
			'singing-contest' => 'Singing Competition',
			'press' => 'Media',
			'stands-reg' => 'Booth registration',
			'cosplay-reg' => 'Cosplay registration',
			'singing-contest-reg' => 'Singing contest registration',
			'press-reg' => 'Media registration',
			'footer-title' => 'Ponirebrik Convention',
			'footer-date' => 'April 1, 2017',
			'footer-rules' => 'Rules of the Convention'
		),
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

	function page($filename, $title = null, $raw_title = null, $content = null, $force_lang_code = null) {
		global $localized_strings;
		global $redirect_to;

		if (isset($force_lang_code)) {
			$lang_code = $force_lang_code;
		} else {
			$lang_code = get_lang_code();
		}
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
		<link href="css/stylesheet2.css" rel="stylesheet" type="text/css" />
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
	</head>
	<body>
		<div id="background-left"></div>
        <div id="background-right"></div>
        <div id="page-content">
			<div id="lang-switch">
				<?php
					if (isset($force_lang_code)) {
						$redir_document_name = 'index';
					} else {
						$redir_document_name = $document_name;
					}
				?>
				<a href="select-language.php?redir=<?php echo $redir_document_name; ?>"><img src="./img/buttons/Pony_language_button_<?php echo $lang_code; ?>.png" alt="Select your language" /></a>
				<div>
					<?php if ($lang_code != 'ru') { ?><a href="select-language.php?lang=ru&redir=<?php echo $redir_document_name; ?>"><img src="./img/buttons/Pony_language_button_ru.png" /></a><?php } ?>
					<?php if ($lang_code != 'en') { ?><a href="select-language.php?lang=en&redir=<?php echo $redir_document_name; ?>"><img src="./img/buttons/Pony_language_button_en.png" /></a><?php } ?>
					<?php if ($lang_code != 'cs') { ?><a href="select-language.php?lang=cs&redir=<?php echo $redir_document_name; ?>"><img src="./img/buttons/Pony_language_button_cs.png" /></a><?php } ?>
				</div>
			</div>
            <a href="/"><img id="logo" src="./img/Pony_top.svg" alt="Лого" /></a>
            <div id="menu">
				<div id="menu-1">
					<a href="/"><?php echo $localized_strings[$lang_code]['main-page']; ?></a>
				</div>
				<div id="menu-2">
					<a href="about.php"><?php echo $localized_strings[$lang_code]['about']; ?></a>
					<div>
						<a href="rules.php"><?php echo $localized_strings[$lang_code]['rules']; ?></a>
						<a href="faq.php" title="<?php echo $localized_strings[$lang_code]['faq-tooltip']; ?>"><?php echo $localized_strings[$lang_code]['faq-menu']; ?></a>
					</div>
				</div>
				<div id="menu-3">
					<a href="tickets.php"><?php echo $localized_strings[$lang_code]['tickets']; ?></a>
					<div>
						<a href="ticket1.php"><?php echo $localized_strings[$lang_code]['ticket1']; ?></a>
						<a href="ticket2.php"><?php echo $localized_strings[$lang_code]['ticket2']; ?></a>
						<a href="ticket3.php"><?php echo $localized_strings[$lang_code]['ticket3']; ?></a>
						<a href="ticket4.php"><?php echo $localized_strings[$lang_code]['ticket4']; ?></a>
					</div>
				</div>
				<div id="menu-4">
					<a href="reg.php"><?php echo $localized_strings[$lang_code]['reg']; ?></a>
					<div<?php if ($lang_code == 'ru') echo " class=\"five-items\""; ?>>
						<a href="stands-reg.php"><?php echo $localized_strings[$lang_code]['stands']; ?></a>
						<a href="cosplay-reg.php"><?php echo $localized_strings[$lang_code]['cosplay']; ?></a>
						<a href="singing-contest-reg.php"><?php echo $localized_strings[$lang_code]['singing-contest']; ?></a>
						<a href="press-reg.php"><?php echo $localized_strings[$lang_code]['press']; ?></a>
						<?php
							if ($lang_code == 'ru')
								echo "<a href=\"volunteers-reg.php\">{$localized_strings[$lang_code]['volunteers']}</a>\n";
						?>
					</div>
				</div>
			</div>
			
			<!--<div>
				<div>
					<?php
						if (isset($force_lang_code)) {
							$redir_document_name = 'index';
						} else {
							$redir_document_name = $document_name;
						}
					?>
					<a href="select-language.php?redir=<?php echo $redir_document_name; ?>"><img class="lang-select-flag" src="./img/flag-<?php echo $lang_code; ?>.png" /> <?php echo strtoupper($lang_code); ?> <span id="lang-select-arrow">▼</span></a>
					<div class="dropdown">
						<a href="select-language.php?lang=ru&redir=<?php echo $redir_document_name; ?>"><img class="lang-select-flag" src="./img/flag-ru.png" /> RU</a>
						<a href="select-language.php?lang=en&redir=<?php echo $redir_document_name; ?>"><img class="lang-select-flag" src="./img/flag-en.png" /> EN</a>
						<a href="select-language.php?lang=cs&redir=<?php echo $redir_document_name; ?>"><img class="lang-select-flag" src="./img/flag-cs.png" /> CS</a>
					</div>
				</div>
			</div>-->
		
			<h1 class="section-title<?php if ($lang_code == 'cs') echo ' altfont'; ?>"><?php echo $title; ?></h1>
			<?php
				echo $content;
			?>
			<!--<div id="footer" class="parallax">
<?php
	if ($lang_code == 'en') {
?>
				<div id="footer-addition">
					<div>Website translation by <a href="http://darkcollaboration.deviantart.com/">Dark Room Collaboration</a></div>
				</div>
<?php
	}
?>
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
			</div>-->
		</div>
		<div id="timer">
			<div>
				<span>До фестиваля</span>
				<br />
				<span>осталось</span>
				<br />
				<span>ровно</span>
				<br />
				<span id="timer-value-1">XX дней</span>
				<br />
				<span id="timer-value-2">00:00:00</span>
			</div>
		</div>
		<script>
			function formatDays(days, langCode) {
				switch (langCode) {
					case 'ru':
						if ((days % 10 == 1) && (days % 100 != 11))
							return days + ' день';
						if ((days % 100 < 12) && (days % 100 > 14) && (days % 10 >= 2) && (days % 10 <= 4))
							return days + ' дня';
						return days + ' дней';
					case 'en':
						return days + ' ' + (days != 1 ? 'days' : 'day');
					case 'cs':
						if (days == 1)
							return days + ' den';
						if ((days >= 2) && (days <= 4))
							return days + ' dny';
						return days + ' dní';
				}
			}
			var targetTime = 1491039000000; // Apr 01 2017 12:30 (MSK)
			if (!Date.now) {
				Date.now = function() { return new Date().getTime(); }
			}
			document.getElementById("timer").className = "active-timer";
			var timerVal1 = document.getElementById("timer-value-1");
			var timerVal2 = document.getElementById("timer-value-2");
			var updateTimer = function () {
				var remainingTime = targetTime - Date.now();
				var time = new Date(remainingTime);
				var days = Math.ceil(remainingTime / (1000 * 60 * 60 * 24));
				timerVal1.innerText =
					formatDays(days, '<?php echo $lang_code; ?>');
				timerVal2.innerText =
					time.getUTCHours()
					+ ':' +
					("0" + time.getUTCMinutes()).substr(-2)
					+ ':' +
					("0" + time.getUTCSeconds()).substr(-2);
			}
			updateTimer();
			setInterval(updateTimer, 1000);
		</script>
	</body>
</html>
<?php
	}
?>