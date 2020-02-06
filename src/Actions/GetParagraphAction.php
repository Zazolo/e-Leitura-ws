<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 * Description of GetParagraphAction
 *
 * @author tiago
 */

use Responder\GetParagraphResponder;

class GetParagraphAction extends ActionsImplementation implements ActionClass
{
    
    public function __invoke(\Slim\Http\Request $request, \Slim\Http\Response $response, array $args)
    {
        $responder = new GetParagraphResponder($response, $this->service->getParagraph($request, $args)->ver());
        return $responder->resolve();
    }

}
