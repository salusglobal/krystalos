<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class UsusuModel
{
    private $db;
    private $table = 'ususu';
    public $response;

    public function __CONSTRUCT($servidor,$dbbase,$usuario,$clave)
    {
        $this->db = Database::StartUp($servidor,$dbbase,$usuario,$clave);
        $this->response = new Response();
    }

    public function Get($usuario)
    {
      $usuario='jjimenez';
      $where = " USUARIO = CASE WHEN ISNULL('".$usuario."','') = '' THEN USUARIO ELSE '".$usuario."' END ";
      try
      {
        $result = array();
        $sql = "SELECT [COMPANIA] , [USUARIO], [CLAVE]=DBO.FNK_DESCIFRAR(CLAVE), [NOMBRE], [GRUPO]=DBO.FNK_DESCIFRAR(GRUPO), [TIPO],
          [IDMEDICO], [NIVELFUNCIONARIO], [CODCAJERO], [SYS_ComputerName], [FECHACAMBIO], [ESTADO], [ESMEDICO], [IDSEDE],
          [IDIMAGEN], [CARGO], [TELEFONO], [CELULAR], [FECHAVENCE], [CONECTADO], [SYS_COMP_CONECTADO], [FECHACONEC],
          [KEYUSER1], [IDTERCERO], [IDFIRMA]
        FROM $this->table
        WHERE ". $where ."
        ";
        // $sql="SELECT USUARIO FROM USUSU";
        $stm = $this->db->prepare($sql);
        $stm->execute();

        $this->response->setResponse(true);
        $result = $stm->fetchAll();
        $data = array();
        foreach ($result as $fila) {
          $fila->USUARIO=utf8_decode($fila->USUARIO);
          $fila->NOMBRE=utf8_decode($fila->NOMBRE);
          $fila->CARGO=utf8_decode($fila->CARGO);
          // $fila->CLAVE='';
          $data[] = $fila;
        }
              // $this->response->result = $stm->fetchAll();
              $this->response->result = $data;

              return $this->response;
      }
      catch(Exception $e)
      {
        $this->response->setResponse(false, $e->getMessage());
              return $this->response;
      }
    }
    /*
    public function InsertOrUpdate($data)
    {
      try
      {
              if(isset($data['id']))
              {
                  $sql = "UPDATE $this->table SET
                              Nombre          = ?,
                              Apellido        = ?,
                              Correo          = ?,
                              Sexo            = ?,
                              Sueldo          = ?,
                              Profesion_id    = ?,
                              FechaNacimiento = ?
                          WHERE id = ?";

                  $this->db->prepare($sql)
                      ->execute(
                          array(
                              $data['Nombre'],
                              $data['Apellido'],
                              $data['Correo'],
                              $data['Sexo'],
                              $data['Sueldo'],
                              $data['Profesion_id'],
                              $data['FechaNacimiento'],
                              $data['id']
                          )
                      );
              }
              else
              {
                  $sql = "INSERT INTO $this->table
                              (Nombre, Apellido, Correo, Sexo, Sueldo, Profesion_id, FechaNacimiento, FechaRegistro)
                              VALUES (?,?,?,?,?,?,?,?)";

                  $this->db->prepare($sql)
                      ->execute(
                          array(
                              $data['Nombre'],
                              $data['Apellido'],
                              $data['Correo'],
                              $data['Sexo'],
                              $data['Sueldo'],
                              $data['Profesion_id'],
                              $data['FechaNacimiento'],
                              date('Y-m-d')
                          )
                      );
              }

        $this->response->setResponse(true);
              return $this->response;
      }catch (Exception $e)
      {
              $this->response->setResponse(false, $e->getMessage());
      }
    }
    public function Delete($id)
    {
      try
      {
        $stm = $this->db
                    ->prepare("DELETE FROM $this->table WHERE id = ?");

        $stm->execute(array($id));

        $this->response->setResponse(true);
              return $this->response;
      } catch (Exception $e)
      {
        $this->response->setResponse(false, $e->getMessage());
      }
    }
    */
}
