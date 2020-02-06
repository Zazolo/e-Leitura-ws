<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 * Description of GetHistoryAction
 *
 * @author tiago
 */
use Slim\Http\Response;
use Slim\Http\Request;

use Responder\GetHistoryResponder;
class GetHistoryAction extends ActionsImplementation implements ActionClass
{
    
    public function __invoke(Request $request, Response $response, array $args)
    {
        $responder = new GetHistoryResponder($response, $this->service->getHistory($request, $args)->ver());
        return $responder->resolve();
    }

}
