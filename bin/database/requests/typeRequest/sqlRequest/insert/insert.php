<?php

namespace Epaphrodites\database\requests\typeRequest\sqlRequest\insert;

use Epaphrodites\database\requests\typeRequest\noSqlRequest\insert\insert as InsertInsert;
use Epaphrodites\epaphrodites\define\config\traits\currentSubmit;

class insert extends InsertInsert
{

    use currentSubmit;
    private array $id = [];

    /**
     * Add users to the system from the console
     *
     * @param string|null $login
     * @param string|null $password
     * @param int|null $UserGroup
     * @return bool
     */
    public function sqlConsoleAddUsers(
        ?string $login = null,
        ?string $password = null,
        ?int $UserGroup = null
    ): bool {

        $UserGroup = $UserGroup !== NULL ? $UserGroup : 1;

        if (!empty($login) && count(static::initQuery()['getid']->sqlGetUsersDatas($login)) < 1) {

            $this->table('usersaccount')
                ->insert(' login , password , usersgroup ')
                ->values(' ? , ? , ? ')
                ->param([static::initNamespace()['env']->no_space($login), static::initConfig()['guard']->CryptPassword($password), $UserGroup])
                ->IQuery();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Add users to the system
     *
     * @param string|null $login
     * @param int|null $usersgroup
     * @return bool|string|array
     */
    public function sqlAddUsers(
        ?array $sheetData = null,
        ?int $usersgroup = null
    ) {
        if (!empty($sheetData) && !empty($usersgroup)) {
            $success = true;

            for ($i = 0; $i < count($sheetData); $i++) {
                if (count(static::initQuery()['getid']->sqlGetUsersDatas($sheetData[$i][0])) < 1) {
                    $result = $this->table('usersaccount')
                        ->insert('login, password, namesurname, contact, email, usersgroup')
                        ->values('?, ?, ?, ?, ?, ?')
                        ->param(
                            [
                                static::initNamespace()['env']->no_space($sheetData[$i][0]),
                                static::initConfig()['guard']->CryptPassword($sheetData[$i][3]),
                               ($sheetData[$i][1] .' '.$sheetData[$i][2]),
                                $sheetData[$i][5],
                                $sheetData[$i][4],
                                $usersgroup
                            ]
                        )
                        ->IQuery();

                    if (!$result) {
                        $success = false;
                        break;
                    }

                    $actions = "Add a User: " . $sheetData[$i][0];
                    static::initQuery()['setting']->ActionsRecente($actions);

                    $this->id[] = static::initQuery()['getid']->sqlGetLastInsertId($sheetData[$i][0]);
                } else {
                    return "Compte existant";
                }
            }

            return $success ? ($this->id ? $this->id : false) : false;
        } else {
            return false;
        }
    }

    /**
     * Add students to the system
     *
     * @param array|null $sheetData
     * @param array|null $id_user
     * @return bool
     */
    public function sqlAddStudents(
        array $sheetData,
        array $id_user
    ): bool {

        if (!empty($sheetData)) {
            $success = true;
            for ($i = 0; $i < count($sheetData); $i++) {
                $dateObject = static::formatSQLDate($sheetData[$i][6]);
                $result = $this->table("students")
                    ->insert("_id_user, identifiant, name, surname, email, contact, birthday, birthplace, sex, speciality")
                    ->values('?,?,?,?,?,?,?,?,?,?')
                    ->sdb(3)
                    ->param([
                        $id_user[$i],
                        $sheetData[$i][0],
                        $sheetData[$i][1],
                        $sheetData[$i][2],
                        $sheetData[$i][4],
                        $sheetData[$i][5],
                        $dateObject,
                        $sheetData[$i][7],
                        $sheetData[$i][8],
                        $sheetData[$i][9]
                    ])
                    ->IQuery();
                if (!$result) {
                    $success = false;
                    break;
                }
            }
            return $success;
        } else {
            return false;
        }
    }

    /**
     * Method to register documents
     * @param string $libelle
     * @param string $document
     * @return bool
     */
    public function addRessources($libelle, $document)
    {
        $result = $this->table("documents")
            ->insert("libelleDocument,document")
            ->values('?,?')
            ->sdb(3)
            ->param([$libelle, $document])
            ->IQuery();
        return $result;
    }

    /**
     * Method to register program
     * @param string $libelle
     * @param string  $date
     * @param string $program
     * @return bool
     */
    public function addProgram(string $libelle, string $date, string $program): bool
    {
        $dateObject = static::formatDate($date);
        $result = $this->table("program")
            ->insert("program_lib,dateProgram,program")
            ->values("?,?,?")
            ->param([$libelle,$dateObject, $program])
            ->sdb(3)
            ->IQuery();
        return $result;
    }

    /**
     * Method to register User Account
     * @param string $login
     * @param string $password
     * @param int $userGroup
     * @return bool
     */
    public function addUserAccount(string $login, string $password,int $userGroup): bool
    {
        $result = $this->table("usersaccount")
            ->insert("login,password,usersgroup")
            ->values("?,?,?")
            ->param([$login,static::initConfig()['guard']->CryptPassword($password), $userGroup])
            ->sdb(1)
            ->IQuery();
        return $result;
    }
}
