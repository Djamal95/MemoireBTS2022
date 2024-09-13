<?php

namespace Epaphrodites\controllers\controllers;

use Epaphrodites\controllers\switchers\MainSwitchers;

final class student extends MainSwitchers
{
    private object $msg;
    private object $update;
    private object $select;
    private object $delete;
    private object $env;
    private string $ans = '';
    private string $alert = '';
    private object $layout;
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
        $this->select = $this->getFunctionObject(static::initQuery(), 'select');
        $this->update = $this->getFunctionObject(static::initQuery(), 'update');
        $this->delete = $this->getFunctionObject(static::initQuery(), 'delete');
        $this->env = $this->getFunctionObject(static::initNamespace(), 'env');
        $this->layout = $this->getFunctionObject(static::initNamespace(), 'layout');
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function updateStudent(string $html): void
    {

        $idStudent = static::isGet('_student', 'int') ? static::getGet('_student') : 0;

        if (static::isValidMethod(true) && static::arrayNoEmpty(['__matr__', '__name__', '__surname__', '__email__', '__contact__', '__birthday__', '__birthplace__', '__sex__'])) {
            $sex = (static::getPost('__sex__') == 1) ? "Homme" : "Femme";
            $result = $this->update->updateStudent(
                $idStudent,
                static::getPost('__matr__'),
                static::getPost('__name__'),
                static::getPost('__surname__'),
                static::getPost('__email__'),
                static::getPost('__contact__'),
                static::getPost('__birthday__'),
                static::getPost('__birthplace__'),
                $sex
            );
            if ($result) {
                $this->alert = "alert-success";
                $this->ans = $this->msg->answers("succes");
            } else {
                $this->alert = "alert-danger";
                $this->ans = $this->msg->answers("error");
            }
        }

        $listStudent = $this->select->findStudentById($idStudent);

        $this->views($html, [
            'student' => $listStudent,
            'alert' => $this->alert,
            'reponse' => $this->ans
        ], true);
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function allStudentList(string $html): void
    {

        if (static::isValidMethod(true)) {
            if (static::isSelected('_sendselected_', 1)) {
                foreach (static::isArray('students') as $idStudent) {
                    $result = $this->delete->deleteStudent($idStudent);
                }
                if ($result == true) {
                    $this->alert = "alert-success";
                    $this->ans = $this->msg->answers("succes");
                } else {
                    $this->alert = "alert-danger";
                    $this->ans = $this->msg->answers("error");
                }
            }
        }
        $result = $this->select->listOfStudent();
        $this->views($html, [
            'select' => $result,
            'alert' => $this->alert,
            'reponse' => $this->ans
        ], true);
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
        $layout = $this->layout->admin(3);
        $this->views($html, [
            'layouts' => $layout,
            'program' => $program
        ], false);
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function showDocuments(string $html): void
    {
        $idDoc = static::isGet('_ressource','int')? static::getGet('_ressource'): 0;
        $ressource = $this->select->findRessourceById($idDoc);
        $layout = $this->layout->admin(3);
        $this->views($html, [
            'layouts' => $layout,
            'ressource' => $ressource
        ], false);
    }

    /**
     * start view function
     * @param string $html
     * @return void
     */
    public final function showStudent(string $html): void
    {

        $idStudent = static::isGet('_student', 'int') ? static::getGet('_student') : 0;
        $listStudent = $this->select->findStudentById($idStudent);
        $this->views($html, [
            'student' => $listStudent
        ], true);
    }

    /**
    * start view function
    * 
    * @param string $html
    * @return void
    */
     public final function listOfProgram(string $html): void{
    $layout = $this->layout->admin(3);
    $program = $this->select->listOfProgram();
        $this->views( $html, [
            'program' => $program,
            'layouts' => $layout
        ], false );
    }

    /**
    * start view function
    * 
    * @param string $html
    * @return void
    */
     public final function listOfDocuments(string $html): void{
        $ressources = $this->select->listOfRessources();
        $layout = $this->layout->admin(3);

        $this->views( $html, [
            'layouts' => $layout,
            'ressource' => $ressources
        ], false );
    }

    /**
    * start view function
    * 
    * @param string $html
    * @return void
    */
     public final function students(string $html): void{
      
        $this->views( $html, [], false );
    }
}