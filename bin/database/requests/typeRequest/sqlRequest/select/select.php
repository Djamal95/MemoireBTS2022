<?php

namespace Epaphrodites\database\requests\typeRequest\sqlRequest\select;

use Epaphrodites\database\requests\typeRequest\noSqlRequest\select\select as SelectSelect;

class select extends SelectSelect
{

    /**
     * Request to get users list (For: mySql/sqlServer/Postgres/sqLite)
     *
     * @param integer $currentPage
     * @param integer $numLines
     * @return array
     */
    public function defaultSqlListeOfAllUsers(
        int $currentPage, 
        int $numLines
    ):array{

        $result = $this->table('usersaccount')
            ->orderBy('usersgroup', 'ASC')
            ->limit((($currentPage - 1) * $numLines), $numLines)
            ->SQuery();

        return $result;
    }

    /**
     * Request to get users list (For: oracle)
     *
     * @param integer $currentPage
     * @param integer $numLines
     * @return array
     */
    public function oracleListeOfAllUsers(
        int $currentPage,
        int $numLines
    ):array{

        $result = $this->table('usersaccount')
            ->orderBy('usersgroup', 'ASC')
            ->offset((($currentPage - 1) * $numLines), $numLines)
            ->SQuery();

        return static::initNamespace()['env']->dictKeyToLowers($result);
    } 

    /**
     * Request to get users list (For: sqlServer)
     *
     * @param integer $currentPage
     * @param integer $numLines
     * @return array
     */
    public function sqlServerListeOfAllUsers(
        int $currentPage,
        int $numLines
    ):array{

        $result = $this->table('usersaccount')
            ->orderBy('usersgroup', 'ASC')
            ->offset((($currentPage - 1) * $numLines), $numLines)
            ->SQuery();

        return $result;
    }    

    /**
     * Request to get list of users recents actions (For: mySql/sqlServer/Postgres/sqLite)
     *
     * @param integer $currentPage
     * @param integer $numLines
     * @return array
     */
    public function defaultSqlListOfRecentActions(
        int $currentPage,
        int $numLines
    ):array{

        $result = $this->table('history')
            ->orderBy('dates', 'ASC')
            ->limit((($currentPage - 1) * $numLines), $numLines)
            ->SQuery();

        return $result;
    }  
    
    /**
     * Request to get list of users recents actions (For: oracle)
     *
     * @param integer $currentPage
     * @param integer $numLines
     * @return array
     */
    public function oracleListOfRecentActions( 
        int $currentPage,
        int $numLines
    ):array{

        $result = $this->table('history')
            ->orderBy('dates', 'ASC')
            ->offset((($currentPage - 1) * $numLines), $numLines)
            ->SQuery();

        return static::initNamespace()['env']->dictKeyToLowers($result);
    }     

    /**
     * Request to get list of users recents actions (For: sqlServer)
     *
     * @param integer $currentPage
     * @param integer $numLines
     * @return array
     */
    public function sqlServerListOfRecentActions( 
        int $currentPage,
        int $numLines
    ):array{

        $result = $this->table('history')
            ->orderBy('dates', 'ASC')
            ->offset((($currentPage - 1) * $numLines), $numLines)
            ->SQuery();

        return $result;
    }

    /**
     * Request to get list of all students
     * @return array
     */
     public function listOfStudent(): array
     {
         $result = $this->table('students')
             ->sdb(3)
             ->SQuery();
         return $result;
     }
 
      /**
      * Request to get list of all ressources
      * @return array
      */
      public function listOfRessources(): array
      {
          $result = $this->table('documents')
              ->sdb(3)
              ->SQuery();
          return $result;
      }
 
      /**
      * Request to get list of all program
      * @return array
      */
      public function listOfProgram(): array
      {
          $result = $this->table('program')
              ->sdb(3)
              ->SQuery();
          return $result;
      }
 
 
     /**
      * Request to get student by her id
      * @param int $id
      * @return array
      */
     public function findStudentById($id): array
     {
         $result = $this->table('students')
             ->where('_id')
             ->param([$id])
             ->sdb(3)
             ->SQuery();
         return $result;
     }
 
     /**
      * Method to find one document by her id
      * @param int $id
      * @return array
      */
     public function findRessourceById(int $id): array
     {
         $result = $this->table('documents')
             ->where('_id_doc')
             ->param([$id])
             ->sdb(3)
             ->SQuery();
         return $result;
     }
 
     /**
      * Method to find one program by her id
      * @param int $id
      * @return array
      */
     public function findProgramById(int $id): array
     {
         $result = $this->table('program')
             ->where('_id_prog')
             ->param([$id])
             ->sdb(3)
             ->SQuery();
         return $result;
     }
}