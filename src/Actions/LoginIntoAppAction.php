<?php

namespace Actions;

/**
 * Description of LoginIntoAppAction
 *
 * @author tiago
 */
class LoginIntoAppAction extends ActionsImplementation implements ActionClass
{
    
    public function __invoke(\Slim\Http\Request $request, \Slim\Http\Response $response, array $args)
    {
        $responder = new \Responder\LoginIntoAppResponder($response, $this->service->getUser($request, $args)->logar());
        return $responder->resolve();
    }

}
