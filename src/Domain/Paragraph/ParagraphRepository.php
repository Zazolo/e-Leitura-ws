<?php

namespace Domain\Paragraph;

/**
 * Description of ParagraphRepository
 *
 * @author tiago
 */
use Domain\Repository;
use RedBeanPHP\Facade as R;
class ParagraphRepository extends Repository
{
    public function create(array $properties):?int
    {
        $paragraph = R::dispense('paragrafo');
        foreach ($properties as $key => $value) {
            $paragraph[$key] = $value;
        }
        return R::store($paragraph);
    }
    
    public function get(int $id)
    {
        $usuario = R::findOne('paragrafo', 'id = ?', [$id]);
        if($usuario == null){
            return null;
        }
        $usuario = $usuario->export();
        $userRepo = new \Domain\User\UserRepository();
        $usuario['usuario_id'] = $userRepo->readMini($usuario['usuario_id']);
        
        return $usuario;
    }
    
    public function remove(int $id):?bool
    {
        $paragrafo = R::findOne('paragrafo', 'id = ?', [$id]);
        if($paragrafo == null){
            return false;
        }
        
        return R::trash($paragrafo);
    }
    
    public function vote(int $paragraph_id, int $user_id):?bool
    {
        $vote = R::findOne('usuario_vota_paragrafo', 'usuario_id = ? AND paragrafo_id = ?', [$user_id, $paragraph_id]);
        
        if($vote == null){
            
            $new_vote = R::dispense('usuario_possui_paragrafo');
            $new_vote['usuario_id'] = $user_id;
            $new_vote['paragrafo_id'] = $paragraph_id;
            
            return R::store($new_vote);
            
        }
        
        return null;
        
    }
    
    /**
     * Retorna todos os paragrafos mais votados para determinada historia
     * @param int $history_id
     */
    public function getAllForHistory(int $history_id, int $requester_id = null):?array
    {
        $paragrafos = R::findAll('paragrafo', 'historia_id = ?', [$history_id]);
        $paragrafos_size = count($paragrafos);
        $outputParagrafos = [];
        
        $userRepo = new \Domain\User\UserRepository();
        
        
        $i = 0;
        foreach ($paragrafos as $paraPos => $paragrafo) {
            
            $outputParagrafos[$i] = $paragrafo->export();

            $outputParagrafos[$i]['usuario_id'] = $userRepo->readMini($outputParagrafos[$i]['usuario_id']);

            if($requester_id != null){
                $outputParagrafos[$i]['votou'] = $this->UserHasVoted($outputParagrafos[$i]['id'], $history_id);
            }

            $i++;
        }
        
        return $outputParagrafos;
        
    }
    
    private function UserHasVoted(int $paragraph_id, int $user_id)
    {
        $vote = R::findOne('usuario_vota_paragrafo', 'paragrafo_id = ? AND usuario_id = ?', [$paragraph_id, $user_id]);
        if($vote != null){
            return true;
        }
        return false;
    }
}
