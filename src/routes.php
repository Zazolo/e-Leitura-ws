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
use Actions\VoteInParagraphAction;
use Actions\GetParagraphAction;
use Actions\RunCicleHistoryAction;
return function (App $app) {
    $container = $app->getContainer();
    
    ///Usuario
    $app->post('/autenticar/novo/', CreateLoginAction::class);
    $app->get('/usuario/{id:[0-9]+}', GetUserAction::class);
    $app->delete('/usuario/{id:[0-9]+}', DeleteUserAction::class);
    $app->post('/autenticar/', LoginIntoAppAction::class);
    
    
    ///Historia
    $app->post('/historia/', CreateHistoryAction::class);
    $app->delete('/historia/{id:[0-9]+}', DeleteHistoryAction::class);
    $app->post('/historia/{id:[0-9]+}', GetHistoryAction::class);///--->>
    $app->get('/historia/all/', Actions\GetHistoryAvailableAction::class);///--->>
    $app->put('/historia/{id:[0-9]+}/finalize/', FinalizeHistoryAction::class);///--->>
    $app->get('/historia/{id:[0-9]+}/rank/', RankHistoryAction::class);///--->>
    
    //Paragrafo
    $app->post('/paragrafo/', CreateParagraphAction::class);
    $app->delete('/paragrafo/{id:[0-9]+}', DeleteParagraphAction::class);
    $app->put('/paragrafo/{id:[0-9]+}/votar/', VoteInParagraphAction::class);
    $app->get('/paragrafo/{id:[0-9]+}', GetParagraphAction::class);///-->
    
    $app->get('/runcicle/', RunCicleHistoryAction::class);///-->

};
