<?php

namespace App\Entity;

use App\DB\Database;
use \PDO;

class Vaga {

	/**
	 * Identificador único da vaga
	 * @var integer
	 */
	public $id;

	/**
	 * Título da vaga
	 * @var string
	 */
	public $titulo;

	/**
	 * Descrição da vaga
	 * @var string
	 */
	public $descricao;

	/**
	 * Define se a vaga está ativa ou não
	 * @var string(s,n)
	 */
	public $ativo;

	/**
	 * Data de abertura da vaga
	 * @var string
	 */
	public $dt_abertura;

	/**
	 * Método responsável por cadastrar a vaga no banco de dados
	 * @return boolean
	 */
	public function cadastrar() {
		$this->dt_abertura 	= date('Y-m-d H:i:s');
		$obDatabase 		= new Database('vagas');

		$this->id   		= $obDatabase->insert([
			'titulo'		=> $this->titulo,
			'descricao'		=> $this->descricao,
			'ativo'			=> $this->ativo,
			'dt_abertura'	=> $this->dt_abertura
		]);
		
		return true;
	}

	/**
	 * Método responsável por atualizar a vaga no banco de dados
	 * @return boolean
	 */
	public function atualizar() {
		return (new Database('vagas'))->update('id='.$this->id, [
																	'titulo'		=> $this->titulo,
																	'descricao'		=> $this->descricao,
																	'ativo'			=> $this->ativo,
																	'dt_abertura'	=> $this->dt_abertura
																]);
	}

	/**
	 * Método responsável por obter as vagas cadastradas no banco
	 * @param string $where
	 * @param string $order
	 * @param string $limit
	 * @return array
	 */

	/**
	 * Método responsável por excluir a vaga do banco de dados
	 * @return boolean
	 */
	public function excluir() {
		return (new Database('vagas'))->delete('id= '.$this->id);
	}

	public static function getVagas($where = null, $order = null, $limit = null) {
		return (new Database('vagas'))->select($where, $order, $limit)
									  ->fetchAll(PDO::FETCH_CLASS, self::class);
	}

	/**
	 * Método para buscar uma vaga com base no id
	 * @param integer $id
	 * @return Vaga
	 */
	public static function getVaga($id) {
		return (new Database('vagas'))->select('id= '.$id)
									  ->fetchObject(self::class);
	}

}