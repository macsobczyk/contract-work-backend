<?php

namespace App\Core\User\Repository;

final class UserManager {
	public function __construct(
		private UserRepositoryInterface $repository
	) {
	}

	public function getRepository(): UserRepositoryInterface {
		return $this->repository;
	}
}