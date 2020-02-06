<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Responder;

/**
 * Description of DeleteUserResponder
 *
 * @author tiago
 */
class DeleteUserResponder extends ResponderImplementation
{

    public function getStatus(bool $status): int
    {
        return $status?200:403;
    }

}
