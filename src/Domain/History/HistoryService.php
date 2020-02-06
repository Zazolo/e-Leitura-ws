<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Domain\History;

/**
 * Description of HistoryService
 *
 * @author tiago
 */
use Domain\Services;
use Domain\History\HistoryRepository;
class HistoryService extends Services
{
    
    public function obterDisponiveis()
    {
        return $this->repository->getAllAvailable();
    }
    
    public function ver()
    {
        if(isset($this->args['id']) && ($this->requester != null)){
            return $this->repository->getIt($this->args['id'], $this->requester->id);
        }
        return null;
    }
    
    public function criar()
    {
        $mustContain = ['titulo', 'tempo_ciclo', 'max_ciclos', 'senha', 'usuario_id'];
        
        if($this->requester == null){
            throw new \Exception("Não é possível criar sem autorização do JWT.");
        }
        
        $criador = $this->requester->id;
        
        $params = $this->request->getParsedBody();
        
        foreach ($params as $key => $value) {
            if(in_array($key, $mustContain)){
                $value = trim($value);
                if(is_numeric($value)){
                    $params[$key] = (int)$value;
                }
            } else {
                unset($params[$key]);
            }
        }
        
        $params['usuario_id'] = $criador;
        
        if(count($params) != count($mustContain)){
            var_dump($params);
            throw new \Exception("Quantidade de parâmetros inválida para criação da história");
        }
        
        if(!is_int($params['tempo_ciclo']) || $params['tempo_ciclo'] < 1){
            var_dump($params);
            throw new \Exception("Tempo de ciclo inferior a 1 minuto.");
        }

        if(!is_int($params['max_ciclos']) || $params['max_ciclos'] < 1){
            var_dump($params);
            throw new \Exception("Quantidade de ciclos é inferior a 1.");
        }
        
        $params['ciclo_atual'] = 1;
        
        return $this->repository->create($params);
        
    }
    
    public function remover()
    {
        if(isset($this->args['id']) && $this->requester != null){
            $idToDelete = $this->args['id'];
            $idRequester = $this->requester->id;
            $historia = $this->repository->getIt($this->args['id'], $this->requester->id);
            if($historia != null){
                if($historia['usuario_id']['id'] == $this->requester->id){
                    return $this->repository->delete($idToDelete);    
                } 
            }
                
        }
        return null;
    }
    
    public function finalizar()
    {
        
    }
    
    public function rank()
    {
        
    }
    
    public function __construct(\Slim\Http\Request $request, array $routeArgs)
    {
        parent::__construct($request, $routeArgs, new HistoryRepository());
    }
}
