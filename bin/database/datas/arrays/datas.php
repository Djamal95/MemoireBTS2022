<?php

namespace Epaphrodites\database\datas\arrays;

class datas
{

    /**
     * List of users group
     * @param int $key
     * @return mixed
     */
    public function userGroup(
        ?int $key = null
    ): mixed
    {
        $list = [
            1 => 'SUPER ADMINISTRATOR',
            2 => 'ADMINISTRATOR',
            3 => 'STUDENTS',
        ];
    
        return $key === null ? $list : ($list[$key] ?? 0);
    }
    

    /**
     * Authorization actions
     * @param int $key
     * @return mixed
     */
    public function autorisation(
        ?string $key = null
    ): mixed
    {
        $list = [
            1 => 'DENY',
            2 => 'ALLOW',
        ];
    
        return $key === null ? $list : ($list[$key] ?? 0);
    }
    

    /**
     * Validation actions for users
     * @return array
     */
    public function ActionsUsers():array
    {

       return
            [
                1 => "ENABLE / DISABLE AN ACCOUNT",
                2 => "RESET PASSWORD",
            ];
    }   
    
    /**
     * Rights actions
     * @return array
     */
    public function ActionsRights():array
    {
       return
            [
                1 => "GRANT PERMISSION",
                2 => "DENY PERMISSION",
                3 => "DELETE RIGHT",
            ];
    }

    /**
     * Sex list
     * @return array
     */
    public function sexList():array
    {
       return
            [
                1 => "Homme",
                2 => "Femme",
            ];
    } 


    /**
     * Speciality list
     * @return array
     */
    public function specialityList():array
    {
       return
            [
                1 => "GESTION",
                2 => "ECONOMIE",
                2 => "COMPTBILITE",
                2 => "FINANCE",
            ];
    } 
}
