<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;

class UsusuModel
{
    private $db;
    private $table = 'ususu';
    public $response;

    private $servidor;
    private $dbbase;

    public function __CONSTRUCT($servidor,$dbbase,$usuario,$clave)
    {
      try{
        $this->response = new Response();
        $this->db = Database::StartUp($servidor,$dbbase,$usuario,$clave);
        $this->servidor = $servidor;
        $this->dbbase = $dbbase;
      }catch(Exception $e){
        $this->response->setResponse(false, $e->getMessage());
        return $this->response;
      }
    }

    public function Get($usuario){
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

    public function Autenticar($usuario,$clave){

      $aux = $usuario;

      // $usuario = 'jjimenez';
      // $where = 'juan11';
      // $userResponse = $this->get($usuario);
      try
      {
        $result = array();
        $sql = "SELECT [COMPANIA] , [USUARIO], [CLAVE]=DBO.FNK_DESCIFRAR(CLAVE), [NOMBRE], [GRUPO]=DBO.FNK_DESCIFRAR(GRUPO), [TIPO],
          [IDMEDICO], [NIVELFUNCIONARIO], [CODCAJERO], [SYS_ComputerName], [FECHACAMBIO], [ESTADO], [ESMEDICO], [IDSEDE],
          [IDIMAGEN], [CARGO], [TELEFONO], [CELULAR], [FECHAVENCE], [CONECTADO], [SYS_COMP_CONECTADO], [FECHACONEC],
          [KEYUSER1], [IDTERCERO], [IDFIRMA]
        FROM $this->table
        WHERE USUARIO = '{$usuario}' ";
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

        if(count($data) <= 0){
          $this->response->result = array();
          $this->response->setResponse(false, 'Usuario no encontrado en la base de datos. Contacte con el departamento de tecnología.');
          return $this->response;
        }

        if(strtoupper($data[0]->ESTADO) !== 'ACTIVO'){
          $this->response->result = array();
          $this->response->setResponse(false, 'Usuario inactivo, contacte por favor con el departamento de tecnología.');
          return $this->response;
        }
        if(strtoupper($clave)!==strtoupper(trim($data[0]->CLAVE))){
          $this->response->result = array();
          $this->response->setResponse(false, 'Clave incorrecta, vuelve a intentarlo.');
          return $this->response;
        }

        $exp_date = $data[0]->FECHACAMBIO;
        $todays_date = date("Y-m-d");$today = strtotime($todays_date);
        $expiration_date = strtotime($exp_date);

        if ($expiration_date > $today) {
          // código a mostrar si el contenido está vigente
        } else {
          // código a mostrar si el contenido está pasado
          $this->response->setResponse(false, 'Clave caducada, por favor diríjase al departamento de tecnología.');
          return $this->response;
        }
        $jwt = new Tokens();
        /*FALTAN LOS DATOS DE CONEXION*/
        $data[0]->SERVIDOR = $this->servidor;
        $data[0]->DBBASE = $this->dbbase;
        $token = $jwt->encode($data[0]);
        unset($data[0]->SERVIDOR);
        unset($data[0]->DBBASE);
        $data[0]->CLAVE='';
        $data[0]->TOKEN=$token;

        $this->response->SetToken($token);
        // $this->response->result = $stm->fetchAll();

        $this->response->result = $data[0];
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
