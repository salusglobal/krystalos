<?php
use App\Model\UsusuModel;
use App\Lib\Tokens;
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
        // /*
        // $json = $request->getParsedBody();
        // $data = json_decode($json['json'],true);

        // $servidor = $data['servidor'];
        // $dbbase = $data['dbbase'];
        // $usuario = $data['usuario'];
        // $clave = $data['clave'];

        // if($usuario===''||$compania===''||$clave===''){
        //   $this->response->setResponse(false, 'Campos vacíos');
        //   return $this->response;
        // }
        // */
        // $servidor = 'SERVERSGP';
        // $compania='01';
        // $dbbase='KWDEV';
        // $usuario='jjimenez';
        // $clave='JUAN11';
        // $usuario='sa';
        // $clave='SGPserver01*';


        // $um = new UsusuModel($servidor,$dbbase,$usuario,$clave);
        $usuario = 'jjimenez';
        $um = new UsusuModel("SERVERSGP","KWDEV","SA","SGPserver01*");
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
                json_encode(
                    $um->Get($usuario)
                )
            );




        // if($usuario!==$u->usuario||$clave!==$u->clave){
        //   $um->response->setResponse(false, 'Usuario y contraseña no coinciden. Intentelo de nuevo.');
        //   // return $this->response;
        //   return $res
        //    ->withHeader('Content-type', 'application/json')
        //    ->getBody()
        //    ;
        // }

        // $tokens = new Tokens();
        // $data = array('compania' => $compania, 'usuario' => $usuario, 'clave' => $clave);


    });
});
