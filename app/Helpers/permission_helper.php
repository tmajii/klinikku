<?php

if (!function_exists('can_access')) {
    /**
     * Check if user can access a module
     * 
     * @param string $module Module name (pasien, pendaftaran, kunjungan, asesmen, diagnosa, users)
     * @param string $action Action type (view, create, edit, delete)
     * @return bool
     */
    function can_access($module, $action = 'view')
    {
        $roleId = session()->get('role_id');
        
        // Superadmin has full access
        if ($roleId == 1) {
            return true;
        }
        
        // Data Pasien - HANYA SUPERADMIN
        if ($module == 'pasien') {
            return false; // Admisi dan Perawat tidak bisa akses
        }
        
        // Admisi (role_id = 2)
        if ($roleId == 2) {
            // Can CRUD Pendaftaran and Kunjungan
            if (in_array($module, ['pendaftaran', 'kunjungan'])) {
                return true;
            }
            // Cannot access Asesmen, Diagnosa, Users
            return false;
        }
        
        // Perawat (role_id = 3)
        if ($roleId == 3) {
            // Can only view Pendaftaran and Kunjungan
            if (in_array($module, ['pendaftaran', 'kunjungan']) && $action == 'view') {
                return true;
            }
            // Can CRUD Asesmen and Diagnosa
            if (in_array($module, ['asesmen', 'diagnosa'])) {
                return true;
            }
            // Cannot access Users
            return false;
        }
        
        return false;
    }
}

if (!function_exists('can_view')) {
    function can_view($module)
    {
        return can_access($module, 'view');
    }
}

if (!function_exists('can_create')) {
    function can_create($module)
    {
        return can_access($module, 'create');
    }
}

if (!function_exists('can_edit')) {
    function can_edit($module)
    {
        return can_access($module, 'edit');
    }
}

if (!function_exists('can_delete')) {
    function can_delete($module)
    {
        return can_access($module, 'delete');
    }
}

if (!function_exists('is_superadmin')) {
    function is_superadmin()
    {
        return session()->get('role_id') == 1;
    }
}

if (!function_exists('is_admisi')) {
    function is_admisi()
    {
        return session()->get('role_id') == 2;
    }
}

if (!function_exists('is_perawat')) {
    function is_perawat()
    {
        return session()->get('role_id') == 3;
    }
}
