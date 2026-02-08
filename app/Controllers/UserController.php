<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        // Check if AJAX request
        if ($this->request->isAJAX()) {
            return view('users/index_content');
        }
        
        return view('users/index');
    }

    public function datatable()
    {
        $request = $this->request->getPost();
        
        // Get all users with role
        $users = $this->userModel->getAllUsersWithRole();
        
        // Response for DataTables
        return $this->response->setJSON([
            'draw' => intval($request['draw'] ?? 1),
            'recordsTotal' => count($users),
            'recordsFiltered' => count($users),
            'data' => $users
        ]);
    }

    public function get($id)
    {
        $data = $this->userModel->getUserWithRole($id);
        return $this->response->setJSON($data);
    }

    public function getRoles()
    {
        $roles = $this->roleModel->findAll();
        return $this->response->setJSON($roles);
    }

    public function save()
    {
        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'full_name' => 'required|min_length[3]',
            'role_id' => 'required|numeric',
        ];

        $id = $this->request->getPost('id');
        
        // Password required only for new user
        if (!$id) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
            ])->setStatusCode(400);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        // Handle password
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            if ($id) {
                // Update
                $this->userModel->update($id, $data);
                $message = 'User berhasil diupdate';
            } else {
                // Insert
                $this->userModel->insert($data);
                $message = 'User berhasil ditambahkan';
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        // Prevent user from deleting themselves
        if ($id == session()->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri'
            ])->setStatusCode(400);
        }

        try {
            $this->userModel->delete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    // Legacy methods for backward compatibility
    public function create()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('users/create', $data);
    }

    public function store()
    {
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        $data['roles'] = $this->roleModel->findAll();
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        // Update password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to('/users')->with('success', 'User berhasil diupdate');
    }
}
