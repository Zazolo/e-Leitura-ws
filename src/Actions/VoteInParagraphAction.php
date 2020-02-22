<?php

namespace Actions;

/**
 * Description of VoteInParagraphAction
 *
 * @author tiago
 */
use Responder\VoteInParagraphResponder;
use Slim\Http\Response;
use Slim\Http\Request;
class VoteInParagraphAction extends ActionsImplementation implements ActionClass
{
    public function __invoke(Request $request, Response $response, array $args)
    {   
        $responder = new VoteInParagraphResponder($response, $this->service->getParagraph($request, $args)->votar());
        return $responder->resolve();
    }
}
