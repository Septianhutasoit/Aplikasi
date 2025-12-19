<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Message;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('admin.*', function ($view) {
            $newMessages = Message::where('is_read', false)->count();
            $view->with('newMessages', $newMessages);
        });
    }
}
