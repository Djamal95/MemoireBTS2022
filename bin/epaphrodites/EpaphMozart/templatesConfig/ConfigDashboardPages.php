<?php

namespace Epaphrodites\epaphrodites\EpaphMozart\templatesConfig;

class ConfigDashboardPages extends ConfigUsersMainPages
{

    private $interface;

    /**
     * Admin interface manager
     * 
     * @param string $key|null
     * @return string
     */
    public function admin(?int $key = null, ?string $url = null)
    {
        
        if ($key !== null) {

            $this->interface =
                [
                    1 => "{$url}super_admin/",
                    2 => "{$url}administrator/",
                    3 => "{$url}students/",
                ];

            return $this->interface[$key];
        } else {
            return $this->login() . $url;
        }
    }

    /** 
     * Login interface manager
     */
    public function identification()
    {

        $this->interface = 'users/edit_users_infos/';

        return $this->interface;
    }    

}
