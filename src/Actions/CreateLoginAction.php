<?php

namespace Actions;

use Slim\Http\Request;
use Slim\Http\Response;

use Responder\CreateLoginResponder;
class CreateLoginAction extends ActionsImplementation implements ActionClass
{
    public function __invoke(Request $request, Response $response, array $args)
    {   
        $responder = new CreateLoginResponder($response, $this->service->getUser($request, $args)->criar());
        return $responder->resolve();
    }
}
