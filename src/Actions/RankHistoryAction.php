<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 * Description of RankHistoryAction
 *
 * @author tiago
 */
use Slim\Http\Request;
use Slim\Http\Response;
class RankHistoryAction extends ActionsImplementation implements ActionClass
{
    public function __invoke(Request $request, Response $response, array $args)
    {   
        $responder = new \Responder\FinalizeHistoryResponder($response, $this->service->getHistory($request, $args)->rank());
        return $responder->resolve();
    }
}