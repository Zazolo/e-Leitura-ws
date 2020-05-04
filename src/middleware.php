<?php

use Slim\App;

return function (App $app) {
    $app->add(new Tuupola\Middleware\CorsMiddleware([
            "origin" => ["*"],
            "methods" => ["GET", "POST", "PATCH", "DELETE", "PUT", "OPTIONS"],
            "headers.allow" => ["Origin", "Content-Type", "authentication", "Accept", "ignoreLoadingBar", "X-Requested-With", "Access-Control-Allow-Origin"],
            "headers.expose" => [],
            "credentials" => false,
            "cache" => 0,
	]));
    // e.g: $app->add(new \Slim\Csrf\Guard);
    $app->add(new \Tuupola\Middleware\JwtAuthentication([
        "path" => ["/perfil", "/atividade", "/postagem"], /* or ["/api", "/admin"] */
        "attribute" => "decoded_token_data",
        "secret" => JWT_SECRET,
        "header" => "authentication",
        "algorithm" => ["HS256"],
    	"secure" => false,
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response
            ->withHeader("Content-Type", "text/plain")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]));
};
