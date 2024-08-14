<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 2/23/2018
 * Time: 12:05 PM
 */

class BaseUser extends tableDataObject {
	const TABLENAME = 'users';

	// FUNCTIONS FROM THE "CONTROLLER" MISTAKENLY CREATED INSTEAD OF AN OBJECT FOR ROLE CONCEPTS
	// -------------------------------------------------------------------------------------------
    /**
     * @return array
     * @throws Error
     */
    public function listRoles(){
		global $cvdb;

		$thisuid = $this->recordObject->uid;

		$getroles = "select role from users
				join user_roles on users.uid = user_roles.users_uid
			    join roles on user_roles.roles_roleid = roles.roleid
			    where uid = $thisuid";
		$cvdb->prepare($getroles);
		$roles = $cvdb->resultSet(true);
		foreach($roles as $role){
			$rolesout[] = $role['role'];
		}
		return $rolesout;
	}

    /**
     * @param $role
     *
     * @return bool
     * @throws Error
     */
    public function hasRole($role){
		global $cvdb;

		$thisuid = $this->recordObject->uid;

		$getrole = "select role from users
				join user_roles on users.uid = user_roles.users_uid
			    join roles on user_roles.roles_roleid = roles.roleid
			    where uid = $thisuid ";

		// accept array of multiple roles to check from
		if(is_array($role)){
			$roles = "('" . implode("','",$role) . "')";
			$getrole .= " and role in $roles";
		} else {
			$getrole .= " and role='$role'";
		}
		$cvdb->prepare($getrole);
		if(count($cvdb->resultSet()) >0){
			return true;
		} else {
			return false;
		}
	}

    /**
     * @param $role
     *
     * @return mixed
     * @throws Error
     */
    public function roletype($role){
		global $cvdb;
		$getuserrole = "Select roleid from roles where role = '$role' ";
		$rl = $cvdb->prepare($getuserrole);
		$role = $cvdb->fetchColumn();
		return $role;
	}

    /**
     * @param $roletype
     *
     * @throws Error
     */
    public function addRole($roletype){
		global $cvdb;
		$uid = $this->recordObject->uid;
		$roleid = $this->roletype($roletype);
		$query = "INSERT INTO  user_roles  (users_uid, roles_roleid) values ($uid , $roleid) ";
		$cvdb->prepare($query);
		$cvdb->execute();
	}


    /**
     * @param $roletype
     *
     * @throws Error
     */
    public function removeRole($roletype){
		global $cvdb;
		$uid = $this->recordObject->uid;
		$roleid = $this->roletype($roletype);
		$query = "DELETE from user_roles where users_uid = $uid and roles_roleid = $roleid ";
		$cvdb->prepare($query);
		$cvdb->execute();
	}

    /**
     * @param $role
     *
     * @return mixed
     * @throws Error
     */
    public static function getUsersWithRole($role){
		global $cvdb;

		$getUqry = "select users.*, roles.role from users join
					user_roles on uid = users_uid join
					roles on roleid = roles_roleid where role = '$role'
					and uid not in (
					  select users_uid from user_roles join roles on roles_roleid = roleid
					    where role = 'deleted'
					) order by uid";
		$cvdb->prepare($getUqry);
		return $cvdb->resultSet();
	}
}
