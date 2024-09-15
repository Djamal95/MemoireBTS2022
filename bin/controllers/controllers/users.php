<?php

namespace Epaphrodites\controllers\controllers;

use Epaphrodites\controllers\switchers\MainSwitchers;

final class users extends MainSwitchers
{

    private object $msg;
    private object $session;
    private object $getId;
    private object $count;
    private object $update;
    private object $select;
    private object $insert;
    private string $ans = '';
    private string $alert = '';
    private array|bool $result = [];
    private bool $validate;
    private object $importFiles;

    /**
     * Initialize object properties when an instance is created
     * @return  object
     */
    public final function __construct()
    {
        $this->initializeObjects();
    }

    /**
     * Initialize each property using values retrieved from static configurations
     * 
     * @return void
     */
    private function initializeObjects(): void
    {
        $this->msg = $this->getFunctionObject(static::initNamespace(), 'msg');
        $this->getId = $this->getFunctionObject(static::initQuery(), 'getid');
        $this->count = $this->getFunctionObject(static::initQuery(), 'count');
        $this->select = $this->getFunctionObject(static::initQuery(), 'select');
        $this->insert = $this->getFunctionObject(static::initQuery(), 'insert');
        $this->update = $this->getFunctionObject(static::initQuery(), 'update');
        $this->session = $this->getFunctionObject(static::initNamespace(), 'session');
        $this->importFiles = $this->getFunctionObject(static::initNamespace(), 'import');
    }

    /**
     * Update user datas
     * 
     * @param string $html
     * @return void
     */
    public final function editUsersInfos(
        string $html
    ): void {

        $login = $this->session->login();

        if (static::isValidMethod(true)) {

            $this->result = $this->update->updateUserDatas(static::getPost('__username__'), static::getPost('__email__'), static::getPost('__contact__'));

            [$this->ans, $this->alert] = static::Responses(
                $this->result,
                [
                    true => ['succes', 'alert-success'],
                    false => ['error', 'alert-danger']
                ]
            );
        }

        $this->views(
            $html,
            [
                'alert' => $this->alert,
                'reponse' => $this->ans,
                'select' => $this->getId->GetUsersDatas($login),
            ],
            true
        );
    }

    /**
     * Update user password
     * 
     * @param string $html
     * @return void
     */
    public final function changePassword(
        string $html
    ): void {

        if (static::isValidMethod(true)) {

            $this->result = $this->update->changeUsersPassword(static::getPost('__oldpassword__'), static::getPost('__newpassword__'), static::getPost('__confirm__'));

            [$this->ans, $this->alert] = static::Responses(
                $this->result,
                [
                    1 => ['no-identic', 'alert-danger'],
                    2 => ['no-identic', 'alert-danger'],
                    3 => ['mdpnotsame', 'alert-danger']
                ]
            );
        }

        $this->views(
            $html,
            [
                'reponse' => $this->ans,
                'alert' => $this->alert,
            ],
            true
        );
    }

    /**
     * Upload users datas
     * 
     * @param string $html
     * @return void
     */
    public final function importUsers(
        string $html
    ): void {

        if (static::isValidMethod(true) && static::isFileName('__file__')) {

            $SheetData = $this->importFiles->importExcelFiles(static::getFileName('__file__'));

            if (!empty($SheetData) && static::getPost('__group__') === "3") {
                $this->result = $this->insert->addUsers($SheetData, static::getPost('__group__'));
                if (is_array($this->result)) {
                    $this->validate = $this->insert->addStudents($SheetData, $this->result);
                    if ($this->validate) {
                        $this->ans = $this->msg->answers('succes');
                        $this->alert = 'alert-success';
                    } else {
                        $this->ans = $this->msg->answers('etud-infos');
                        $this->alert = 'alert-success';
                    }
                } else if ($this->result == "Compte existant") {
                    $this->ans = $this->msg->answers('compte-exist');
                    $this->alert = 'alert-danger';
                } else {
                    $this->ans = $this->msg->answers('error');
                    $this->alert = 'alert-danger';
                }
            } else if (!empty($SheetData) && static::getPost('__group__') !== "3") {
                $this->result = $this->insert->addUsers($SheetData, static::getPost('__group__'));
                [$this->ans, $this->alert] = static::Responses(
                    $this->result,
                    [
                        true => ['succes', 'alert-success'],
                        false => ['error', 'alert-danger']
                    ]
                );
            } else {
                $this->ans = $this->msg->answers('fileempty');
                $this->alert = 'alert-danger';
            }
        }

        $this->views(
            $html,
            [
                'reponse' => $this->ans,
                'alert' => $this->alert,
            ],
            true
        );
    }

    /**
     * Show users list 
     * 
     * @param string $html
     * @return void
     */
    public final function allUsersList(
        string $html
    ): void {

        $total = 0;
        $list = [];
        $numLine = 100;
        $currentPage = static::isGet('_p', 'int') ? static::getGet('_p') : 1;

        $position = static::notEmpty(['filtre'], 'GET')
            ? static::getGet('filtre')
            : NULL;

        if (static::isValidMethod(true)) {

            if (static::isPost('_sendselected_')) {

                foreach (static::isArray('users') as $login) {

                    $this->result = static::isSelected('_sendselected_', 1)
                        ? $this->update->updateEtatsUsers($login)
                        : $this->update->initUsersPassword($login);
                }

                [$this->ans, $this->alert] = static::Responses(
                    $this->result,
                    [
                        true => ['succes', 'alert-success'],
                        false => ['error', 'alert-danger']
                    ]
                );
            }
        }

        if (static::isGet('submitsearch') && static::notEmpty(['datasearch'], 'GET')) {

            $list = $this->getId->GetUsersDatas(static::getGet('datasearch'));
            $total = count($list ?? []);
        } else {

            $total = static::notEmpty(['filtre'], 'GET') ?
                $this->count->CountUsersByGroup(static::getGet('filtre'))
                : $this->count->CountAllUsers();

            $list = static::notEmpty(['filtre'], 'GET')
                ? $this->getId->GetUsersByGroup($currentPage, $numLine, static::getGet('filtre'))
                : $this->select->listeOfAllUsers($currentPage, $numLine);
        }

        $this->views(
            $html,
            [
                'total' => $total,
                'current' => $currentPage,
                'liste_users' => $list,
                'alert' => $this->alert,
                'reponse' => $this->ans,
                'position' => $position,
                'select' => $this->getId,
                'nbrePage' => ceil(($total) / $numLine),
            ],
            true
        );
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function changePasswordAd(string $html): void
    {

        if (static::isValidMethod(true)) {

            $this->result = $this->update->changeUsersPassword(static::getPost('__oldpassword__'), static::getPost('__newpassword__'), static::getPost('__confirm__'));

            [$this->ans, $this->alert] = static::Responses(
                $this->result,
                [
                    1 => ['no-identic', 'alert-danger'],
                    2 => ['no-identic', 'alert-danger'],
                    3 => ['mdpnotsame', 'alert-danger']
                ]
            );
        }

        $this->views(
            $html,
            [
                'reponse' => $this->ans,
                'alert' => $this->alert,
            ],
            true
        );
    }

    /**
     * start view function
     * 
     * @param string $html
     * @return void
     */
    public final function addUsers(string $html): void
    {

        if (static::isValidMethod(true)) {
            if (static::getPost('__password__') === static::getPost('__confPass__')) {
                $this->result = $this->insert->addUserAccount(
                    static::getPost('__login__'),
                    static::getPost('__password__'),
                    static::getPost('__group__')
                );
            } else {
                $this->ans = $this->msg->answers('mdpnotsame');
                $this->alert = 'alert-danger';
            }
            [$this->ans, $this->alert] = static::Responses(
                $this->result,
                [
                    true => ['succes', 'alert-success'],
                    false => ['error', 'alert-danger']
                ]
            );
        }
        $this->views($html, [
            'reponse' => $this->ans,
            'alert' => $this->alert,
        ], true);
    }
}
