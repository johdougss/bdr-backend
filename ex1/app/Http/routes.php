<?php


//Route::group([])
Route::group([
        'as' => 'api1.',
        'prefix' => 'api1'
    ]
    , function () {
        Route::get('/', function () {
            return 'Api RESTFULL';
        });

        Route::get('task/', ['as' => 'task.index', 'uses' => 'TaskController@index']);
        Route::post('task/', ['as' => 'task.create', 'uses' => 'TaskController@create']);
        Route::get('task/{id}/priority/{sort_order}', ['as' => 'task.priority', 'uses' => 'TaskController@priority']);
        Route::get('task/{id}/done', ['as' => 'task.done', 'uses' => 'TaskController@done']);
        Route::get('task/{id}', ['as' => 'task.show', 'uses' => 'TaskController@show']);
        Route::put('task/{id}', ['as' => 'task.update', 'uses' => 'TaskController@update']);
        Route::get('task/create-auto', ['as' => 'task.create_auto', 'uses' => 'TaskController@create_auto']);
        Route::delete('task/{id}', ['as' => 'task.delete', 'uses' => 'TaskController@delete']);

    });
