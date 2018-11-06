<?php
/*======================================================================*\
|| #################################################################### ||
|| # The database configurations of the ISOCMS                        # ||
|| # ISOCMS 6.0.0 By VietISO (support@vietiso.com)        			  # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
//define('LICENSE_KEY', 'TourCMS-afa4cea4e2fae983d7b3');
define('LICENSE_KEY', '6dd7fa5f2ef929f7b4a189af6c6b3edc');
date_default_timezone_set('Asia/Ho_Chi_Minh');

/** ISOCMS check https available */
function isSecure() {
  return
	(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
	|| $_SERVER['SERVER_PORT'] == 443;
}

/** ISOCMS version available */
define('CMSVER', '1');

/** ISOCMS license check from system */
define('LICENSE_CHECK', 1); // 1:handle 2: go

/** ISOCMS login to admin via clienterea */
define('ADMIN_LOGIN_CLIENTAREA', 0);

/** The name of the database for ISOCMS */
define('DB_NAME', 'avaiguide_dbis');

/** MySQL database username */
define('DB_USER', 'avaiguide_dbis');

/** MySQL database password */
define('DB_PASS', 'Co2fueg6Ch');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** The type of the database*/
define('DB_TYPE', 'mysqli');

/** The type of the database*/
define('DB_PREFIX', 'default_');

/** The type of the copyright*/
define("_copyright", 'Copyright (c) VietISO. All Rights Reserved');

/** The type of protocol*/
define('_ISOCMS_PROTOCOL', !isSecure() ? 'http://' : 'https://');

/** The type of language load*/
define('LANG_LOAD', 1);

/** The name of DOMAIN_SESSION*/
define('DOMAIN_SESSION', 'isocms.com');

/** The type of DOMAIN NAME*/
define('DOMAIN_NAME', _ISOCMS_PROTOCOL.$_SERVER['HTTP_HOST']);

/** The name of DOMAIN URL*/
define('DOMAIN_URL', _ISOCMS_PROTOCOL.$_SERVER['HTTP_HOST']);

define('_IS_AGENT', 1);
define('_ISOCMS_CLIENT_LOGIN', 1);
define('_IS_PROMOTION', 1);
define('_IS_DEPARTURE', 1);
define('ENCRYPTION_KEY', 'VietISO');
define("PAGE_NAME",'isoCMS');	//1 yes - 0 no
define("DISPLAY_ERRORS",1);	//1 yes - 0 no
define("SHOW_CHATTING",0);
define("MULTIPLE_DOMAIN",0);
define("MULTIPLE_LANG",1);	//1 yes - 0 no
define("LANG_DEFAULT",'en');

define("SEO_GLOBAL", "1");
define("GZIP_GLOBAL", "1");
define("COMPRESS_GLOBAL", "0");
define("SUBFOLDER_GLOBAL", "0");
define("UNDERCONSTRUCTION_GLOBAL", "0");
/** The email of CONTACT GLOBE*/
define("EMAIL_CONTACT_GLOBAL", "support@vietiso.com");

define("_ISOCMS_CAPTCHA", "reCAPTCHA"); //IMG & reCAPTCHA
/** Google reCPATCHA */
define("reCAPTCHA_KEY", "6LeOkUgUAAAAAMKM4WekMDIX74N-GWOFkrQhiBo1");
define("reCAPTCHA_SECRET", "6LeOkUgUAAAAAM_-hHvRylTcdScoBl8dnRDSUbfj");
define("reCAPTCHA_APIURL", "https://www.google.com/recaptcha/api/siteverify");

/** The defined of cache page */
define('CACHING', 0);
define('ADODB_CACHED', 0);
define('ADODB_CACHED_DIR', 0);
define('ADODB_CACHED_TIME', 0);
define('cache_lifetime', 20);

define("DIR_CACHE", ABSPATH.'/cache');
define("DIR_CACHE_BLOCKS", DIR_CACHE.'/blocks/');
define("DIR_CACHE_QUERY", DIR_CACHE.'/query/');
define("DIR_CACHE_DATABASE", DIR_CACHE.'/database/');

define("URL_EDITOR", DOMAIN_URL."/inc/editor");
define("URL_TINYMCE", URL_EDITOR."/tinymce");
define("URL_ELFINDER", URL_EDITOR."/elfinder");
define("_elfinder_dir", ABSPATH."/uploads");
define("_elfinder_url", DOMAIN_URL.'/uploads');
define("_isoman_use", 1);
define("_isoman_ftp", 0);
define("_isoman_dir", ABSPATH.'/uploads/');
define("_isoman_domain", DOMAIN_URL);
define("_isoman_url", "/uploads/");
define("_isoman_abs_url", "/uploads/");

define("_isoman_ftp_host_info", $_SERVER['SERVER_ADDR']);
define("_isoman_ftp_usr_info", "uploads@isocms.com");
define("_isoman_ftp_pwd_info", "e9ZiGJv0C");
define("_isoman_ftp_dir", '/uploads');
define("_isoman_ftp_url", '/uploads');

define('_ISOCMS_UPLOAD_FTP', 0);
define("ftp_host_info", $_SERVER['SERVER_ADDR']);
define("ftp_usr_info", "uploads@isocms.com");
define("ftp_pwd_info", "D7gjHZbgV");
define("ftp_abs_path_info", '/uploads');
define("ftp_abs_path_image", '/uploads');
define("ftp_temp_file_info", $_SERVER['DOCUMENT_ROOT'].'/tmp/');

define('PHIEUTHU',0);
define('PHIEUCHI',1);
define('PROMO_PERCENT', 'p');
define('PROMO_VALUE', 'v');

/** The type of defind socical */
define('appID', '378270759196549');
define('AppSecret', 'f632538e52a9fdf5455f807075356d65');
define('homeUrl', DOMAIN_NAME.'/facebook2callback');
define('fbPermissions', 'email');
//google
define('GoogleID', '519255974073-pjg28cs3vqut8uq3n2ccnm7jusn5a3rq.apps.googleusercontent.com');
define('GoogleSecret', 'Udrlz1yZ4snutjlg65Fqtnw3');
define('GoogleRedirectUrl', DOMAIN_NAME);
define('GoogleHomeUrl', DOMAIN_NAME);

define('CONSUMER_KEY', 'tHEiDIBOPQgdYGnqDx6OQ');
define('CONSUMER_SECRET', 'TaYOI0hFAxmU9yQFzkx8qE3SBcAMB660nKBXldYeiI');
define('CONSUMER_ACCESS_TOKEN', '345111079-dmTCMTWWDqpnVibnTpdkRuPe4P0CwTyWeaXW0x2H');
define('CONSUMER_ACCESS_TOKEN_SECRET', 'eciobsgwyGuvcedPZvDKNS1zjDEJoi7PJvxgW6DrhCAYo');
define('OAUTH_CALLBACK', 'https://www.iso.vietiso.com/inc/oauth/twitter.php');
define('SERVICE_ACCOUNT_EMAIL','test@vietiso.com');
define('USER_TYPE_TA','1');
define('USER_TYPE_GANNERAL','0');

define('ADULT','16');
define('CHILDREN','17');
define('INFANT','18');
define('CHOICE_ON','1');
define('CHOICE_OFF','0');
define("CREATED_INVOICE",1);
define("NOT_CREATED_INVOICE",0);
#
define("_VND_ID", 950);
define("_USD_ID", 951);
define("_EXCHANGE_RATE", 22300);

define("PAYMENT_GLOBAL",1);
define("PAYMENT_ONLINE_GLOBAL",1);
define("PAYMENT_CASH_ID",1);
define("PAYMENT_TRANSFER_ID",2);
define("PAYMENT_ONEPAY_ATM",3);
define("PAYMENT_ONEPAY_VISA",4);
define("PAYMENT_PAYPAL_GATEWAY",5);
define('CHECK', 3);

?>