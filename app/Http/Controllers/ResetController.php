<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetController extends Controller
{
    public function reset(){
        dd(1);

        Artisan::call('migrate:fresh --seed');

        $folders = ['categories', 'products'];

        foreach ($folders as $folder){
            Storage::deleteDirectory($folder);
            Storage::makeDirectory($folder);

            $files = Storage::disk('reset')->file($folder);

            foreach ($files as $file){
                Storage::put($file, Storage::disk('reset')->get($file));
            }
        }

        session()->flash('success', 'Проект был сброшен в начальное состояние');
        return redirect()->route('index');

    }
}
