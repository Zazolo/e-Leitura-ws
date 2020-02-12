<?php

namespace Domain\User;


/**
 * Description of UserRepository
 *
 * @author tiago
 */
use Domain\Repository;
use RedBeanPHP\Facade as R;
class UserRepository extends Repository
{
    
    public function create(array $properties):?int
    {
        $usuario = R::dispense('usuario');
        foreach ($properties as $key => $value) {
            $usuario[$key] = $value;
        }
        $usuario['ativado'] = true;
        return R::store($usuario);
    }

    public function delete(int $id):?bool
    {
        $usuario = R::findOne('usuario', 'id = ?', [$id]);
        if($usuario == null){
            return false;
        }
        $usuario['ativado'] = false;
        return R::store($usuario);
    }
    
    public function findByLoginPWD(string $login, string $password):?array
    {
        $usuario = R::findOne('usuario', 'login = ? AND senha = ? AND ativado = 1', [$login, $password]);
        if($usuario == null){
            return null;
        }
        $usuario = $usuario->export();
        unset($usuario['senha']);
        return $usuario;
    }
    
    public function read(int $id)
    {
        $usuario = R::findOne('usuario', 'id = ?', [$id]);
        if($usuario == null){
            return null;
        }
        $usuario = $usuario->export();
        unset($usuario['senha']);
        unset($usuario['ativado']);
        
        /**
         * futuramente colocar pra carregar todas as historias_mini que o usu
         * ario possuir.
         */
        return $usuario;
    }
    
    public function readByLogin(string $login){
        $usuario = R::findOne('usuario', 'login = ?', [$login]);
        if($usuario == null){
            return null;
        }
        $usuario = $usuario->export();
        unset($usuario['senha']);
        unset($usuario['ativado']);
        
        /**
         * futuramente colocar pra carregar todas as historias_mini que o usu
         * ario possuir.
         */
        return $usuario;
    }
    
    public function readMini(int $id)
    {
        if(is_numeric($id)){
            $id = (int)$id;
        }
        
        $usuario = R::findOne('usuario', 'id = ?', [$id]);
        if($usuario == null){
            return null;
        }
        $usuario = $usuario->export();
        unset($usuario['senha']);
        unset($usuario['ativado']);
        return $usuario;
    }

}
