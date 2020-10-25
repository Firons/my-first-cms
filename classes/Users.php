<?php

/**
 * Класс для обработки зарегестрированных пользователей
 */
class Users
{
	//Свойства
	/**
	 * @var int ID пользователей из базы данных
	 */
	public $id = null;
	
	/**
    * @var int Дата регистрацции пользователя
    */
   public $whenRegistred = null;
   
   /**
    * @var string Логин пользователя
    */
   public $login = null;
   
   /**
    * @var string Пароль пользователя
    */
   public $password = null;

   /**
    * @var int Разрешение на авторизацию пользователю
    */
   public $activeUser = null;
   
   /**
     * Создаст объект статьи
     * 
     * @param array $data массив значений (столбцов) строки таблицы users
     */
	public function __construct($data = array())
	{
		if (isset($data['id'])){
			$this->id = (int)$data['id'];
		}
		
		if (isset($data['whenRegistred'])){
			$this->whenRegistred = (string)$data['whenRegistred'];
		}
		
		if (isset($data['login'])){
			$this->login = (string)$data['login'];
		}
		
		if (isset($data['password'])){
			$this->password = (string)$data['password'];
		}
		
		if (isset($data['activeUser'])){
			$this->activeUser = (int)$data['activeUser'];
		}
	}
	
	/**
    * Устанавливаем свойства с помощью значений формы редактирования 
    *
    * @param assoc Значения из формы редактирования
    */
	public function storeFormValues ($params)
	{
		// Сохраняем все параметры
		$this->__construct($params);
		
		// Разбираем и сохраняем дату регистрации
		if (isset($params['whenRegistred'])) {
			$whenRegistrede = explode('-', $params['whenRegistred']);

			if (count($whenRegistred) == 3) {
				list ($y, $m, $d) = $whenRegistred;
				$this->whenRegistred = mktime(0, 0, 0, $m, $d, $y);
			}
		}
	}
	
	/**
	* Возвращаем объект пользователя соответствующий заданному ID статьи
	*
	* @param int ID пользователя
	* @return Users|false Объект пользователя или false, если запись не найдена или возникли проблемы
	*/
	public static function getById($id)
	{
		$connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT *, UNIX_TIMESTAMP(whenRegistred) "
                . "AS whenRegistred FROM users WHERE id = :id";
        $st = $connection->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();
        $connection = null;
		
//		echo '<pre>';
//		print_r($row);
//		echo '</pre>';
		
		if ($row){
			return new Users($row);
		}
	}
	
	/**
    * Возвращает все (или диапазон) объекты Users из базы данных
    *
    * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
    * @param string $order Столбец, по которому выполняется сортировка пользователей (по умолчанию = "whenRegistred DESC")
    * @return Array|false Двух элементный массив: results => массив объектов Users; totalRows => общее количество строк
    */
	public static function getList($numRows=1000000, $order="whenRegistred DESC")
	{
		$connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(whenRegistred)
			AS whenRegistred
			FROM users
			ORDER BY $order LIMIT :numRows";
		
		$str = $connection->prepare($sql);
		$str->bindValue(":numRows", $numRows, PDO::PARAM_INT);
		$str->execute();
		
		$list = array();
		while ($row = $str->fetch()) {
            $users = new Users($row);
            $list[] = $users;
        }
		
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $connection->query($sql)->fetch();
		$connection = null;
		
		return (array(
			"results" => $list,
			"totalRows" => $totalRows[0]
			)
		);
	}
	
	/**
    * Вставляем текущий объек Users в базу данных, устанавливаем его ID.
    */
    public function insert()
	{
		// Есть уже у объекта Users ID?
		if (!is_null($this->id)){
			trigger_error("Users::insert(): Attempt to insert an Users object"
			. " that already has its ID property set (to $this->id).", E_USER_ERROR);
		}
		
		// Вставляем пользователя
        $connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO users (whenRegistred, login, password, activeUser) "
				. "VALUES (FROM_UNIXTIME(:whenRegistred), :login, :password, :activeUser)";
        $str = $connection->prepare ($sql);
        $str->bindValue(":whenRegistred", $this->whenRegistred, PDO::PARAM_INT);
        $str->bindValue(":login", $this->login, PDO::PARAM_STR);
        $str->bindValue(":password", $this->password, PDO::PARAM_STR);
        $str->bindValue(":activeUser", $this->activeUser, PDO::PARAM_INT);        
        $str->execute();
        $this->id = $connection->lastInsertId();
        $connection = null;
	}
	
	/**
    * Обновляем текущий объект пользователя в базе данных
    */
    public function update() 
	{
		// Есть ли у объекта пользователя ID?
		if (is_null($this->id)){
			trigger_error("Users::update(): Attempt to update an Users object "
			. "that does not have its ID property set.", E_USER_ERROR);
		}
		
		// Обновляем пользователя
		$connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "UPDATE users SET whenRegistred=FROM_UNIXTIME(:whenRegistred),"
				. " login=:login, password=:password, activeUser=:activeUser"
				. " WHERE id = :id";

		$str = $connection->prepare($sql);
        $str->bindValue(":whenRegistred", $this->whenRegistred, PDO::PARAM_INT);
        $str->bindValue(":login", $this->login, PDO::PARAM_STR);
        $str->bindValue(":password", $this->password, PDO::PARAM_STR);
        $str->bindValue(":activeUser", $this->activeUser, PDO::PARAM_INT); 
		$str->execute();
		$connection = null;
	}
	
	/**
    * Удаляем текущий объект пользователя из базы данных
    */
    public function delete() 
	{
		// Есть ли у объекта пользователя ID?
		if (is_null($this->id)){
			trigger_error("Users::delete(): Attempt to delete an Users object"
				. " that does not have its ID property set.", E_USER_ERROR);
		}
		
		// Удаляем пользователя
		$connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$str = $connection->prepare("DELETE FROM users WHERE id = :id LIMIT 1");
		$str->bindValue(":id", $this->id, PDO::PARAM_INT);
		$str->execute();
		$connection = null;
	}

}