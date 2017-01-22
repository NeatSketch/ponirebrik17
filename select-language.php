<?php
	require_once('base_template.php');

    function get_host() {
        $host = $_SERVER['HTTP_HOST'];
        if (isset($host) && ($host == "localhost" || $host == "ponirebrik.ru")) {
            return $host;
        } else {
            return "ponirebrik.ru";
        }
    }

    $redirect_to = $_GET['redir'];
    $requested_lang_code = $_GET['lang'];
    if (!isset($redirect_to) || !preg_match('/^[a-z\\-\d]+$/', $redirect_to)) {
        $redirect_to = 'index';
    }
    if (isset($requested_lang_code) && isset($localized_strings[$requested_lang_code])) {
        setcookie('lang_code', $requested_lang_code, time() + 60*60*24*60);
        $host = get_host();
        header("Location: http://$host/$redirect_to.php");
        echo "Redirecting to http://$host/$redirect_to.php";
        die();
    } else {
        $content = file_get_contents("./content/common/select-language.html");
        $content = str_replace('%%%REDIR%%%', $redirect_to, $content);
	    page(__FILE__, null, 'Select your language', $content);
    }
?>