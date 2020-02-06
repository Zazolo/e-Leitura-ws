<?php

namespace Actions;

use Slim\Http\Request;
use Slim\Http\Response;

use Responder\GetUserResponder;
class GetUserAction extends ActionsImplementation implements ActionClass
{
    public function __invoke(Request $request, Response $response, array $args)
    {   
        $responder = new GetUserResponder($response, $this->service->getUser($request, $args)->ver());
        return $responder->resolve();
    }
}
