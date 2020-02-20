<?php


namespace Responder;

/**
 * Description of RankHistoryResponder
 *
 * @author tiago
 */
class RankHistoryResponder extends ResponderImplementation
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
