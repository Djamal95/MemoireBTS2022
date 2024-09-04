<?php 

namespace Epaphrodites\database\gearShift\schema;

trait makeUpGearShift{

    /**
     * Create table useraccount
     * create 25/01/2024 23:07:14
     */
   /*  public function createUsersAccountTable()
    {
        return $this->createTable('usersaccount', function ($table) {
                $table->addColumn('_id', 'INTEGER', ['PRIMARY KEY', 'AUTOINCREMENT']);
                $table->addColumn('login', 'TEXT' , ['NOT NULL']);
                $table->addColumn('password', 'TEXT' , ['NOT NULL']);
                $table->addColumn('namesurname', 'TEXT' , ['DEFAULT NULL']);
                $table->addColumn('contact', 'TEXT' , ['DEFAULT NULL']);
                $table->addColumn('email', 'TEXT' , ['DEFAULT NULL']);
                $table->addColumn('ip', 'TEXT' , ['DEFAULT NULL']);
                $table->addColumn('usersgroup', 'INTEGER' , ['NOT NULL', 'DEFAULT 1']);
                $table->addColumn('state', 'INTEGER' , ['NOT NULL', 'DEFAULT 1']);
                $table->addIndex('login');
                $table->db(1);
        });
    } */    

    /**
    * Create table students
    * create 26/08/2024 09:27:59
    */
    /* public function createStudentsTable()
    {
        return $this->createTable('students', function ($table) {

               $table->addColumn('_id', 'INTEGER', ['PRIMARY KEY','AUTO_INCREMENT']);
               $table->addColumn('_id_user', 'INTEGER');
               $table->addColumn('identifiant', 'VARCHAR(15)');
               $table->addColumn('name', 'VARCHAR(100)', ['DEFAULT NULL']);
               $table->addColumn('surname', 'VARCHAR(100)', ['DEFAULT NULL']);
               $table->addColumn('email', 'VARCHAR(100)', ['DEFAULT NULL']);
               $table->addColumn('contact', 'VARCHAR(100)', ['DEFAULT NULL']);
               $table->addIndex('identifiant');
               $table->addIndex('_id_user');
               $table->db(3);
        });
    }      */

    /**
    * Create table program
    * create 31/08/2024 21:18:04
    */
    public function createProgramTable()
    {
        return $this->createTable('program', function ($table) {

               $table->addColumn('_id_prog', 'INTEGER', ['PRIMARY KEY']);
               $table->addColumn('program_lib', 'VARCHAR(100)');
               $table->addColumn('dateProgram', 'DATETIME');
               $table->addColumn('program', 'VARCHAR(100)');
               $table->db(3);
        });
    }     

    /**
    * Create table documents
    * create 31/08/2024 21:18:16
    */
    public function createDocumentsTable()
    {
        return $this->createTable('documents', function ($table) {

               $table->addColumn('_id_doc', 'INTEGER', ['PRIMARY KEY']);
               $table->addColumn('libelleDocument', 'VARCHAR(100)');
               $table->addColumn('document', 'VARCHAR(100)');
               $table->db(3);
        });
    }   
}