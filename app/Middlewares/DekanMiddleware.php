<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class DekanMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        
        if ($user && $user->role === 'dekan') {
            
            return;
        }

        
        app()->route->redirect('/hello');
    }
}
