@extends(Auth::user()->isAdminLoggedIn() ? 'layouts.admin' : 'layouts.user')
