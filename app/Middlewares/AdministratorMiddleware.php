<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdministratorMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        
        if ($user && $user->role === 'administrator') {
            
            return;
        }

        
        app()->route->redirect('/hello');
    }
}
