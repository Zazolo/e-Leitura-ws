<?php

namespace Responder;

use Slim\Http\Response;
use Responder\ResponderInterface;
abstract class ResponderImplementation implements ResponderInterface
{
    private $data;
    private $statusCode;
    private $response;
    
    private function setStatus(bool $status = null)
    {
        try
        {
            $status = $this->getStatus($status);
            
            if($status == null){
                throw new \Exception("Status não informado para saída.");
            } else {
                $this->statusCode = $status;
            }
        } catch (\Exception $e)
        {
            throw new \Exception("Erro ao processar o status de saída.", 1);
        }
    }

    private function setData($data = null)
    {
        try
        {
            /*
             * Posso adicionar um validateData aqui caso seja necessário no futuro
             */
            if($data == null){
                $this->data = [];
                $this->setStatus(false);
            } else {
                if(!is_array($data)){
                    $data = ["response" => $data];
                }
                $this->data = $data;
                $this->setStatus(true);
            }
        } catch (\Exception $e)
        {
            throw new \Exception("Erro ao processar os dados de saída.", 1);
        }
    }

    public function resolve(): Response
    {
        return $this->response->withJson($this->data, $this->statusCode);
    }
    
    public function __construct(Response $response, $data = null)
    {
        $this->setData($data);
        $this->response = $response;
    }
    
}

