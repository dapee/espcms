<?php

$default_str = "<?php
error_reporting(0);
set_magic_quotes_runtime(0);
ini_set('magic_quotes_runtime', 0);
ini_set('memory_limit', '640M');
ini_set('default_charset', 'utf-8');
define('adminfile', '" . adminfile . "');
define('admin_ClassURL', 'http://' . \$_SERVER['HTTP_HOST'] . substr(\$_SERVER['PHP_SELF'], 0, strrpos(\$_SERVER['PHP_SELF'], '/')) . '/');
define('admin_htmlDIR', '" . $dirhtmlDir . "');
define('admin_URL', str_replace(admin_htmlDIR, '', admin_ClassURL));
define('admin_ROOT','" . admin_ROOT . "/');
define('admin_FROM', true);
define('admin_http', \$_SERVER['HTTP_HOST']);
if (!@include admin_ROOT . 'datacache/public.php') {
	exit('<b>Access denied!</b>');
}
\$archive = indexget('ac', 'R');
\$action = indexget('at', 'R');

require admin_ROOT . 'public/class_connector.php';
if (!@include admin_ROOT . 'datacache/command.php') {
	exit('System file don\'t exist, please create!<br>Filename : datacache/command.php<br><a href=\"' . admin_URL . adminfile . '\">Click to create!</a>');
}
if (\$CONFIG['is_close']) {
	header('Content-type: text/html; charset=utf-8');
	exit(\$CONFIG['close_content']);
}

include admin_ROOT . 'public/uc_config.php';
define('admin_LNG', '" . $lng . "');
\$lngpack = (admin_LNG == 'big5') ? \$CONFIG['is_lancode'] : admin_LNG;
define('admin_LNGDIR', \$lngpack . '/');
define('admin_AGENT',\$_SERVER['HTTP_USER_AGENT']);
\$rootDIR = \$CONFIG['http_pathtype'] ? admin_URL : str_replace('http://' . admin_http, '', admin_URL);
define('admin_rootDIR', \$rootDIR);

	
if (empty(\$archive) || empty(\$action)) {
	include admin_ROOT . 'interface/public.php';
	\$mainlist = new mainpage();
	if (method_exists(\$mainlist, 'in_index')) {
		\$mainlist->in_index();
	} else {
		exit('Access error!');
	}
} else {
	if (in_array(\$archive, array('article', 'forum', 'search', 'bbssearch', 'forummain', 'messmain', 'special', 'respond', 'public', 'scriptout', 'enquiry', 'enquirymain', 'form', 'formmain', 'ordermain', 'membermain', 'member', 'forum', 'order'))) {
		\$action = 'in_' . \$action;
		if (!file_exists(admin_ROOT . \"interface/\$archive.php\")) {
			exit('Access error!');
		}
		include admin_ROOT . \"interface/\$archive.php\";
		\$mainlist = new mainpage();
		if (method_exists(\$mainlist, \$action)) {
			\$mainlist->\$action();
		} else {
			exit('Access error!');
		}
	} else {
		exit('Access error!');
	}
}
function indexget(\$k, \$var='R', \$htmlcode=true, \$rehtml=false) {
	switch (\$var) {
		case 'G':
			\$var = &\$_GET;
			break;
		case 'P':
			\$var = &\$_POST;
			break;
		case 'C':
			\$var = &\$_COOKIE;
			break;
		case 'R':
			\$var = &\$_GET;
			if (empty(\$var[\$k])) {
				\$var = &\$_POST;
			}
			break;
	}
	\$putvalue = isset(\$var[\$k]) ? indexdaddslashes(\$var[\$k], 0) : NULL;
	return \$htmlcode ? indexhtmldecode(\$putvalue) : \$putvalue;
}

function indexdaddslashes(\$string, \$force=0, \$strip=FALSE) {
	if (!get_magic_quotes_gpc() || \$force == 1) {
		if (is_array(\$string)) {
			foreach (\$string as \$key => \$val) {
				\$string[\$key] = addslashes(\$strip ? stripslashes(\$val) : \$val);
			}
		} else {
			\$string = addslashes(\$strip ? stripslashes(\$string) : \$string);
		}
	}
	return \$string;
}

function indexhtmldecode(\$str) {
	if (empty(\$str)) return \$str;
	if (!is_array(\$str)) {
		\$str = htmlspecialchars(trim(\$str));
		\$str = str_ireplace('Xss', '', \$str);
	} else {
		foreach (\$str as \$key => \$val) {
			\$str[\$key] = htmlspecialchars(\$val);
			\$str[\$key] = indexhtmldecode(\$val);
		}
	}
	return \$str;
}
?>";
?>
