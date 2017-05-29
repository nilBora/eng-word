<?php

//namespace Nil\modules\Main;

use \Nil\Common\Core\Display;

class Main extends Display
{
    public function displayDefault()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {

            $login = $_POST['email'];
            $password = $_POST['password'];
            $userController = $this->controller->User;
            $user = $userController->auth($login, $password);

            if ($user) {
                $this->setSession('auth', md5($user['id']));
                $this->setSession('user_id', $user['id']);
                $this->redirect('/');
            }
        }


        echo $this->fetch('login.phtml');
    }
    
    public function onDisaplyTest($test)
    {
        echo 'Main TEST with Main Plugin '.$test.". ";
    }
    
    public function test2(Response &$response)
    {
        $response->setContent(11);
        $response->asas = 'test';
        $this->fff = 'ad';
        //echo 'test2';
    }
}