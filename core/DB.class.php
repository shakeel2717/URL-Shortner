<?php 
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  sofware and contact gempixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package Core\DB
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core;

use Core\Support\ORM;

final class DB extends ORM {

	/**
	 * The wrapped find_one and find_many classes will
	 * return an instance or instances of this class.
	 *
	 * @var string $_class_name
	 */
	protected $_class_name;
	/**
	 * Column name
	 * @var [type]
	 */
	private $column_name;
	/**
	 * DB Engine
	 * @var string
	 */
	private $db_engine = "INNODB";
	/**
	 * DB Charset
	 * @var string
	 */
	private $charset = "utf8mb4";
	/**
	 * Has increment
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 */
	private $hasincrement = false;
	/**
	 * Query mode
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 */
	private static $mode = 'insert';
	/**
	 * DB class constructor
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 */
	public function __construct($name = null, $connection_name = null){
		if(!is_null($name) && !is_null($connection_name)) parent::__construct($name, $connection_name);
		return $this;
	}

	/**
	 * Magic Method to fetch tables
	 *
	 * @example  DB::__TABLENAME__()->
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 */
	public static function __callStatic($name, $connection_name = parent::DEFAULT_CONNECTION){
		if(defined('DBprefix')) $name = DBprefix.$name;

		return new self($name, $connection_name);
	}

	/**
	 * Boot ORM
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param array $credential
	 * @return void
	 */
	public static function Connect($credential = null){

		if(!$credential) {

			$credential = [
				'host' => DBhost,
				'name' => DBname,
				'user' => DBuser,
				'pass' => DBpassword,
				'port' => DBport,
			];	

		}

		parent::configure('mysql:host='.$credential['host'].';port='.$credential['port'].';dbname='.$credential['name']);
		parent::configure('username', $credential['user']);
		parent::configure('password', $credential['pass']);		
		parent::configure('return_result_sets', false);
		parent::configure('driver_options', [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']);
		if(defined('DEBUG') && DEBUG) parent::configure('logging', true);
	}
	/**
	 * Static method to override __callStatic
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $name [description]
	 */
	public static function table($name, $connection_name = parent::DEFAULT_CONNECTION){
		
		if(defined('DBprefix')) $name = DBprefix.$name;
		
		return new self($name, $connection_name);
	}
	/**
	 * Get First Element
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $id [description]
	 * @return  [type]     [description]
	 */
  public function first($id = null){
	return parent::find_one($id);
  }	
  /**
   * FindMany Alias
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type]     [description]
   */
  public function find(){
	return parent::findMany();
  }   
  /**
   * Fetch and Map Data
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   Closure $fn [description]
   * @return  [type]      [description]
   */
  public function map(\Closure $fn){
	$result = [];
	foreach (parent::findMany() as $data) {
	  $result[] = $fn($data);
	}
	return $result;  
  }
  /**
   * Paginate
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 1.0
   * @param integer $count
   * @return void
   */
	public function paginate($count = 15, $simple = false){
		
		$page = currentpage();
		
		$total = $simple ? count(parent::select('id')->limit($count)->offset(($page)*$count)->findMany()) : parent::count();
		
		$results = parent::limit($count)->offset(($page-1)*$count)->findMany();

		$queries = (new Request)->query();
		$queries['page'] = '%d';

		Helper::paginate($total, $count, $page, '?'.\urldecode(\http_build_query($queries)), $simple);

		return $results;
	}
  /**
   * Create Schema
   *
   *  DB::schema('test', function($table){
   *   $table->engine("MYISAM");
   *   $table->charset("utf8");
   *   $table->increment('id');
   *   $table->string('email')->index();
   *   $table->text('description');
   *   $table->json('data');
   *   $table->timestamp();
   *   $table->enum("type", ["a", "b", "c"]);
   * });
	 *	
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type]  $table  [description]
   * @param   Closure $scheme [description]
   * @return  [type]          [description]
   */
	public static function schema($table, \Closure $scheme){

		if(defined('DBprefix')) $table = DBprefix.$table;
		
		self::$mode = "create";

		$db = new self();
		$db->query = "CREATE TABLE IF NOT EXISTS `{$table}` (\n";
		$scheme($db);
		$db->query = trim($db->query, ",\n");

		$db->query .= "\n) ENGINE={$db->db_engine}".($db->hasincrement ? ' AUTO_INCREMENT=1':'')." DEFAULT CHARSET={$db->charset};";

		try{
			parent::raw_execute($db->query);	
		} catch(Exception $e){  					
			GemError::trigger(500, $e->getMessage());
		}  	
	} 
  /**
   * DB Engine
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   string $engine [description]
   * @return  [type]         [description]
   */
	public function engine(string $engine){
		$this->db_engine = $engine;
	}
  /**
   * Set Charset
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   string $charset [description]
   * @return  [type]          [description]
   */
	public function charset(string $charset){
		$this->charset = $charset;
	}
  /**
   * Create an increment
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name [description]
   * @return  [type]       [description]
   */
	public function increment($name, $length = null) {
		$this->column_name = $name;
		$this->query .= "`{$this->column_name}` ".($length ? 'bigint('.$length.')' : 'bigint')." NOT NULL AUTO_INCREMENT,\n";
		$this->query .= "PRIMARY KEY (`{$this->column_name}`),\n";
		$this->hasincrement = true;
		return $this;
	}
	/**
	 * Tiny Int
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $name
	 * @param [type] $length
	 * @param [type] $default
	 * @return void
	 */
	public function int($name, $length = null, $default = null) {
		$this->column_name = $name;
		$default_placeholder = $default == null ? ' DEFAULT NULL' : " DEFAULT '{$default}'";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` ".($length ? 'tinyint('.$length.')' : 'tinyint')."{$default_placeholder},\n";
		return $this;
	}
	/**
	 * Create Integer
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $name
	 * @param integer $length
	 * @return void
	 */
	public function integer($name, $length = null, $default = null) {
		$this->column_name = $name;
		$default_placeholder = $default == null ? ' DEFAULT NULL' : " DEFAULT '{$default}'";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` ".($length ? 'int('.$length.')' : 'int')."{$default_placeholder},\n";
		return $this;
	}
	/**
	 * Big Int
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $name
	 * @param [type] $length
	 * @param [type] $default
	 * @return void
	 */
	public function bigint($name, $length = null, $default = null) {
		$this->column_name = $name;
		$default_placeholder = $default == null ? ' DEFAULT NULL' : " DEFAULT '{$default}'";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` ".($length ? 'bigint('.$length.')' : 'bigint')."{$default_placeholder},\n";
		return $this;
	}
	/**
	 * Create Double
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $name
	 * @param [type] $length
	 * @param [type] $default
	 * @return void
	 */
	public function double($name, $length = null, $default = null) {
		$this->column_name = $name;
		$default_placeholder = $default == null ? ' DEFAULT NULL' : " DEFAULT '{$default}'";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` double({$length}){$default_placeholder},\n";
		return $this;
	}
  /**
   * Create a timestamp
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name [description]
   * @return  [type]       [description]
   */
	public function timestamp($name = "created_at", $default = 'current'){
		$this->column_name = $name;
		$default_placeholder = $default == null ? ' NULL DEFAULT NULL' : " DEFAULT CURRENT_TIMESTAMP";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` timestamp{$default_placeholder},\n";
		return $this;
	}
  /**
   * Create a string
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type]  $name   [description]
   * @param   integer $length [description]
   * @return  [type]          [description]
   */
	public function string($name, $length = 191, $default = null){
		$this->column_name = $name;
		$length = $length < 255 ? $length : 255;
		$default_placeholder = $default == null ? ' DEFAULT NULL' : " DEFAULT '{$default}'";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` varchar({$length}){$default_placeholder},\n";
		return $this;
	}
  /**
   * Create a text
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name [description]
   * @return  [type]       [description]
   */
	public function text($name, $default = null){
		$this->column_name = $name;
		$default_placeholder = $default == null ? ' DEFAULT NULL' : " DEFAULT '{$default}'";
		
		if($default === false) $default_placeholder = ' NOT NULL';

		$this->query .= "`{$this->column_name}` text{$default_placeholder},\n";
		return $this;
	}
  /**
   * Generate Enum
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name  [description]
   * @param   array  $array [description]
   * @return  [type]        [description]
   */
	public function enum($name, array $array = []){
		$this->column_name = $name;
		$options = implode("','", $array);
		$this->query .= "`{$this->column_name}` enum('{$options}')  DEFAULT NULL,\n";
		return $this;
	}
  /**
   * Create a JSON table
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name [description]
   * @return  [type]       [description]
   */
	public function json($name){
		$this->column_name = $name;
		$this->query .= "`{$this->column_name}` json  DEFAULT NULL,\n";
		return $this;  	
	}
	/**
	 * Primary Key
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @return void
	 */
	public function primary(){
		$this->query .= "PRIMARY KEY(`{$this->column_name}`),\n";  	
	}
  /**
   * Create a unique key
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  	public function unique($column = null){
		if($column) $this->column_name = $column;
  		$this->query .= self::$mode == "alter" ? "ADD UNIQUE `{$this->column_name}` (`{$this->column_name}`)," : "UNIQUE(`{$this->column_name}`),\n";  	
  	}
  /**
   * Create an index
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
	public function index($column = null){
		if($column) $this->column_name = $column;
  		$this->query .= self::$mode == "alter" ? "ADD INDEX `{$this->column_name}` (`{$this->column_name}`)," : "INDEX(`{$this->column_name}`),\n";  	
  	}  
  /**
   	* Alter Table
	*   
 	*	DB::alter('table', function($table){
	*        $table->change('column_name')->string('column_name');
   	*        $table->drop('column_name2');
    *   });
	* 
	* @author GemPixel <https://gempixel.com>
	* @version 1.0
	* @param   [type]   $table    [description]
	* @param   \Closure $commands [description]
	* @return  [type]             [description]
	*/
  	public static function alter($table, \Closure $commands){
		
		if(defined('DBprefix')) $table = DBprefix.$table;

		$db = new self();

		self::$mode = "alter";

		$db->query = "ALTER TABLE `{$table}`\n";
		$commands($db);

		$db->query = trim($db->query, ",\n");

		$db->query .= ";";

		try{
			parent::raw_execute($db->query);  
		} catch(Exception $e){      
			GemError::trigger(500, $e->getMessage());
		}      
  	}
  /**
   * Add Column
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 1.0
   * @return void
   */
  	public function add(){
		$this->query .= "ADD ";
		return $this;
 	}
	/**
	 * Drop Column
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @return void
	 */
	public function drop($column){
		$this->query .= "DROP `{$column}`";
		return $this;
	}
	/**
	 * Change Column
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $column
	 * @return void
	 */
	public function change($column){
		$this->column_name = $column;
		$this->query .= "CHANGE `{$column}` ";
		return $this;
	}
	/**
	 * Destroy Table
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $table
	 * @return void
	 */
	public static function destroy($table){
		
		if(defined('DBprefix')) $table = DBprefix.$table;

		$db = new self();

		$db->query = "DROP TABLE `{$table}`;";

		try{
			parent::raw_execute($db->query);  
		} catch(Exception $e){      
			GemError::trigger(500, $e->getMessage());
		}   
	}
	/**
	 * Truncate Table
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $table
	 * @return void
	 */
	public static function truncate($table){
		
		if(defined('DBprefix')) $table = DBprefix.$table;

		$db = new self();

		$db->query = "TRUNCATE TABLE `{$table}`;";

		try{
			parent::raw_execute($db->query);  
		} catch(Exception $e){      
			GemError::trigger(500, $e->getMessage());
		}
	}
	/**
	 * Check column exists
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $table
	 * @param [type] $column
	 * @return void
	 */
	public static function columnExists($table, $column){
		
		if(defined('DBprefix')) $table = DBprefix.$table;

		if($query = parent::for_table('')->raw_query("SHOW COLUMNS FROM `{$table}` WHERE Field = '{$column}'")->findOne()){
			return true;
		}	

		return false;
	}

	public static function hasIndex($table, $column){
		if(defined('DBprefix')) $table = DBprefix.$table;

		if($query = parent::for_table('')->raw_query("SHOW INDEX FROM `{$table}` WHERE COLUMN_NAME = '{$column}'")->findOne()){
			return true;
		}	
		return false;
	}
}