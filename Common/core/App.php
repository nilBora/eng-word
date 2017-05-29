<?php

namespace Nil\Common\Core;

class App extends Dispatcher
{
	private static $_instance = null;
    private $_route;
    private $_properties = [];
	private static $_modules = [];
    
	protected $_sessionData = null;
   
    private $_config = null;
    
	public function __construct()
	{
		if (isset(self::$_instance)) {
			$message = 'Instance already defined use App::getInstance';
			throw new Exception($message);
		}
        $this->_setConfig();
        $this->_initSession();
        $this->includeModules();

        $this->_route = new Route();
	}

	public static function getInstance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
    
    private function _initSession()
    {
        $this->_sessionData = ['auth' => ''];
        
        if (array_key_exists('sessionData', $_SESSION)) {
           $this->_sessionData = $_SESSION['sessionData'];
        }

        return true;
    }
    
	public function start()
	{
        $this->_startRecord();

		$currentRouteConfig =  $this->_route->pareseUrl();
        $rules = $this->_route->getRules();
        
		if ($this->_hasExistMethodControllerByConfig($currentRouteConfig)) {

			if ($this->_isAuthRoute($currentRouteConfig)) {
			    
			    $response = new Response();
			    $user = $this->getModule('User');
                $user->login($response);
                $response->send($user);
				return true;
			}
            
            if ($this->getUserID()) {
                $this->_doCheckRoleRules($currentRouteConfig['role'], $rules);
            }
            
            $controllerName = $currentRouteConfig['controller'];
            
            $controllerName = $currentRouteConfig['controller'];
            if (array_key_exists('namespace', $currentRouteConfig)) {
                $controllerName = $currentRouteConfig['namespace'].'\\'.$controllerName;
            }
            
            
            $controller = $this->getModule($controllerName);
            
			$method = $currentRouteConfig['method'];
			
			$params = [];
            $response = new Response();
            $params[] = &$response;
			$maches = $currentRouteConfig['matches'];
			$params = array_merge($params, $maches);
            
			call_user_func_array(
				array($controller, $method),
				$params
			);
            
            $this->_doPrepareResponseByAnnotationss(
			    $response,
			    $controller,
			    $method
            );
            
			$response->send($controller);
			
			return true;
		}
		throw new NotFoundException('Not Found');
	}
    
    public function make()
    {
        
    }
    
    public function terminate()
    {
        $this->_stopRecord();
    }
    
    private function _startRecord()
    {
        return isDev() ? SystemLog::startRecord() : false;
    }
    
    private function _stopRecord()
    {
        return isDev() ? SystemLog::stopRecord() : false;
    }
    
    private function _doPrepareResponseByAnnotationss(
        $response, $controller, $method
    )
    {
        $annotations = $this->getClassAnnotations($controller, $method);
        
        if (!$annotations) {
            return false;
        }


        foreach ($annotations as $annotation) {
            $params = explode(" ", $annotation);

            $const = trim($params[2]);

//            if (!defined($const)) {
//                throw new \Exception(sprintf('Constant not found %s', $const));
//            }
            $const = constant("Nil\Common\Core\\".$const);
            switch($params[1]) {
                case 'type':
                    $response->setType($const);
                    break;
                case 'action':
                    $response->setAction($const);
                    break;
                default: 
                    break;
            }
        }
        
        return true;
    }
    
    // TODO: move to Controller
    public function getClassAnnotations($class, $method)
    {
        $r = new \ReflectionMethod($class, $method);
       
        $doc = $r->getDocComment();
        
        $allow = ['Response'];
        
        $regExp = '#@('.implode("|", $allow).'.*?)\n#s';
        
        preg_match_all($regExp, $doc, $annotations);
        
        if (empty($annotations[1])) {
            return false;
        }
        
        return $annotations[1];
    }

    private function _doCheckRoleRules($role, $rules)
    {
        if (!$role) {
            return true;
        }
        
        $userID = $this->getUserID();
        $userModule = $this->getModule('User');
        $user = $userModule->getUserByID($userID);
        
        if (!array_key_exists($role, $rules)) {
            return true;    
        }
        
        $rule = $rules[$role];
        
        if (in_array($user['role'], $rule)) {
            return true;        
        }
        
        throw new PermissionException();
    }

	private function _hasExistMethodControllerByConfig($currentRouteConfig)
	{
        if (!array_key_exists('controller', $currentRouteConfig)) {
            throw new NotFoundException();
        }

        $controller = $currentRouteConfig['controller'];

        if (!empty($currentRouteConfig['namespace'])) {
            $controller = $currentRouteConfig['namespace'].'\\'.$controller;
        }

		return $currentRouteConfig &&
		 	   method_exists(
				   $controller,
				   $currentRouteConfig['method']
			   );
	}

	private function _isAuthRoute($currentRouteConfig)
	{
		return $currentRouteConfig['auth'] && !$this->_isAuthInSessionData();
	}
	
	public function getUserID()
	{
		if (array_key_exists('user_id', $this->_sessionData)) {
			return $this->_sessionData['user_id'];
		}
		
		return false;
	}

	private function _isAuthInSessionData()
	{
		return array_key_exists('auth', $this->_sessionData)
			   && $this->_sessionData['auth'];
	}
	
	public function setSession($key, $value)
	{
		$this->_sessionData[$key] = $value;
		$_SESSION['sessionData'][$key] = $value;
	}

	public function doClearSession()
	{
		unset($_SESSION['sessionData']['auth']);
		unset($this->_sessionData['auth']);
		unset($this->_sessionData['user_id']);

		return true;
	}
    
    
    private function _setConfig()
    {
        $this->_config = $GLOBALS;
    }

    public function getConfig($key)
    {
        if (!array_key_exists($key, $this->_config)) {
            throw new Exception('Not found config with key: '.$key);
        }
        
        return $this->_config[$key];
    }
    
    public function getConfigs()
    {
        return $this->_config;
    }
    
    public function getCurrentUserID()
    {
        return $this->getUserID();
    }

    public function redirect($url)
    {
        //FIXME
        $href = 'http://' . $_SERVER['SERVER_NAME'];
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $href . $url);
        exit;
    }
    
    public function getModule($module = 'User')
    {
        if (array_key_exists($module, static::$_modules)) {
            return static::$_modules[$module];
        }
       
        if (!class_exists($module)) {
            throw new \Exception(sprintf("%s class Not found", $module));
        }
        
        $baseNameModule = basename(str_replace('\\', '/', $module));
        
        $pathModule = MODULES_DIR.$baseNameModule.'/';
        
        $instance = new $module($pathModule);

        $moduleObject = $module.'Object';
        if (file_exists($pathModule.$moduleObject.'.php')) {
            $instance->object = new $moduleObject();
        }
        static::$_modules[$module] = $instance;
        
        return $instance;
    }
    
    public function includeStatic($name)
    {
        $this->setProperty($name, 'path');
    }
    
    public function setProperty($name, $path)
    {
        $this->_properties[$name] = $path;
    }
    
    public function getProperties()
    {
        return $this->_properties;
    }

    public function includeModules()
    {
        $configModules = [];
        $modules = array(
            'Admin',
            'EngWord',
            'Main',
            'Queue',
            'RESTfulApi',
            'User'
        );

        foreach ($modules as $module) {
            $fileDir = MODULES_DIR.$module.'/'.$module.'.php';
            if (file_exists($fileDir)) {
                require_once $fileDir;
            }

            $fileDir = MODULES_DIR.$module.'/'.$module.'Object.php';
            if (file_exists($fileDir)) {
                require_once $fileDir;
            }

            $fileDir = MODULES_DIR.$module.'/'.$module.'Api.php';
            if (file_exists($fileDir)) {
                require_once $fileDir;
            }

            $configDir = MODULES_DIR.$module.'/'.'config.php';
            if (file_exists($configDir)) {
                include $configDir;
                if (!empty($config)) {
                    $configModules = array_merge($configModules, $config);
                }

            }
        }

        $this->_config = array_merge($configModules, $this->_config);
    }

    public function createCrudInstance($table)
    {
        $whoInvoke = debug_backtrace();
        $path = dirname($whoInvoke[0]['file']).'/table/';
        
        $options = [
            'table_path' => $path
        ];
        $crud = new Crud($table, $options);
        
        return $crud;
    }
}