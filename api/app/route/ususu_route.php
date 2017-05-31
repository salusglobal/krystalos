<?php
use App\Model\UsusuModel;
use App\Lib\Tokens;

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
        $um = new UsusuModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
                json_encode(
                    $um->Get($usuario)
                )
            );

    });

    $this->get('autenticar', function ($req, $res, $args) {
        /*
        $json = $request->getParsedBody();
        $data = json_decode($json['json'],true);

        $compania = $data['compania'];
        $usuario = $data['usuario'];
        $clave = $data['clave'];

        if($usuario===''||$compania===''||$clave===''){
          $this->response->setResponse(false, 'Campos vacíos');
          return $this->response;
        }
        */
        $compania='01';
        $usuario='jjimenez';
        $clave='JUAN11';



        $um = new UsusuModel();
        $u = $um->Get($usuario);
        // var_dump($usuario->result[0]);

        if($usuario!==$u->usuario||$clave!==$u->clave){
          $this->response->setResponse(false, 'Usuario y contraseña no coinciden. Intentelo de nuevo.');
          return $this->response;
        }

        $tokens = new Tokens();
        $data = array('compania' => $compania, 'usuario' => $usuario, 'clave' => $clave);


    });
});
