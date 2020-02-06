<?php

namespace Domain\History;

/**
 * Description of HistoryRepository
 *
 * @author tiago
 */
use Domain\Repository;
use RedBeanPHP\Facade as R;
class HistoryRepository extends \Domain\Repository
{
    public function create(array $properties)
    {
        $historia = R::dispense('historia');
        foreach ($properties as $key => $value) {
            $historia[$key] = $value;
        }
        
        $historia['ciclo_atual'] = 0;
        $historia['finalizada'] = 0;
        $historia['dthr_criacao'] = date('m/d/Y h:i:s', time());
        if(strlen($historia['senha']) < 5) {
            $historia['senha'] = null;
        }
        return R::store($historia);
    }
    
    public function delete(int $id)
    {
        $historia = R::findOne('historia', 'id = ?', [$id]);
        if($historia == null){
            return false;
        }
        R::trash($historia);
        return true;
        
    }
    
    public function getIt(int $history_id, int $requester_id)
    {
        $historia = R::findOne('historia', 'id = ?', [$history_id]);
        
        $paragraphRepo = new \Domain\Paragraph\ParagraphRepository();
        
        if($historia != null){
            $historia_exported = $historia->export();
            $userRepo = new \Domain\User\UserRepository();
            $historia_exported['usuario_id'] = $userRepo->readMini($historia_exported['usuario_id']);
            $historia_exported['paragrafos'] = $paragraphRepo->getAllForHistory($history_id, $requester_id);
            return $historia_exported;
        }
        return null;
    }
    
    public function getAllAvailable()
    {
        $historias = R::findAll('historia', 'finalizada = ?', [false]);
        
        $output = [];
        
        $userRepo = new \Domain\User\UserRepository();
        
        if($historias != null){
            
            $i = 0;
            
            foreach ($historias as $key => $value) {
            
                $output[$i] = $value->export();
                $output[$i]['usuario_id'] = $userRepo->readMini($output[$i]['usuario_id']);
                $i++;
                
            }
            
        }
            
        return $output;
            
    }
    
    
}
