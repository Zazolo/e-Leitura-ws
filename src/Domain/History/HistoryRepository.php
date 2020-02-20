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
        $historia['dthr_criacao'] = date('Y-m-d h:i:s', time());
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
        $historias = R::findAll('historia');
        
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
    
    public function finalize($history_id)
    {
        $hbean = R::findOne('historia', 'id = ?', [$history_id]);
        if($hbean != null) {
            $hbean['finalizada'] = 1;
            return R::store($hbean);
        }
        return null;
    }
    
    public function rank($history_id)
    {
        $bean = R::getAssocRow("select u.id, u.nome, u.login, COUNT(u.id) as total FROM eleitura.usuario u RIGHT JOIN eleitura.paragrafo p ON p.usuario_id = u.id WHERE p.historia_id = ? AND ganhador = 1 group by p.usuario_id order by total DESC;", [$history_id]);
        if($bean){
            return $bean;
        }
        return null;
    }
    
    public function runcicle()
    {
        $historias = R::findAll('historia', 'finalizada = false');
        
        if($historias != null){
            $total = count($historias);
            foreach ($historias as $lista => $historia) {
            
                $ciclo = $historia['ciclo_atual'];
                $data_historia = \DateTime::createFromFormat('Y-m-d h:i:s', $historia['dthr_criacao']);
                $dt_atual = \DateTime::createFromFormat('Y-m-d h:i:s', date('Y-m-d h:i:s', time()));
                if(isset($historia['dthr_ultima_checagem']) && $historia['dthr_ultima_checagem'] != null){
                    $data_checagem = \DateTime::createFromFormat('Y-m-d h:i:s', $historia['dthr_ultima_checagem']);
                    //$data_checagem = $data_checagem->format('d/m/Y h:i:s');
                } else {
                    $data_checagem = $dt_atual;
                }
               
                $diferenca = $this->s_datediff("i", $data_checagem, $dt_atual);
                //print_r($data_checagem);
                //print_r($dt_atual);
                //var_dump("DIFERENÇA -> ".$diferenca);
                //var_dump("TEMPO_CICLO ->".$historia['tempo_ciclo']);
                if($diferenca != $historia['tempo_ciclo']){
                    //avança ciclo
                    $ciclo++;
                    $paragrafos = R::getAssocRow("select uvt.paragrafo, p.usuario_id, COUNT(uvt.id) as votos from eleitura.paragrafo as p RIGHT JOIN eleitura.usuariovtparagrafo as uvt ON uvt.paragrafo = p.id where p.historia_id = ? group by paragrafo;", [$historia->id]);
                    if($paragrafos != null){
                        foreach ($paragrafos as $chave => $paragrafo) {
                            $idP = $paragrafo['paragrafo'];
                            $p = R::findOne('paragrafo', 'id = ?', [$idP]);
                            $idUsu = $paragrafo['usuario_id'];
                            $up = R::findOne('usuario', 'id = ?', [$idUsu]);
                            if($up != null){
                                $up->pontos = $up['pontos'] + 1;
                                R::store($up);
                            }
                            $p['ganhador'] = 1;
                            R::store($p);
                            
                        }
                        
                    }
                    
                }
                
                $bh = R::load('historia', $historia['id']);
                $bh->dthr_ultima_checagem = $dt_atual;
                $bh->ciclo_atual = $ciclo;
                
                
                if($bh->ciclo_atual == $bh->max_ciclos){
                    $bh->finalizada = 1;
                }
                
                R::store($bh);
                
                
            }
            
        }
        
    }
    
    private function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){

       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
       if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);
       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
       return $diff->format("%i");
       //var_dump($diff);
   }

    
    
}
