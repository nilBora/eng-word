<?php

class UserValuesObject extends ValuesObject
{
    public function getID()
    {
        return $this->get('id');
    }

    public function getAccessToken()
    {
        return $this->get('access_token');
    }
}