<?php
use App\Model\CiaModel;

$app->group('/cia/', function () {

    $this->get('companias/[{compania}]', function ($req, $res, $args) {
        $compania = isset($args["compania"]) ? $args["compania"] : "";
        $model = new CiaModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
                json_encode(
                    $model->Get($compania)
                )
            );
    });
});
