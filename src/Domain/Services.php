<?php

namespace Domain;

/**
 * Description of Services
 *
 * @author tiago
 */

use Slim\Http\Request;
use Domain\AppDomainJWT;
abstract class Services
{
    protected $request;
    protected $repository;
    protected $requester;
    protected $jwt;
    protected $args;

    public function __construct(Request $request, array $routeArgs, RepositoryOrientation $repository)
    {
        $this->request = $request;
        $this->args = $routeArgs;
        $this->repository = $repository;
        $this->jwt = AppDomainJWT::getInstance();
        $this->requester = $this->jwt->getTokenOBJ($this->request);
    }
    
}
