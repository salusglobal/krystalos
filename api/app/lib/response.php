<?php
namespace App\Lib;
class Response
{
	public $result     = null;
	public $response   = false;
	public $message    = 'Ocurrio un error inesperado. Vuelve a intentarlo. Si el problema persiste contacte al departamento de tecnología';
	public $href       = null;
	public $function   = null;
  public $token      = null;
	public $filter     = null;
	public function SetResponse($response, $m = '')
	{
		$this->response = $response;
		$this->message  = $m;
		if(!$response && $m = '') $this->response = 'Ocurrio un error inesperado';
	}
  public function SetToken($t)
	{
    $this->token = $t;
	}

}

?>
