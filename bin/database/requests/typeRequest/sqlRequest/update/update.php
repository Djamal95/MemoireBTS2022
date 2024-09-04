<?php

namespace Epaphrodites\database\requests\typeRequest\sqlRequest\update;

use Epaphrodites\database\requests\typeRequest\noSqlRequest\update\update as UpdateUpdate;

class update extends UpdateUpdate
{

    /**
     * Request to update users password
     *
     * @param string $OldPassword
     * @param string $NewPassword
     * @param string $confirmdp
     * @return int|bool
     */
    public function sqlChangeUsersPassword(
        string $OldPassword, 
        string $NewPassword, 
        string $confirmdp
    ):int|bool
    {

        if (static::initConfig()['guard']->GostCrypt($NewPassword) === static::initConfig()['guard']->GostCrypt($confirmdp)) {

            $result = static::initQuery()['auth']->findSqlUsers(static::initNamespace()['session']->login());

            if (!empty($result)) {

                $result = static::initNamespace()['env']->dictKeyToLowers($result);

                if (static::initConfig()['guard']->AuthenticatedPassword($result[0]["password"], $OldPassword) === true) {

                    $this->table('usersaccount')
                        ->set(['password'])
                        ->where('login')
                        ->param([static::initConfig()['guard']->CryptPassword($NewPassword), static::initNamespace()['session']->login()])
                        ->UQuery();

                    $actions = "Change password : " . static::initNamespace()['session']->login();
                    static::initQuery()['setting']->ActionsRecente($actions);

                    $this->desconnect = static::initNamespace()['paths']->logout();

                    header("Location: $this->desconnect ");
                    exit;
                } else {
                    return 3;
                }
            } else {

                return 2;
            }
        } else {
            return 1;
        }
    }

    /**
     * Update user password and user group
     *
     * @param string|NULL $login
     * @param string|NULL $password
     * @param int|NULL $UserGroup
     * @return bool
     */
    public function sqlConsoleUpdateUsers(
        ?string $login = NULL, 
        ?string $password = NULL, 
        ?int $UserGroup = NULL
    ): bool
    {
        $GetDatas = static::initQuery()['getid']->sqlGetUsersDatas($login);

        if (!empty($GetDatas)) {

            $password = $password !== NULL ? $password : $login;
            $UserGroup = $UserGroup !== NULL ? $UserGroup : $GetDatas[0]['usersgroup'];

            $this->table('usersaccount')
                ->set(['password', 'usersgroup'])
                ->where('login')
                ->param([static::initConfig()['guard']->CryptPassword($password), $UserGroup, "$login"])
                ->UQuery();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Request to initialize user password
     *
     * @param integer $UsersLogin
     * @return bool
     */
    public function sqlInitUsersPassword(
        string $UsersLogin
    ): bool
    {

        $this->table('usersaccount')
            ->set(['password'])
            ->where('login')
            ->param([static::initConfig()['guard']->CryptPassword($UsersLogin), $UsersLogin])
            ->UQuery();

        $actions = "Reset user password : " . $UsersLogin;
        static::initQuery()['setting']->ActionsRecente($actions);

        return true;
    }

    /**
     * Request to switch user connexion state (For: Oracle)
     *
     * @param integer $login
     * @return bool
     */
    public function sqlUpdateOracleUsersState(
        string $login
    ): bool
    {
        
        $GetUsersDatas = static::initQuery()['getid']->sqlGetUsersDatas($login);

        if (!empty($GetUsersDatas)) {

            $GetUsersDatas = static::initNamespace()['env']->dictKeyToLowers($GetUsersDatas);

            $state = !empty($GetUsersDatas[0]['state']) ? 0 : 1;

            $etatExact = "Close";

            if ($state == 1) {
                $etatExact = "Open";
            }

            $this->table('usersaccount')
                ->set(['state'])
                ->like('login')
                ->param([$state, $GetUsersDatas[0]['login']])
                ->UQuery();
              
            $actions = $etatExact . " of the user's account : " . $GetUsersDatas[0]['login'];
            static::initQuery()['setting']->ActionsRecente($actions);
           
            return true;
        } else {
            return false;
        }
    }

    /**
     * Request to switch user connexion state (For: mysql/postgres/sqlServer/sqLite)
     *
     * @param integer $login
     * @return bool
     */
    public function sqlUpdateUsersState(
        string $login
    ): bool
    {
        
        $GetUsersDatas = static::initQuery()['getid']->sqlGetUsersDatas($login);

        if (!empty($GetUsersDatas)) {

            $state = !empty($GetUsersDatas[0]['state']) ? 0 : 1;

            $etatExact = "Close";

            if ($state == 1) {
                $etatExact = "Open";
            }

            $this->table('usersaccount')
                ->set(['state'])
                ->like('login')
                ->param([$state, $GetUsersDatas[0]['login']])
                ->UQuery();
              
            $actions = $etatExact . " of the user's account : " . $GetUsersDatas[0]['login'];
            static::initQuery()['setting']->ActionsRecente($actions);
           
            return true;
        } else {
            return false;
        }
    }

    /**
     * Request to update user datas
     *
     * @param string $usersname
     * @param string $email
     * @param string $number
     * @return mixed
     */
    public function sqlUpdateUserDatas(
        string $usersname, 
        string $email, 
        string $number
    ):mixed
    {
        
        if (static::initNamespace()['verify']->onlyNumber($number, 11) === false) {

            $this->table('usersaccount')
                ->set(['contact', 'email', 'namesurname', 'state'])
                ->where('login')
                ->param([$number, $email, $usersname, 1, static::initNamespace()['session']->login()])
                ->UQuery();

            $_SESSION["usersname"] = $usersname;

            $_SESSION["contact"] = $number;

            $_SESSION["email"] = $email;

            $actions = "Edit Personal Information : " . static::initNamespace()['session']->login();
            static::initQuery()['setting']->ActionsRecente($actions);

            $this->desconnect = static::initNamespace()['paths']->dashboard();

            header("Location: $this->desconnect ");
            exit;
        } else {
            return false;
        }
    }

    /**
     * Method to update informations of one student
     * @param int $_id
     * @param string $identifiant
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $contact
     * @param string $birthday
     * @param string $birthplace
     * @param string $sex
     * @return bool
     */
    public function updateStudent(
        int $_id,
        string $identifiant,
        string $name,
        string $surname,
        string $email,
        string $contact,
        string $birthday,
        string $birthplace,
        string $sex
    ): bool {
        $result = $this->table('students')
            ->set(['identifiant', 'name', 'surname', 'email','contact', 'birthday', 'birthplace', 'sex'])
            ->where('_id')
            ->sdb(3)
            ->param([$identifiant, $name, $surname, $email, $contact, $birthday, $birthplace, $sex, $_id])
            ->UQuery();
        return $result;
    }

    /**
     * Method to update informations of one document
     * @param int $id_doc
     * @param string $libelleDocument
     * @param string $document
     * @return bool
     */
    public function updateRessource(
        int $id_doc,
        string $libelleDocument,
        string $document
    ): bool {
        $result = $this->table('documents')
            ->set(['libelleDocument','document'])
            ->where('_id_doc')
            ->sdb(3)
            ->param([$libelleDocument,$document,$id_doc])
            ->UQuery();
        return $result;
    }

    /**
     * Method to update informations of one document
     * @param int $id_doc
     * @param string $libelleDocument
     * @param string $document
     * @return bool
     */
    public function updateProgram(
        int $id_prog,
        string $program_lib,
        string $program
    ): bool {
        $result = $this->table('program')
            ->set(['program_lib','program'])
            ->where('id_prog')
            ->sdb(3)
            ->param([$program_lib,$program,$id_prog])
            ->UQuery();
        return $result;
    }
}