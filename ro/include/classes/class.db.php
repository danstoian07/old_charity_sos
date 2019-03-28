<?php
Class db
{
	/* ------------------------------------------------------------------------------------- */
	public 	  $show_errors   = false;										/* Whether to show SQL/DB errors. */
	public    $insert_id     = 0;											/* The ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).*/
	public    $num_rows      = 0;											/* Count of rows returned by previous query */
	public    $rows_affected = 0;											/* Count of affected rows by previous query */
	public    $base_prefix   = APP_TABLES_PREFIX;							/* Aplication base table prefix	*/
	var       $tables        = array( 
				'users', 
				'users_track', 
				'app_settings',			
				'articles',
				'tabs',
				'galerii',
				'menus',
				'afise',
				'files',
				'gallery',				
				'multiselect_options',
				'zone');													/* List of Application tables */
	public    $dbuser;														/* Database username */
	protected $dbpassword;													/* Database password */
	protected $dbname;														/* Database name */
	protected $dbhost;														/* Database Host */
	public 	  $dbh;															/* Database Handle */
	private   $use_mysqli    = false;										/* Whether to use mysqli over mysql. */
	private   $has_connected = false;										/* Whether we've managed to successfully connect at some point */
	public 	  $charset;														/* Database table columns charset */
	public 	  $collate;														/* Database table columns collate */

	/* ------------------------------------------------------------------------------------- */
	/* class constructor */
	public function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {
		register_shutdown_function( array( $this, '__destruct' ) );
		
		if ( APP_DEBUG )
			$this->show_errors;
		
		/* APP_USE_MYSQLI constant is actually never defined in core code at all. You can define it yourself in app-config.php */
		if ( function_exists( 'mysqli_connect' ) ) {
			if ( defined( 'APP_USE_MYSQLI' ) ) {
				$this->use_mysqli = ! APP_USE_MYSQLI;
			} elseif ( version_compare( phpversion(), '5.0', '>=' ) || ! function_exists( 'mysql_connect' ) ) {
				$this->use_mysqli = true;				
			} 
		}

		$this->dbuser 	  = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname     = $dbname;
		$this->dbhost     = $dbhost;

		$this->init_charset();

		$this->db_connect();		
		if ($this->has_connected) {
			$this->set_tables_prefix();
		}		
	}
	/* ------------------------------------------------------------------------------------- */	
	/* class destructor: will run when database object is destroyed. */
	public function __destruct() {
			return true;
	}
	/* ------------------------------------------------------------------------------------- */		
	/* * Connect to and select database. */
	public function db_connect() { 		
		if (!$this->has_connected) {
			if ($this->use_mysqli) {
				$link = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname);
				if (!$link) {
					$this->show_error('DB Error no: '.mysqli_connect_errno().'| DB Error: '.mysqli_connect_error());
				} else {				
					$this->dbh = $link;
					$this->set_charset( $this->dbh );
					$this->has_connected = true;				
				}			
			} else {
				$link = mysql_connect($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname);
				if (!$link) {
					$this->show_error(mysql_error());
				} else {
					$this->dbh = $link;
					$this->set_charset( $this->dbh );
					$this->has_connected = true;				
				}
			}
		}
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function db_disconnect() {
		if ($this->use_mysqli) {
			return mysqli_close($this->dbh);
		} else {
			return mysql_close($this->dbh);
		}
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function db_query($query){
		if ($this->use_mysqli) {
      		$result = mysqli_query($this->dbh, $query) or $this->show_error($query.' | DB Error no: '.mysqli_errno($this->dbh).' | DB Error: '.mysqli_error($this->dbh));
      		$this->insert_id = $this->db_last_inserted_id();
      		if (is_object($result)) $this->num_rows  = $this->db_num_rows($result);
      		return $result;
		} else {
			$result = mysqli_query($this->dbh, $query) or $this->show_error($query.' | DB Error no: '.mysql_errno($this->dbh).' | DB Error: '.mysql_error($this->dbh));
			$this->insert_id = $this->db_last_inserted_id();
			if (is_object($result)) $this->num_rows  = $this->db_num_rows($result);
      		return $result;
		}
	}	
	/* ------------------------------------------------------------------------------------- */
	public function db_multiquery($query){
		$this->insert_id = 0;
		$this->num_rows  = 0;		
		if ($this->use_mysqli) {
      		$result = mysqli_multi_query($this->dbh, $query) or $this->show_error($query.' | DB Error no: '.mysqli_errno($this->dbh).' | DB Error: '.mysqli_error($this->dbh));      		
		} else {
			$result = mysqli_query($this->dbh, $query) or $this->show_error($query.' | DB Error no: '.mysql_errno($this->dbh).' | DB Error: '.mysql_error($this->dbh));
		}
		return $result;
	}		
	/* ------------------------------------------------------------------------------------- */
	public function table_records_number($table_name, $where){
		$eval_str = "\$table_name = \$this->$table_name;";
		eval($eval_str);		
		$rec_no = 0;
		$query = "SELECT count(*) AS no FROM $table_name WHERE $where";
		$result  = $this->db_query($query);		
		if ($result_line = $this->db_fetch_array($result)) {
			$rec_no = $result_line['no'];
		}
		return $rec_no;
	}
	/* ------------------------------------------------------------------------------------- */
	/* to be used after execution of db_multiquery method */
	public function db_next_result() {
		if ($this->use_mysqli) {
			while (mysqli_more_results($this->dbh)) {
				mysqli_next_result($this->dbh);
			}
		} else {
			/*
			*/			
		}
	}
	/* ------------------------------------------------------------------------------------- */      	
	function db_free_result($result) {
		if ($this->use_mysqli) {
			mysqli_free_result($result);    
		} else {
			mysql_free_result($result);    
		}
	}    	
	/* ------------------------------------------------------------------------------------- */
	public function db_last_inserted_id(){
		if ($this->use_mysqli) {
			return mysqli_insert_id ( $this->dbh ); } else { return mysql_insert_id ( $this->dbh ); }
	}
	/* ------------------------------------------------------------------------------------- */
	public function db_num_rows($result){
		if ($this->use_mysqli) {
			return mysqli_num_rows($result); } else { return mysql_num_rows($result); }
	}
	/* ------------------------------------------------------------------------------------- */
	public function db_affected_rows($result){
		if ($this->use_mysqli) {
			return mysqli_affected_rows($this->dbh); } else { return mysql_affected_rows($result); }
	}	
	/* ------------------------------------------------------------------------------------- */
	public function db_fetch_array($result){
		if ($this->use_mysqli) {
			return mysqli_fetch_array($result, MYSQL_ASSOC); } else { return mysql_fetch_array($result, MYSQL_ASSOC); }
	}
	/* ------------------------------------------------------------------------------------- */
	public function db_data_seek($result, $row_number){
		if ($this->use_mysqli) {
			return mysqli_data_seek($result, $row_number); } else { return mysql_data_seek($result, $row_number); }
	}	
	/* ------------------------------------------------------------------------------------- */
	public function init_charset() {
		if ( defined( 'DB_CHARSET' ) ) {
			$this->charset = DB_CHARSET;
		} else {
			$this->charset = 'utf8';
		}		
		if ( defined( 'DB_COLLATE' ) && DB_COLLATE ) {
			$this->collate = DB_COLLATE;
		} else {
			$this->collate = 'utf8_general_ci';
		}
	}
	/* ------------------------------------------------------------------------------------- */	
	public function set_charset( $dbh, $charset = null, $collate = null ) {
		if ( ! isset( $charset ) )
			$charset = $this->charset;
		if ( ! isset( $collate ) )
			$collate = $this->collate;
		if ( $this->has_cap( 'collation' ) && ! empty( $charset ) ) {
			if ( $this->use_mysqli ) {
				if ( function_exists( 'mysqli_set_charset' ) && $this->has_cap( 'set_charset' ) ) {
					mysqli_set_charset( $dbh, $charset );
				} else {
					
					$query = $this->prepare( 'SET NAMES %s', $charset );
					if ( ! empty( $collate ) )
						$query .= $this->prepare( ' COLLATE %s', $collate );
					mysqli_query( $dbh, $query );
					
				}
			} else {
				if ( function_exists( 'mysql_set_charset' ) && $this->has_cap( 'set_charset' ) ) {
					mysql_set_charset( $charset, $dbh );
				} else {
					
					$query = $this->prepare( 'SET NAMES %s', $charset );
					if ( ! empty( $collate ) )
						$query .= $this->prepare( ' COLLATE %s', $collate );
					mysql_query( $query, $dbh );
					
				}
			}
		}
	}
	/* ------------------------------------------------------------------------------------- */
	/* Determine if a database supports a particular feature.*/
	public function has_cap( $db_cap ) {
		$version = $this->db_version();
		switch ( strtolower( $db_cap ) ) {
			case 'collation' :    // @since 2.5.0
			case 'group_concat' : // @since 2.7.0
			case 'subqueries' :   // @since 2.7.0
				return version_compare( $version, '4.1', '>=' );
			case 'set_charset' :
				return version_compare( $version, '5.0.7', '>=' );
			case 'utf8mb4' :      // @since 4.1.0
				if ( version_compare( $version, '5.5.3', '<' ) ) {
					return false;
				}
				if ( $this->use_mysqli ) {
					$client_version = mysqli_get_client_info();
				} else {
					$client_version = mysql_get_client_info();
				}

				/*
				 * libmysql has supported utf8mb4 since 5.5.3, same as the MySQL server.
				 * mysqlnd has supported utf8mb4 since 5.0.9.
				 */
				if ( false !== strpos( $client_version, 'mysqlnd' ) ) {
					$client_version = preg_replace( '/^\D+([\d.]+).*/', '$1', $client_version );
					return version_compare( $client_version, '5.0.9', '>=' );
				} else {
					return version_compare( $client_version, '5.5.3', '>=' );
				}
		}

		return false;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;

		if ( strpos( $query, '%' ) === false ) {
			//$this->show_error('The query argument of %s must have a placeholder.');
			return;
		}

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
		return @vsprintf( $query, $args );
	}

	/* ------------------------------------------------------------------------------------- */
	/* The database version number. */
	public function db_version() {
		if ( $this->use_mysqli ) {
			$server_info = mysqli_get_server_info( $this->dbh );
		} else {
			$server_info = mysql_get_server_info( $this->dbh );
		}
		return preg_replace( '/[^0-9.].*/', '', $server_info );
	}
	/* ------------------------------------------------------------------------------------- */	
	public function show_error($err_msg){
		if (APP_DEBUG) {
			die( $err_msg );
		} else {
			die (_('Eroare Baza de date'));
		}
	}
	/* ------------------------------------------------------------------------------------- */	
	protected function set_tables_prefix(){
		if ( preg_match( '|[^a-z0-9_]|i', $this->base_prefix ) )
			show_error('Invalid database prefix');

		foreach ($this->tables as $value) {
    		$this->createProperty($value, $this->base_prefix.$value);
		}
	}
	/* ------------------------------------------------------------------------------------- */	
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }	
	/* ------------------------------------------------------------------------------------- */
}
?>