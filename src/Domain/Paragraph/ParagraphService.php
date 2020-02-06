<?php

namespace Domain\Paragraph;

/**
 * Description of ParagraphService
 *
 * @author tiago
 */
class ParagraphService extends \Domain\Services
{
    public function criar()
    {
        $mustContain = ['texto', 'ciclo', 'usuario_id', 'historia_id'];
        
        $params = $this->request->getParsedBody();
        
        if($this->requester == null){
            throw new \Exception("Erro ao tentar criar o paragrafo, aparentemente a função foi chamada sem usuário ativo logado.");
        }
        
        $historyRep = new \Domain\History\HistoryRepository();
        
        $historia = $historyRep->getIt($params['historia_id'], $this->requester->id);
        if($historia == null){
            throw new \Exception("Erro ao tentar criar o paragrafo, aparentemente não foi possível carregar a história.");
        }
        
        $params['ciclo'] = $historia['ciclo_atual'];
        $params['usuario_id'] = $this->requester->id;
       
        
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
        
        if(count($params) != count($mustContain)){
            var_dump($params);
            throw new \Exception("Quantidade de parâmetros inválida para criação do paragrafo");
            return null;
        }

        
        
        if($historia != null){
            
            return $this->repository->create($params);
            
        }
        
        return null;
        
    }
    
    public function remover()
    {
        if(isset($this->args['id']) && $this->requester != null){
            $idToDelete = $this->args['id'];
            $idRequester = $this->requester->id;
            
            $paragraph = $this->repository->get($idToDelete);

            if($paragraph != null){
                return $this->repository->remove($idToDelete);
            }
            
            return null;
        }
    }
    
    public function votar()
    {
        if(isset($this->args['id']) && $this->requester != null){
            $idToDelete = $this->args['id'];
            $idRequester = $this->requester->id;
            
            $paragraph = $this->repository->read($idToDelete);

            if($paragraph != null){
                return $this->repository->vote($idToDelete, $idRequester);
            }
            
            return null;
        }
    }
    
    public function __construct(\Slim\Http\Request $request, array $routeArgs)
    {
        parent::__construct($request, $routeArgs, new ParagraphRepository());
    }
}
