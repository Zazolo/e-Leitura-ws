<?php

namespace Domain\User;
/**
 * Description of UserService
 *
 * @author tiago
 */

use Slim\Http\Request;
use Domain\Services;
use Domain\User\UserRepository;
class UserService extends Services
{
    public function ver()
    {
        if(isset($this->args['id'])){
            $idToSee = $this->args['id'];
            return $this->repository->read($idToSee);
        }
        return null;
    }
    
    public function criar()
    {
        $mustContain = ['nome', 'login', 'senha'];
        
        $params = $this->request->getParsedBody();
        
        foreach ($params as $key => $value) {
            if(in_array($key, $mustContain)){
                $value = trim($value);
                if(strlen($value) < 3){
                    return null;
                }
            } else {
                unset($params[$key]);
            }
        }
        
        if(count($params) != count($mustContain)){
            var_dump($params);
            throw new \Exception("Quantidade de parâmetros inválida para criação do usuário");
            return null;
        }
        
        $finded = $this->repository->read($params['login']);
        
        if($finded != null) {
            throw new \Exception("Login já foi cadastrado!");
            return null;
        }
        
        return $this->repository->create($params);
    }
    
    public function remover()
    {
        if(isset($this->args['id']) && $this->requester != null){
            $idToDelete = $this->args['id'];
            $idRequester = $this->requester->id;
            if($idRequester == $idToDelete){
                return $this->repository->delete($idToDelete);
            }
        }
        return null;
    }
    
    public function logar()
    {
        $mustContain = ['login', 'senha'];
        
        $params = $this->request->getParsedBody();
        
        foreach ($params as $key => $value) {
            if(in_array($key, $mustContain)){
                $param[$key] = trim($value);
                if(strlen($value) < 3){
                    return null;
                }
            } else {
                unset($params[$key]);
            }
        }
        
        if(count($params) != count($mustContain)){
            throw new \Exception("Quantidade de parâmetros inválida para login do usuário");
            return null;
        }
        
        $logado = $this->repository->findByLoginPWD($params['login'], $params['senha']);
        if($logado != null){
            return $this->jwt->generateToken($logado['id'], $logado['login']);
        }
        
        return null;
    }

    public function __construct(Request $request, array $routeArgs)
    {
        parent::__construct($request, $routeArgs, new UserRepository());
    }
}
