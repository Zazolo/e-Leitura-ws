<?php

namespace Domain;

use \Slim\Http\Request;
use \Firebase\JWT\JWT;

class AppDomainJWT {
    
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new AppDomainJWT();
        }
        return self::$instance;
    }
    
    private function __construct() { }
    
    public function getTokenOBJ(Request $request): ?\stdClass{
        try{
            if(isset($request->getHeaders()['HTTP_AUTHENTICATION'])){
                if(is_string($request->getHeaders()['HTTP_AUTHENTICATION'][0])){
                    $token = $request->getHeaders()['HTTP_AUTHENTICATION'][0];
                    $jwt = str_replace('Bearer ', '', $token);
                    $decoded = JWT::decode($jwt, JWT_SECRET, ['HS256']);
                    return $decoded;
                }
            }
            return null;
        } catch(Exception $e){
            throw new RuntimeException("Erro ao decodificar o token!\nOperacoes canceladas.".$e);
        }
    }
    
    public function generateToken(int $id, string $login):string{
        return JWT::encode(['id' => $id, 'login' => $login], JWT_SECRET, "HS256");
    }
    
    
}