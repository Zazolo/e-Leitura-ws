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
        $paragrafo = R::findOne('paragrafo', 'id = ?', [$id]);

        if($paragrafo == null){
            return null;
        }
        $paragrafo = $paragrafo->export();
        $userRepo = new \Domain\User\UserRepository();
        $paragrafo['usuario_id'] = $userRepo->readMini((int)$paragrafo['usuario_id']);
        
        return $paragrafo;
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
        $vote = R::findOne('usuariovtparagrafo', 'usuario = ? AND paragrafo = ?', [$user_id, $paragraph_id]);
        
        if($vote == null){
            
            $newvote = R::dispense('usuariovtparagrafo');
            
            $newvote->import(['usuario' => $user_id, 'paragrafo' => $paragraph_id]);
            

            return R::store($newvote);
            
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

        $outputParagrafos = [];
        
        $userRepo = new \Domain\User\UserRepository();
        
        
        $i = 0;
        foreach ($paragrafos as $paraPos => $paragrafo) {
            
            $outputParagrafos[$i] = $paragrafo->export();

            $outputParagrafos[$i]['usuario_id'] = $userRepo->readMini($outputParagrafos[$i]['usuario_id']);

            if($requester_id != null){
                $outputParagrafos[$i]['votou'] = $this->UserHasVoted($outputParagrafos[$i]['id'], $requester_id);
            }

            $i++;
        }
        
        return $outputParagrafos;
        
    }
    
    private function UserHasVoted(int $paragraph_id, int $user_id)
    {
        $vote = R::findOne('usuariovtparagrafo', 'paragrafo = ? AND usuario = ?', [$paragraph_id, $user_id]);
        if($vote != null){
            return true;
        }
        return false;
    }
}
