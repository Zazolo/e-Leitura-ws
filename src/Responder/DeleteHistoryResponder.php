<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Responder;

/**
 * Description of DeleteHistoryResponder
 *
 * @author tiago
 */
class DeleteHistoryResponder extends ResponderImplementation
{
    public function __construct(\Slim\Http\Response $response, $data = null)
    {
        parent::__construct($response, $data);
    }
    
    public function getStatus(bool $status): int
    {
        return $status?200:403;
    }
}