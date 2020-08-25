<?php

class User implements IUser
{
	private $id;
	private $name;

	public function __construct(int $id)
	{
		global $db;
		$r = $db->query("SELECT * FROM users WHERE id = $id")->fetch_array();
		if(is_null($r)) throw new Exception('User not found.');
		$this->id = $r['id'];
		$this->name = $r['name'];
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

