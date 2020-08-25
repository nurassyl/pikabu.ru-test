<?php

class UserRelations implements IUserRelations
{
	private $db;
	private $user;

	public function __construct($mysql, IUser $user)
	{
		$this->db = $mysql;
		$this->user = $user;
	}

	private function getNumberOfRelations(): int
	{
		$r = $this->db->query("SELECT COUNT(*) FROM user_relations WHERE user_id = " . $this->user->getId() . "");
		return $r->fetch_array()[0];
	}

	public function addFriend(IUser $user): bool
	{
		$this->db->query('START TRANSACTION');

		if($this->getNumberOfRelations() >= self::MAX_DIRECT_RELATIONS) {
			return false;
		}
		//$r = $this->db->query("SELECT EXISTS (SELECT * FROM user_relations WHERE user_id = $this->user->getId() AND relation_id = $user->getId())");
		$r = $this->db->query("SELECT COUNT(*) FROM user_relations WHERE user_id = " . $this->user->getId() . " AND relation_id = " . $user->getId() . " LIMIT 1");
		$r = intval($r->fetch_array()[0]);
		if($r === 0) {
			$this->db->query("INSERT INTO user_relations (user_id, relation_id, type) VALUES (" . $this->user->getId() . ", " . $user->getId() . ", 0)");
			return $this->db->query('COMMIT');
		} else {
			//throw new Exception('Already exists.');
		}

		return false;
	}

	public function addFoe(IUser $user): bool
	{
		$this->db->query('START TRANSACTION');

		if($this->getNumberOfRelations() >= self::MAX_DIRECT_RELATIONS) {
			return false;
		}
		$r = $this->db->query("SELECT COUNT(*) FROM user_relations WHERE user_id = " . $this->user->getId() . " AND relation_id = " . $user->getId() . " LIMIT 1");
		$r = intval($r->fetch_array()[0]);
		if($r === 0) {
			$this->db->query("INSERT INTO user_relations (user_id, relation_id, type) VALUES (" . $this->user->getId() . ", " . $user->getId() . ", 1)");
			return $this->db->query('COMMIT');
		} else {
			//throw new Exception('Already exists.');
		}

		return false;
	}

	public function removeRelation(IUser $user): bool
	{
		return $this->db->query("DELETE FROM user_relations WHERE user_id = " . $this->user->getId() . " AND relation_id = " . $user->getId() . " LIMIT 1");
	}

	public function isFriend(IUser $user, int $maxScanDepth = 0): bool
	{
		return true;
	}

	public function isFoe(IUser $user, int $maxScanDepth = 0): bool
	{
		return true;
	}

	public function getAllFriends(int $maxScanDepth = 0): array
	{
		return [];
	}

	public function getConflictUsers(int $maxScanDepth = 0): array
	{
		return [];
	}
}

