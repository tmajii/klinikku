<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Get module from arguments
        $module = $arguments[0] ?? null;
        $action = $arguments[1] ?? 'view';
        
        if (!$module) {
            return redirect()->to('/')->with('error', 'Invalid module');
        }
        
        // Check permission
        if (!can_access($module, $action)) {
            // If AJAX request, return JSON
            if ($request->isAJAX()) {
                return service('response')
                    ->setJSON([
                        'success' => false,
                        'message' => 'Anda tidak memiliki akses ke fitur ini'
                    ])
                    ->setStatusCode(403);
            }
            
            // Otherwise redirect to dashboard
            return redirect()->to('/')
                ->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
