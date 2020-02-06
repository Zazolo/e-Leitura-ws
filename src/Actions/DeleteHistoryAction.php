<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 * Description of DeleteHistoryAction
 *
 * @author tiago
 */
use Slim\Http\Request;
use Slim\Http\Response;
class DeleteHistoryAction extends ActionsImplementation
{
    public function __invoke(Request $request, Response $response, array $args)
    {   
        $responder = new \Responder\DeleteHistoryResponder($response, $this->service->getHistory($request, $args)->remover());
        return $responder->resolve();
    }
}
