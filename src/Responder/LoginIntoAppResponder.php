<?php

namespace Responder;

/**
 * Description of LoginIntoAppResponder
 *
 * @author tiago
 */
class LoginIntoAppResponder extends ResponderImplementation
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
