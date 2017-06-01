<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class CiaModel
{
    private $db;
    private $table = 'BDIX.DBO.CIA';
    private $response;

    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }

    public function Get($compania)
    {
      $where = " COMPANIA = CASE WHEN '" . (isset($compania) ? $compania : "") . "' = '' THEN COMPANIA ELSE '" . (isset($compania) ? $compania : "")  . "' END";
      // $where = " 1=1 ";
      try
      {
        $result = array();
        $sql = "SELECT [COMPANIA], [IDTERCERO], [RAZONSOCIAL], [TIPO_ID], [NIT], [DV], [DIRECCION],
          [TELEFONOS], [DSN], [IDSGSSS], [CIUDAD], [SERVIDOR_DBBASE], [DB_BASE], [SERVIDOR_DBLOG], [DB_LOG]
        FROM $this->table
        WHERE ". $where ;
        $sql = "EXEC SPK_CIAListarCIA '".$compania."'";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        $this->response->setResponse(true);
        $this->response->result = $stm->fetchAll();
        return $this->response;
      }
      catch(Exception $e)
      {
        $this->response->setResponse(false, $e->getMessage());
              return $this->response;
      }
    }

}
