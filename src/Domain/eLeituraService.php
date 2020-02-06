<?php

namespace Domain;

/**
 * Factory class para todos os serviços do domínio.
 *
 * @author tiago
 */
use Domain\User\UserService;
use Domain\History\HistoryService;
use Domain\Paragraph\ParagraphService;
use Slim\Http\Request;
class eLeituraService
{
    private static $instance;
    
    private function __construct()
    {
    }
    
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getUser(Request $request, array $routeArgs): UserService
    {
        return new UserService($request, $routeArgs);
    }
    
    public function getHistory(Request $request, array $routeArgs): HistoryService
    {
        return new HistoryService($request, $routeArgs);
    }
    
    public function getParagraph(Request $request, array $routeArgs): ParagraphService
    {
        return new ParagraphService($request, $routeArgs);
    }
}
