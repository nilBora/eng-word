<?php

class UserObject extends Object
{
    private $_tableName = 'users';

    public function get($search)
    {
        if (is_scalar($search)) {
            $search = array('id' => $search);
        }

        $sql = "SELECT * FROM ".$this->_tableName;

        return $this->select($sql, $search);
    }

    public function updateUser($search, $values)
    {
        return $this->update($this->_tableName, $search, $values);
    }
}