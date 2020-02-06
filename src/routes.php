<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Actions\CreateLoginAction;
use Actions\GetUserAction;
use Actions\DeleteUserAction;
use Actions\DeleteHistoryAction;
use Actions\LoginIntoAppAction;
use Actions\GetHistoryAction;
use Actions\CreateHistoryAction;
use Actions\CreateParagraphAction;
use Actions\DeleteParagraphAction;
use Actions\FinalizeHistoryAction;
use Actions\RankHistoryAction;
use Actions\GetParagraphAction;
return function (App $app) {
    $container = $app->getContainer();
    
    ///Usuario
    $app->post('/usuario/', CreateLoginAction::class);
    $app->get('/usuario/{id:[0-9]+}', GetUserAction::class);
    $app->delete('/usuario/{id:[0-9]+}', DeleteUserAction::class);
    $app->post('/autenticar/', LoginIntoAppAction::class);
    
    
    ///Historia
    $app->post('/history/', CreateHistoryAction::class);
    $app->delete('/history/{id:[0-9]+}', DeleteHistoryAction::class);
    $app->get('/history/{id:[0-9]+}', GetHistoryAction::class);///--->>
    
    
    //Paragrafo
    $app->post('/paragrafo/', CreateParagraphAction::class);
    $app->delete('/paragrafo/{id:[0-9]+}', DeleteParagraphAction::class);
    $app->get('/paragrafo/{id:[0-9]+}', GetParagraphAction::class);///-->
    /*
     * Lembrar de fazer o script para rodar no crontab varrendo todas as hisotórias
     * e verificando quais estão aptas a avançarem de ciclo;
     */

};
