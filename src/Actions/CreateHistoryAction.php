<?php

namespace Actions;

/**
 * Description of CreateHistoryAction
 *
 * @author tiago
 */

use Slim\Http\Request;
use Slim\Http\Response;
class CreateHistoryAction extends ActionsImplementation
{
    public function __invoke(Request $request, Response $response, array $args)
    {   
        $responder = new \Responder\CreateHistoryResponder($response, $this->service->getHistory($request, $args)->criar());
        return $responder->resolve();
    }
}
