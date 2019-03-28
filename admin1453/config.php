<?php	
	/* PATH and URL constants */
	define('__ADMINURL__',             __URL__.ADMIN_FOLDER_NAME.DIRECTORY_SEPARATOR);
	
	define('__APPURL__',               __URL__); 
	define('__UTILSAPP__',             __ADMINURL__.'app'.DIRECTORY_SEPARATOR);	
	define('__ADMINPATH__',            __PATH__.ADMIN_FOLDER_NAME.DIRECTORY_SEPARATOR);
	define('__ADMINAPPPATH__',         __ADMINPATH__.'app'.DIRECTORY_SEPARATOR);
	
	define('__THEME_FOLDER_NAME__',    'metronic_v4.7.5');
	
	define('__THEMEPATH__',            __ADMINPATH__.'content'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.__THEME_FOLDER_NAME__.DIRECTORY_SEPARATOR.'admin_1'.DIRECTORY_SEPARATOR); 
	define('__THEMEURL__',             __ADMINURL__.'content'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.__THEME_FOLDER_NAME__.DIRECTORY_SEPARATOR);
	
	define('__CLASSESPATH__',          __ADMINPATH__.'include'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR);
	define('__ACTIONURL__',            __ADMINURL__.'action'.DIRECTORY_SEPARATOR);
	define('__THUMBURL__',             __ADMINURL__.'app'.DIRECTORY_SEPARATOR.'tt'.DIRECTORY_SEPARATOR);
	
	define('__CALENDARPATH__',         __ADMINPATH__.'app'.DIRECTORY_SEPARATOR.'fullcalendar-3.5.1'.DIRECTORY_SEPARATOR);
	define('__CALENDARURL__',          __ADMINURL__.'app'.DIRECTORY_SEPARATOR.'fullcalendar-3.5.1'.DIRECTORY_SEPARATOR);
	
	
	define('__UPLOADPATH__',           __PATH__.'uploads'.DIRECTORY_SEPARATOR);
	define('__UPLOADURL__',            __URL__.'uploads'.DIRECTORY_SEPARATOR);
	
	define('__UPLOADPATH__ELFINDER__', __PATH__.'uploads'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR);
	define('__UPLOADURL__ELFINDER__',  __UPLOADURL__.'img'.DIRECTORY_SEPARATOR);
	define('__APPRESOURCESURL__',  	   __URL__.'resources'.DIRECTORY_SEPARATOR);

	/* App uploads parameters */
	define('LINK_TO_HELP_BACKEND', __ADMINURL__.'resources'.DIRECTORY_SEPARATOR.'help'.DIRECTORY_SEPARATOR); 	/* link to admin help folder */
	define('MAX_UPLOAD_FILE_SIZE', 100); 				/* Max file size for upload, in MB */
	
	
	/* App message type constants */
	define('MSG_SUCCESS',   0); 
	define('MSG_INFO',      1); 
	define('MSG_DANGER',    2); 
	define('MSG_WARNING',   3); 	

	/* App input type constants */
	define('FIELD_TYPE_TITLE',                     		1);    /* Display a title */
	define('FIELD_TYPE_LINE_SEPARATOR',            		2);    /* Display a horizontal line */
	define('FIELD_TYPE_INFO',                      		3);    /* Display a message */
	define('FIELD_TYPE_CUSTOM_CONTENT',            		4);    /* Display a title */

	define('FIELD_TYPE_TEXT',                     		20);
	define('FIELD_TYPE_HIDDEN',                    		21);
	define('FIELD_TYPE_COLOR_PICKER',              		25);
	define('FIELD_TYPE_TEXTAREA',                 		30);
	define('FIELD_TYPE_CHECKBOX',                 		40);
	define('FIELD_TYPE_DATE',                 	  		50);
	define('FIELD_TYPE_DATE_RANGE',               		60);
	define('FIELD_TYPE_DATETIME',              	  		70);

	define('FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM',  		100);   /* Combobox, bootstrap style, custom option */
	define('FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS', 		110);   /* Combobox, custom option with icons */	

	define('FIELD_TYPE_COMBO_BOOTSTRAP_TABLE',   		120);   /* Combobox, bootstrap style - get data from table */
	define('FIELD_TYPE_COMBO_WITH_SEARCH',       		130);   /* Combobox, will load data from table and can search items in combo */	

	define('FIELD_TYPE_COMBO_MULTISELECT',       		140);   /* Combobox, can select multiple value */	
	define('FIELD_TYPE_COMBO_SWITCH',       	 		150);   /* Combobox, displays one or more fields depending on the value of combo */	
	define('FIELD_TYPE_COMBO_INTERACTIVE',    	 		160);   /* group of Combobox, interactiv loading content */
	
	define('FIELD_TYPE_EDITOR_CKEDITOR',    	 		170);   /* ckeditor -  WYSIWYG text editor */
	define('FIELD_TYPE_SELECT_FILE',    	 	 		180);   /* SELECT FILE input */
	define('FIELD_TYPE_SELECT_IMAGE',    	 	 		190);   /* SELECT IMAGE input */
	define('FIELD_TYPE_TAGS_INPUT',    	 	 	 		200);   /* Input TAGS */
	define('FIELD_TYPE_PASSWORD',    	 	 	 		210);   /* 2 Inputs for edit password */
	define('FIELD_TYPE_MENU',    	 	 	 	        220);   /* Nested list menu */
	define('FIELD_TYPE_ITINERARY',    	 	 	        225);   /* Itinerary control */
	define('FIELD_TYPE_CABINS_PRICE',  	 	 	        226);   /* Cabins price control */
	
	
	define('FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE',  230);   /* 2 boxex for multiselect */
	define('FIELD_TYPE_LOADING_BUTTON',   	 	        240);   /* loading button */
	
	
	
	/* Archive list filter constants */
	define('LFT_NOFILTER',                     	  		10);    /* list Column without filter */
	define('LFT_LIKE_FILTER',                 	  		20);    /* one input box */
	define('LFT_DATE_INTERVAL',               	  		30);    /* 2 input box */
	define('LFT_VALUE_INTERVAL',               	  		40);    /* 2 input box */
	define('LFT_COMBO_CUSTOM',               	  		50);    /* custom combo box */
	define('LFT_COMBO_FROM_TABLE',            	  		60);    /* combo box with value from table */
	define('LFT_COMBO_INTERACTIVE',            	  		70);    /* multiple intercative combo box */
	
	/* Archive list field type constants */
	define('FIELD_VALUE',               	  	  		10);    /* value of field */
	define('FIELD_DATE',               	  	  	  		20);    /* field date type */
	define('FIELD_DATETIME',            	  	  		25);    /* field datetime type */
	define('FIELD_EMAIL',              	  	  	  		30);    /* field email type */
	define('FIELD_PHONE',              	  	  	  		40);    /* field phone type */
	define('FIELD_FUNCTION',           	  	  	  		50);    /* field function type */
	define('FIELD_LINK',           	  	  	  	  		60);    /* field link type */
	
	/* other constants */
	define('AJAX_TIME_SET_ONLINE_USER_STATUS',    		15000);  /* time (in miliseconds) after that ajax routine will set online status for curent user */
	define('AJAX_TIME_GET_USERS_STATUS_LIST',     		20000);  /* time (in miliseconds) after that ajax routine will get list of users with their online status */
	define('TRACK_USERS_ACTIVITY',    			  		1);      /* if not 0 app will track users activity */
	define('NO_CASES_TO_SYNCHRONIZE_IN_ONE_CRON_FLOW',  15);     /* no of cases to synchronize in one cronjob flow */
	

?>