<?php

namespace Epaphrodites\controllers\controllers;

use Epaphrodites\controllers\switchers\MainSwitchers;

final class main extends MainSwitchers
{

    private string $ans = '';
    private string $alert = '';
    private $result;

    /**
     * Index page
     * @param string $html
     * @return void
     */
    public final function index(
        string $html
    ): void {
        $this->views($html, []);
    }

    /**
     * Authentification page ( login )
     * 
     * @param string $html
     * @return void
     */
    public final function login(
        string $html
    ): void {

        if (static::isValidMethod()) {

            $this->result = static::initConfig()['auth']->usersAuthManagers(
                static::getPost('__login__'),
                static::getPost('__password__')
            );
            [$this->ans, $this->alert] = static::Responses($this->result, [false => ['error', 'login-wrong']]);
            
        }
        
        $this->views(
            $html,
            [
                'student' => $this->result,
                'class' => $this->alert,
                'reponse' => $this->ans
            ]
        );
    }

    /**
    * start view function
    * 
    * @param string $html
    * @return void
    */
     public final function program(string $html): void{
    
        $this->views( $html, [], false );
    }
}