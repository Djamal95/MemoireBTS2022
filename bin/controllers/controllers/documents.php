<?php
namespace Epaphrodites\controllers\controllers;
        
use Epaphrodites\controllers\switchers\MainSwitchers;
        
final class documents extends MainSwitchers
{
    private object $msg;
    private object $insert;
    private object $update;
    private object $delete;
    private object $select;
    private object $env;
    private string $alert = "";
    private string $ans = "";
    /**
    * Initialize object properties when an instance is created
    * @return void
    */    
    public final function __construct() 
    {
        $this->initializeObjects();
    }

    /**
    * Initialize each property using values retrieved from static configurations
    * @return void
    */
    private function initializeObjects(): void
    {
        $this->msg = $this->getFunctionObject(static::initNamespace(), 'msg');
        $this->insert = $this->getFunctionObject(static::initQuery(), 'insert');
        $this->select = $this->getFunctionObject(static::initQuery(), 'select');
        $this->update = $this->getFunctionObject(static::initQuery(), 'update');
        $this->delete = $this->getFunctionObject(static::initQuery(), 'delete');
        $this->env = $this->getFunctionObject(static::initNamespace(), 'env');
    }

    /**
    * start view function
    * @param string $html
    * @return void
    */
    public final function addDocuments(string $html): void{
    
        if(static::isValidMethod(true) && static::arrayNoEmpty(['__libelle__'])){
            
            $source = static::getFileName('ressource');
            $result = $this->insert->addRessources(
                static::getPost('__libelle__'),
                $source
            );
            if($result){
                $this->env->uploadFiles([_DIR_MEDIA_ => 'ressource']);
                $this->alert = "alert-success";
                $this->ans = $this->msg->answers("succes");
            }else{
                $this->alert = "alert-danger";
                $this->ans = $this->msg->answers("error");
            }
        }

        $this->views( $html, [
            'reponse'=>$this->ans,
            'alert' => $this->alert
        ], true );
    }

     /**
    * start view function
    * @param string $html
    * @return void
    */
    public final function showDocuments(string $html): void{
        $idDoc = static::isGet('_ressource','int')? static::getGet('_ressource'): 0;
        $ressource = $this->select->findRessourceById($idDoc);
        $this->views( $html, [
            'ressource' => $ressource
        ], true );
    }

    /**
    * start view function
    * @param string $html
    * @return void
    */
    public final function listOfDocuments(string $html): void{
    
        if(static::isValidMethod(true)){
            if(static::isSelected('_sendselected_',1)){
                foreach(static::isArray('ressources') as $idressource){
                    $result = $this->delete->deleteRessource($idressource);
                }
                if($result == true){
                    $this->alert = "alert-success";
                    $this->ans = $this->msg->answers("succes");
                }
            }
        }
        $ressources = $this->select->listOfRessources();
        
        $this->views( $html, [
            'ressource' =>$ressources,
            'alert'=>$this->alert,
            'reponse' => $this->ans
        ], true );
    }

    /**
    * start view function
    * 
    * @param string $html
    * @return void
    */
     public final function updateDocuments(string $html): void{
    
        $this->views( $html, [], true );
    }
}