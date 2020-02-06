<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Actions;

/**
 *
 * @author tiago
 */
use Slim\Http\Request;
use Slim\Http\Response;

interface ActionClass
{
    public function __invoke(Request $request, Response $response, array $args);
}
