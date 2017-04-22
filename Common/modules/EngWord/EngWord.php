<?php

class EngWord extends Display
{
    /**
     * @Response type Response::TYPE_NORMAL
     * @Response action Response::ACTION_REDIRECT
     */
    public function displayIndex(Response &$response)
    {
        $vars = array();
      
        $this->controller->includeStatic('test.js');
        
        $response->content = $this->fetch('index.phtml', $vars);
        
        return true;
    }
	
	/**
	* @Request post
	* @type string $word
	*/
	public function getTranslate(Response &$response)
	{
		if (empty($_POST['word'])) {
			throw new Exception("No Word!");
		}
		$word = trim(mb_strtolower($_POST['word']));
 		$this->fragment = true;
		$response->setType(Response::TYPE_JSON);

		$wordData = $this->object->get($word);
		
		if ($wordData) {
			$translate = $wordData['translate'];
			$this->_updateTranslate($wordData);
		}
		if (!$wordData) {
			$translateData = $this->_getYandexTranslate($word);
			$translate = $translateData['text'][0];
			$values = array(
				'word' 		=> $word,
				'translate' => $translate,
				'frequency' => 1,
				'user_id' 	=> 1
			);
			$this->object->add($values);
		}

		$response->content = array('translate' => $translate);
		return true;
	}

	private function _updateTranslate($wordData)
	{
		$values = array(
			'frequency' => $wordData['frequency'] + 1,
			'mdate' => date("Y-m-d H:i:s")
		);
		$search = array(
			'id' => $wordData['id']
		);

		return $this->object->change($search, $values);
	}
	
	private function _getYandexTranslate($string)
	{
		$apiKey = 'trnsl.1.1.20161205T200810Z.af383dcd1b823b6f.1be898480d11b4a2d43cdc2884695fd754286ac8';
		$url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?key='.$apiKey."&text=".$string."&lang=en-ru";
		$response = file_get_contents($url);

		$response = json_decode($response, true);
		return $response;
	}
	
	public function getWordByBot(Response &$response)
	{
		$this->fragment = true;
		$response->setType(Response::TYPE_JSON);
		$data = array('message' => 'Server Time: '.date('d-m-Y H:i:s'));
		$response->content = $data;
		
		return true;
	}
	
    public function test(Response &$response, $id)
    {
        $this->fragment = true;
        echo $id;
        echo 1;
    }
    
    
    public function onRedirect(Response $response)
    {
        $response->setAction(Response::ACTION_REDIRECT);
        $response->url = '/';
        
        return true;
    }
}