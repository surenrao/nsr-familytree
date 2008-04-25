<?php
require_once('UserProfile.php');
class UserDao
{
	protected $db;
	
	/**
	 * Enter description here...
	 *
	 */
    public function __construct()
    {
    	$this->db = Zend_Registry::get('db');
    	require_once('User.php');
    }
    
    /**
     * Enter description here...
     *
     * @param string $userName
     * @return User
     */
	public function getUserInfo($userName)
	{
		$this->db->setFetchMode(Zend_Db::FETCH_OBJ);

		$result = $this->db->fetchAll('SELECT * FROM users WHERE username = ?', $userName);
		
		$user = new User();
		$user->userId = $result[0]->user_id;
		$user->username = $result[0]->username;		
		$user->password = $result[0]->password;
		$user->userType = $result[0]->user_type;
		$user->tsLastLogin = $result[0]->ts_last_login;
		$user->tsCreated = $result[0]->ts_created;		
		return $user;		
	}	
	
	/**
	 * Enter description here...
	 *
	 * @param integer $userId
	 * @return UserProfile
	 */
	public function getUserProfile($userId)
	{
		$this->db->setFetchMode(Zend_Db::FETCH_OBJ);

		$result = $this->db->fetchPairs('SELECT profile_key, profile_value FROM users_profile WHERE user_id = ?', $userId);
		
		$userProfile = new UserProfile();
		$userProfile->userId = $userId; 
		$userProfile->address = trim(@$result['address']);
		$userProfile->city = trim(@$result['city']);
		$userProfile->country = trim(@$result['country']);
		$userProfile->dateOfBirth = trim(@$result['dateOfBirth']);
		$userProfile->email  = trim(@$result['email']);
		$userProfile->firstName = trim(@$result['firstName']);
		$userProfile->lastName = trim(@$result['lastName']);
		$userProfile->phone = trim(@$result['phone']);
		$userProfile->pinCode = trim(@$result['pinCode']);
		$userProfile->state = trim(@$result['state']);		
		
		return $userProfile;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param User $user
	 */
	public function addUser(User $user)
	{
		$data = array(
		    'user_id'     => $user->userId ,
		    'username'    => $user->username,
		    'password'    => $user->password,
			'user_type'   => $user->userType,
			'ts_created'  => new Zend_Db_Expr('NOW()')
		);

		$this->db->insert('users', $data);
	}
	
	/**
	 * Enter description here...
	 *
	 * @param integer $userId
	 */
	public function updateLastLogin($userId)
	{
		$data = array(		    
			'ts_last_login'  => new Zend_Db_Expr('NOW()')
		);

		$this->db->update('users', $data,'user_id ='.$userId);
	}
	
	/**
	 * Enter description here...
	 *
	 * @param integer $userId
	 * @param string $newPassword
	 */
	public function changePassword($userId, $newPassword)
	{
		$data = array(	
			'password'    => $newPassword			
		);

		$this->db->update('users', $data,'user_id ='.$userId);
	}
	
	/**
	 * Enter description here...
	 *
	 * @param integer $userId
	 * @param string $newUserType
	 */
	public function changeUserType($userId, $newUserType)
	{
		$data = array(	
			'user_type'    => $newUserType			
		);

		$this->db->update('users', $data,'user_id ='.$userId);
	}
}
?>