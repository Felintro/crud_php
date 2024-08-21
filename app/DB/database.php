<?php

namespace App\DB;

use \PDO;
use \PDOException;

class Database {

	/**
	 * Host de conexão com o banco de dados
	 * @var string
	 */
	const HOST = 'localhost';

	/**
	 * Nome da base de dados
	 * @var string
	 */
	const NAME = 'crud_php';

	/**
	 * Nome de usuário de autenticação do banco de dados
	 * @var string
	 */
	const USER = 'root';

	/**
	 * Senha de autenticação do banco de dados
	 * @var string
	 */
	const PASS = 'root';

	/**
	 * Nome da tabela de dados que estaremos manipulando
	 * @var string
	 */
	private $table;

	/**
	 * Instância de conexão com o banco de dados
	 * @var PDO
	 */
	private $connection;

	/**
	 * Define a tabela e instancia nossa conexão com o banco de dados
	 * @param string $table
	 */
	public function __construct($table = null) {
		$this->table = $table;
		$this->setConnection();
	}

	/**
	 * Cria uma conexão com o banco de dados
	 */
	private function setConnection() {
		try {
			$this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			die('ERROR: '.$e->getMessage());
		}
	}

	/**
	 * Método responsável por executar as queries no banco de dados
	 * @param string $query
	 * @param array $params
	 * @return PDOStatement
	 */
	public function execute($query, $params = []) {
		try {
			$statement = $this->connection->prepare($query);
			$statement->execute($params);
			return $statement;
		} catch(PDOException $e) {
			die('ERROR: '.$e->getMessage());
		}
	}

	/**
	 * Método de insert para o banco de dados
	 * @param array $values [field => value]
	 * @return integer id
	 */
	public function insert($values) {
		$fields = array_keys($values);
		$binds = array_pad([], count($fields), '?');

		$query = 'INSERT INTO '.$this->table.' (' .implode(',',$fields).') VALUES ('.implode(',', $binds).');';

		$this->execute($query,array_values($values));

		return $this->connection->lastInsertId();

		// echo "<pre>"; print_r($query) ; echo "</pre>"; exit;
	}

	/**
	 * Método de select para o banco de dados
	 * @param string $where
	 * @param string $order
	 * @param string $limit
	 * @return PDOStatement
	 */
	public function select($where = null, $order = null, $limit = null, $fields = '*') {

		$where = strlen($where) ? 'WHERE '.$where : '';
		$order = strlen($order) ? 'ORDER BY '.$order : '';
		$limit = strlen($limit) ? 'LIMIT '.$limit : '';


		$query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit.';';

		return $this->execute($query);
	}
	
	/**
	 * Método responsável por efetuar o update no banco de dados
	 * @param string $where
	 * @param array $values [ field => value ]
	 * @return boolean
	 */
	public function update($where, $values) {
		$fields = array_keys($values);
		$query = 'UPDATE '.$this->table.' SET '.implode('=?, ', $fields).'=? WHERE '.$where;
		$this->execute($query, array_values($values));
		return true;
	}

}