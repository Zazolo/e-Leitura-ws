<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 * Description of ActionsImplementation
 *
 * @author tiago
 */

use Domain\eLeituraService;

abstract class ActionsImplementation
{
    protected $service;
    protected $responder;
    
    public function __construct()
    {
        $this->service = eLeituraService::getInstance();
    }
}
