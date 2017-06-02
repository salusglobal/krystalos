<?php
use App\Model\UsusuModel;
use App\Lib\Response;
$app->group('/ususu/', function () {

    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Users GET');
    });
    $this->post('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Users POST');
    });
    $this->put('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Users PUT');
    });
    $this->delete('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Users DELETE');
    });

    $this->get('usuarios/[{usuario}]', function ($req, $res, $args) {
        // return $res->getBody()->write('Hello Users GET');
        $usuario="";
        if(isset($args["usuario"])){
         $usuario =  $args["usuario"];
        }
        // var_dump($usuario);
        $um = new UsusuModel("SERVERSGP","KWDEV","SA","SGPserver01*");

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
                json_encode(
                    $um->Get($usuario)
                )
            );

    });

    $this->post('autenticar', function ($req, $res, $args) {
        $json = $req->getParsedBody();
        $data = json_decode($json['json'],true);
        $servidor = $data['servidor'];
        $dbbase = $data['dbbase'];
        $usuario = $data['usuario'];
        $clave = $data['clave'];

        // $servidor = 'SERVERSGP';
        // $compania='01';
        // $dbbase='KWDEV';
        // $usuario='jjimenez';
        // $clave='JUAN11';
        // $usuario='sa';
        // $clave='SGPserver01*';


        try{
          $um = new UsusuModel($servidor,$dbbase,$usuario,$clave);
        }catch(Exception $e){
          $response = new Response();
          $response -> SetResponse (false, 'Imposible establecer conexión.');
          return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                  json_encode(
                      $response
                  )
              );
        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
                json_encode(
                    $um->Autenticar($usuario,$clave)
                )
            );




        // $tokens = new Tokens();
        // $data = array('compania' => $compania, 'usuario' => $usuario, 'clave' => $clave);


    });
});
