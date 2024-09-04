<?php

namespace Epaphrodites\database\requests\mainRequest\insert;

use Epaphrodites\database\requests\typeRequest\sqlRequest\insert\insert as InsertInsert;
use Epaphrodites\epaphrodites\define\config\traits\currentSubmit;

final class insert extends InsertInsert
{

  use currentSubmit;
  /**
   * Add users rights
   * @param int|null $userGroup
   * @param string|null $pages
   * @param string|null $actions
   * @return bool
   */
  public function AddUsersRights(
    ?int $userGroup = null,
    ?string $pages = null,
    ?string  $actions = null
  ): bool {

    if (static::initConfig()['addright']->AddUsersRights($userGroup, $pages, $actions) === true) {

      $actions = "Assign a right to the user group : " . static::initNamespace()['datas']->userGroup($userGroup);
      static::initQuery()['setting']->ActionsRecente($actions);

      return true;
    } else {
      return false;
    }
  }

  /**
   * Add a new users
   * @param array $sheetData
   * @param int $userGroup
   * @return bool|array|string
   */
  public function addUsers(
    ?array $sheetData,
    ?int $userGroup
  ) {
    $result =  $this->sqlAddUsers($sheetData, $userGroup);
    if (!is_array($result))
      return $result;
    return static::TransArray($result) ? static::TransArray($result) : false;
  }

  /**
   * Add a new students
   * @param array $sheetData
   * @param array $id_user
   * @return bool
   */
  public function addStudents(
    array $sheetData,
    array $id_user
  ): bool {
    $result = $this->sqlAddStudents($sheetData, $id_user);
    return $result ? $result : false;
  }

  /**
   * Add a new users from console
   * @param string $login
   * @param string $password
   * @param int $UserGroup
   * @return array
   */
  public function ConsoleAddUsers(
    ?string $login,
    ?string $password,
    ?int $UserGroup
  ): bool {

    return match (_FIRST_DRIVER_) {

      'mongodb' => $this->noSqlConsoleAddUsers($login, $password, $UserGroup),
      'redis' => $this->noSqlRedisConsoleAddUsers($login, $password, $UserGroup),

      default => $this->sqlConsoleAddUsers($login, $password, $UserGroup),
    };
  }
}
