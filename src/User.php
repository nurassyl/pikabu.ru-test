<?php

class User implements IUser
{
	private $id;
	private $name;

	public function __construct(int $id, string $name = NULL, $db_request = true)
	{
		if($db_request === true) {
			global $db;

			$r = $db->query("SELECT id, name FROM users WHERE id = $id")->fetch_array();

			if(is_null($r)) throw new Exception('User not found.');

			$this->id = intval($r['id']);
			$this->name = $r['name'];
		} else {
			$this->id = intval($id);
			$this->name = $name;
		}
	}

	public function getId(): int
	{
		return $this->id;

	}

	public function getName(): ?string
	{
		return $this->name;
	}
}

