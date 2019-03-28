<?php
	define('MYSQL_BOTH',MYSQLI_BOTH);
	define('MYSQL_NUM',MYSQLI_NUM);
	define('MYSQL_ASSOC',MYSQLI_ASSOC);

	/* General constants for app */
	define('__PATH__', dirname(__FILE__).DIRECTORY_SEPARATOR);
    define('__MAINCLASSESPATH__', __PATH__.'include'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR);
	define('__URL__', "https://www.charity-sos.com/ro".DIRECTORY_SEPARATOR);
	define('ADMIN_FOLDER_NAME', 'admin1453');
	
	define('__URL__EN__', 'https://www.charity-sos.com/');
	define('__URL__RO__', 'https://www.charity-sos.com/ro/');	
	define('__URL__FR__', 'https://www.charity-sos.com/fr/');
	
	
	define('__APPFILESPATH__', __PATH__.'app-content'.DIRECTORY_SEPARATOR); 
	define('__APPFILESURL__',  __URL__.'app-content'.DIRECTORY_SEPARATOR);
		
    define('DB_SERVER', 'localhost');
    define('DB_SERVER_USERNAME', 'root');
    define('DB_SERVER_PASSWORD', 'P@p@stratosdb1');
    define('DB_DATABASE', 'charity_ro');
	
    //define('DB_SUPPORT_SERVER', 'localhost');
    //define('DB_SUPPORT_SERVER_USERNAME', 'rbra3921_support');
    //define('DB_SUPPORT_SERVER_PASSWORD', 'support321');
    //define('DB_SUPPORT_DATABASE', 'rbra3921_support');

    define('APP_DEBUG', true);
    define('APP_ID', 'donate_charity'); /* trebuie sa fie unic si diferit pentru fiecare companie pentru care se instaleaza aplicatia */
	define('APP_NAME', 'Charity');
    define('APP_ADM_NAME', 'Charity');
	define('APP_COMPANY_NAME', 'Asociatia SOS Umanitar');	            	 	/* numele companiei care a realizat software-ul */ 
	define('APP_WEBSITE', 'https://www.charity-sos.com/ro');            	/* website aplicatie, inclusiv http:// */
	define('APP_SUPPORT_LINK', '');     								/* website aplicatie, inclusiv http:// */
	define('PATH_HELP_FOLDER', __PATH__.'help/version_1_1/');           /* folderul de unde aplicatia isi va prelua fisierele de help */	
	define('APP_EXCHANGE_URL', '#'); 									/* calea unde sunt stocate fisierele de schimb valutar */
	
	define('APP_LANG_CODE_1', 'RO');
	define('APP_LANG_CODE_2', 'EN');	
    
    define('APP_TABLES_PREFIX', 'el_');
    define('AUTH_KEY', 'nqS5/E&vjRU$EnRH3L9yQift|Q+ei9d=+j_72y.]2b,+8l+6~XJp)O|spEWU[rq}');
	//define('APP_DEBUG', true);

    define('MAILER_FROM_EMAIL', 'sosumanitar@bazar-jucarii.ro');
    define('MAILER_HOST', 'cloud406.mxserver.ro');
    define('MAILER_PORT', '465');
    define('MAILER_USERNAME', 'sosumanitar@bazar-jucarii.ro');
    define('MAILER_PASSWORD', 'visanionut321');
    define('MAILER_SITE_OWNER', 'SOS Umanitar');
	define('MAILER_NOREPLY_EMAIL', 'sosumanitar@bazar-jucarii.ro');
	
	
	define('EC_VIDEO_NO_PER_PAGE', 12);
	define('EC_AFISE_NO_PER_PAGE', 9);
	define('EC_PUBLICATII_NO_PER_PAGE', 18);
	define('EC_PHOTO_NO_PER_PAGE', 12);
	define('EC_ISTROS_NO_PER_PAGE', 9);
	define('EC_EVENTS_NO_PER_PAGE', 9);
	define('EC_ADS_NO_PER_PAGE', 9);
	define('EC_INTERES_NO_PER_PAGE', 100);	
	define('EC_BRAILA_NO_PER_PAGE', 100);	
	
		
	
?>