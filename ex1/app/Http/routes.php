<?php

Route::get('/', function () {
    return response()->json(['api1' => route('api1.index')]);
});


//Route::group([])
Route::group([
        'as' => 'api1.',
        'prefix' => 'api1'
    ]
    , function () {
        Route::get('/', ['as' => 'index', function () {
            return response()->json([
                'name' => 'api',
                'version' => '1.0',
                'models' => [
                    'task' => [
                        'all' => 'GET ' . route('api1.task.index'),
                        'update' => 'PUT ' . route('api1.task.update', 0),
                        'create' => 'POST ' . route('api1.task.create'),
                        'delete' => 'DELETE ' . route('api1.task.delete', 0),
                        'show details' => 'GET ' . route('api1.task.show', 0),
                        'set done' => 'GET ' . route('api1.task.done', 0),
                        'set priority' => 'GET ' . route('api1.task.priority', [0, 1]),
                    ],
                ]
            ]);
        }]);

        Route::get('task/', ['as' => 'task.index', 'uses' => 'TaskController@index']);
        Route::post('task/', ['as' => 'task.create', 'uses' => 'TaskController@create']);
        Route::get('task/{id}/priority/{sort_order}', ['as' => 'task.priority', 'uses' => 'TaskController@priority']);
        Route::get('task/{id}/done', ['as' => 'task.done', 'uses' => 'TaskController@done']);
        Route::get('task/{id}', ['as' => 'task.show', 'uses' => 'TaskController@show']);
        Route::put('task/{id}', ['as' => 'task.update', 'uses' => 'TaskController@update']);
        Route::get('task/create-auto', ['as' => 'task.create_auto', 'uses' => 'TaskController@create_auto']);
        Route::delete('task/{id}', ['as' => 'task.delete', 'uses' => 'TaskController@delete']);

    });
