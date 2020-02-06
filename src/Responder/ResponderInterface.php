<?php

namespace Responder;

interface ResponderInterface
{
    public function getStatus(bool $status): int;
}