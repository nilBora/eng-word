<?php

namespace Nil\Common\Core;

abstract class AbstractStore extends Store
{
    protected $tableFile;
    protected $config;
    
    public function __construct($table, $config)
    {
        $this->config = $config;
        $this->config['tableName'] = $table;
        $this->tableFile = $config['table_path'].$table;
    }
    
    public function renderTable(Response &$response, $data)
    {
        if (!array_key_exists('table', $data)) {
            throw new StoreException('Not found table field');
        }
        
        if (!array_key_exists('fields', $data)) {
            throw new StoreException('Not found fields field');
        }
        
        if (array_key_exists('ajax', $_REQUEST) && array_key_exists('edit', $_REQUEST)) {
            $this->_doShowEditForm($data);
        }
        if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] == 'save') {
            $this->_doSaveForm($data);
        }
        
        $select = '';
        $columns = [];
        foreach ($data['fields'] as $key => $field) {
            $select .= $field['name'].', ';
            
            $columns[$field['name']] = $field['caption'];    
        }
        $select = trim($select, ', ');
        $sql = "SELECT ".$select." FROM ".$data['table'];
        $result = $this->search($sql);        
        
        $vars = [
            'table' => $result,
            'columns' => $columns
        ];
        
        $display = new Display($this->config['table_path']);
        
        $response->setContent($display->fetch('table.phtml', $vars));
        
        
        return true;
    }
    
    private function _doShowEditForm($data)
    {
        if (!array_key_exists('id', $_REQUEST)) {
            return false;
        }
        
        $sql = "SELECT * FROM ".$data['table'];
        $search = [
            'id' => (int) $_REQUEST['id']
        ];
        $result = $this->select($sql, $search);
        
        $fields = $data['fields'];
        
        foreach ($fields as $key => $field) {
            $fields[$key]['value'] = $result[$field['name']];
        }
        
        $vars = [
            'id'      => $result['id'],
            'fields'  => $fields,
            'store'   => $this,
        ];

        $display = new Display($this->config['table_path']);
        
        echo $display->fetch('table-edit-popup.phtml', $vars);
        
        exit;
    }
    
     //TODO: In parent
    private function _doSaveForm($data)
    {
        $request = $_REQUEST;
        
        foreach ($data['fields'] as $field) {
            if (array_key_exists($field['name'], $request)) {
                $values[$field['name']] = $request[$field['name']];
            }
        }
        unset($values['id']);
        
        $search = array(
            'id' => $request['id']
        );
        return $this->update($data['table'], $search, $values);
    }
    
    public function fetchParser($nameParser = 'text', $field = [])
    {
        $display = new Display(STORE_DIR.'parsers/views/');
        
        return $display->fetch($nameParser.'.phtml', $field);    
    }

}