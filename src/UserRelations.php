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
		$user_ids = [];
		$user_ids[] = $this->user->getId();

		$i = 1;
		while(true) {
			if(count($user_ids) === 0) break;

			$r = $this->db->query("SELECT DISTINCT relation_id FROM user_relations WHERE user_id IN (" . implode($user_ids, ', ') . ") AND type = 0 LIMIT " . self::MAX_DIRECT_RELATIONS);

			$user_ids = [];
			while($row = $r->fetch_assoc()) {
				if(intval($row['relation_id']) === $user->getId()) {
					return true;
				}

				$user_ids[] = intval($row['relation_id']);
			}

			if($maxScanDepth !== 0) {
				if($i === $maxScanDepth) {
					break;
				}
				$i++;
			}
		}

		return false;
	}

	public function isFoe(IUser $user, int $maxScanDepth = 0): bool
	{
		$user_ids = [];
		$user_ids[] = $this->user->getId();

		$i = 1;
		while(true) {
			if(count($user_ids) === 0) break;

			$r = $this->db->query("SELECT DISTINCT relation_id, type FROM user_relations WHERE user_id IN (" . implode($user_ids, ', ') . ") LIMIT " . self::MAX_DIRECT_RELATIONS);

			$user_ids = [];
			while($row = $r->fetch_assoc()) {
				if(intval($row['relation_id']) === $user->getId() && $row['type'] === '1') {
					return true;
				}

				if($row['type'] === '0') {
					$user_ids[] = intval($row['relation_id']);
				}
			}

			if($maxScanDepth !== 0) {
				if($i === $maxScanDepth) {
					break;
				}
				$i++;
			}
		}

		return false;
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
