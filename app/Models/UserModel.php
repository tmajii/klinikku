<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'role_id', 'is_active', 'last_login'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getUserWithRole($id)
    {
        return $this->select('users.*, roles.role_name, roles.description as role_description')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('users.id', $id)
                    ->first();
    }

    public function getAllUsersWithRole()
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.id = users.role_id')
                    ->findAll();
    }
}
