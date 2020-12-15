<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AppHelper
{
    /**
     * Set typical laravel routes:
     * resource.index
     * resource.create
     * resource.store
     * resource.show
     * resource.edit
     * resource.update
     * resource.destroy
     *
     * @param $name string
     */
    static public function setRouteNames($name)
    {
        Route::get('/', ucfirst($name).'Controller@index')->name($name.'.index');
        Route::get('create', ucfirst($name).'Controller@create')->name($name.'.create');
        Route::post('store', ucfirst($name).'Controller@store')->name($name.'.store');
        Route::get('edit/{id}', ucfirst($name).'Controller@edit')->name($name.'.edit');
        Route::post('update', ucfirst($name).'Controller@update')->name($name.'.update');
        Route::delete('destroy', ucfirst($name).'Controller@destroy')->name($name.'.destroy');
    }

    static public function getCurrentControllerName($class)
    {
        $parts = explode("\\", $class);
        $ctrlName = end($parts);
        $ctrlName = str_replace('Controller', '', $ctrlName);
        $ctrlName = strtolower($ctrlName);

        return $ctrlName;
    }

    static public function getActiveClass($path)
    {
        $request = Request::capture();
        return $request->is($path) ? ' active' : '';
    }

    static public function getChecked($currentKey, array $keys, $oldAttrName = null)
    {
        $inArray = in_array($currentKey, $keys) ? true : false;
        if ($inArray) {
            return 'checked';
        }

        if ($oldAttrName) {
            return in_array($currentKey, $oldAttrName) ? 'checked' : '';
        }

        return '';
    }

}