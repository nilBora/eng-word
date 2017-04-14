<?php

class QueueObject extends Object
{
	private $_tableName = 'queue';
	
	public function add($values)
	{
		return $this->insert($this->_tableName, $values);
	}
	
	public function get($search)
	{
		$sql = "SELECT * FROM ".$this->_tableName;
	
		return $this->select($sql, $search);
	}
	
	public function remove($search)
	{
		return $this->delete($this->_tableName, $search);
	}
}