<?php

namespace App\Http\ViewComposers;

use Auth;
use Illuminate\View\View;
use App\Models\Admin\CharmanEnroll;
use App\Repositories\UserRepository;

class CharmanEnrollComposer
{
    /**
    * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $c = CharmanEnroll::where('charman_id', Auth::user()->user_id)->first();
        $view->with('is_charman', $c ? true : false);
    }
}
