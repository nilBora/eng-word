<?php 
class Queue extends Display
{
	public function addQueue($options, $idUser)
	{
		$values = array(
			'id_user' => $idUser,
			'options' => json_encode($options)
		);
		
		return $this->object->add($values);
	}
	
	public function getQueueByUserID($idUser)
	{
		$search = array(
			'id_user' => $idUser
		);
		
		$queue = $this->object->get($search);
		
		return $queue;
	}
	
	public function clearByID($id)
	{
		$search = array(
			'id' => $id
		);
		
		$this->object->remove($search);
	}
}