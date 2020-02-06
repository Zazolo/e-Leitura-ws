<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 * Description of DeleteUserAction
 *
 * @author tiago
 */

class DeleteUserAction extends ActionsImplementation implements ActionClass
{
    
    public function __invoke(\Slim\Http\Request $request, \Slim\Http\Response $response, array $args)
    {
        $responder = new \Responder\DeleteUserResponder($response, $this->service->getUser($request, $args)->remover());
        return $responder->resolve();
    }

}
