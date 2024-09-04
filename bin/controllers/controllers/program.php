<?php

namespace Epaphrodites\controllers\controllers;

use Epaphrodites\controllers\switchers\MainSwitchers;

final class program extends MainSwitchers
{
    private object $msg;
    private object $insert;
    private object $select;
    private object $update;
    private object $delete;
    private object $env;
    private string $alert = '';
    private string $ans = '';

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
     * Start exemple page
     * @param string $html
     * @return void
     */
    public final function exemplePages(string $html): void
    {
        $this->views($html, [], false);
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function showProgram(string $html): void
    {

        $idDoc = static::isGet('_program', 'int') ? static::getGet('_program') : 0;
        $program = $this->select->findProgramById($idDoc);
        $this->views($html, [
            'program' => $program
        ], true);
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function updateProgram(string $html): void
    {

        $this->views($html, [], true);
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function addProgram(string $html): void
    {
        if (static::isValidMethod(true) && static::arrayNoEmpty(['__libelle__']) && static::arrayNoEmpty(['__date__'])) {

            $source = static::getFileName('program');
            $result = $this->insert->addProgram(
                static::getPost('__libelle__'),
                static::getPost('__date__'),
                $source
            );
            if ($result) {
                $this->env->uploadFiles([_DIR_PROG_ => 'program']);
                $this->alert = "alert-success";
                $this->ans = $this->msg->answers("succes");
            }else{
                $this->alert = "alert-danger";
                $this->ans = $this->msg->answers("error");
            }
        }
        $this->views($html, [
            'alert' => $this->alert,
            'answers' => $this->ans
        ], true);
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function allProgram(string $html): void
    {

        $program = $this->select->listOfProgram();

        $this->views($html, [
            'program' => $program,
            'alert' => $this->alert,
            'reponse' => $this->ans
        ], true);
    }
}
