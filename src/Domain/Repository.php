<?php

namespace Domain;

/**
 * Description of Repository
 *
 * @author tiago
 */
use RedBeanPHP\Facade as R;
abstract class Repository implements RepositoryOrientation
{
    public function __construct()
    {
       
        if(!R::testConnection()){
            $file = 'repositoryConfiguration.ini';

            if (!$settings = parse_ini_file($file, TRUE)) {
                throw new exception('Unable to open ' . $file . '.');
            }

            $config = $settings['database']['driver'] . ':host=' . $settings['database']['host'] . ';dbname=' . $settings['database']['schema'];

            R::setup( $config , $settings['database']['username'], $settings['database']['password'] );
            R::freeze(true);
        }
    }
}
