<?php

Route::get('/',function(){
    return redirect()->route('session.index');
});

Route::group(['prefix' => 'session'], function (){
    Route::get('/', 'SessionController@index')
        ->name('session.index');
    Route::get('/show/{sessionId}', 'SessionController@show')
        ->name('session.show');

    Route::get('/datatable', 'SessionController@datatable')
        ->name('session.datatable');

    Route::post('/store', 'SessionController@store')
        ->name('session.store');

    Route::put('/update/{sessionId}', 'SessionController@update')
        ->name('session.update');

    Route::get('/list-question/{sessionId}', 'SessionController@listQuestion')
        ->name('session.listQuestion');

    Route::post('/add-question/{sessionId}', 'SessionController@addQuestion')
        ->name('session.addQuestion');

    Route::delete('/delete-question/{sessionId}', 'SessionController@deleteQuestion')
        ->name('session.deleteQuestion');

    Route::post('/update-order-question/{sessionId}', 'SessionController@updateOrder')
        ->name('question.updateOrder');
});

Route::group(['prefix' => 'question'], function (){
    Route::get('/', 'QuestionController@index')
        ->name('question.index');

    Route::get('/datatable', 'QuestionController@datatable')
        ->name('question.datatable');

    Route::post('/store', 'QuestionController@store')
        ->name('question.store');

    Route::put('/update/{questionId}', 'QuestionController@update')
        ->name('question.update');

    Route::get('/show/{questionId}', 'QuestionController@show')
        ->name('question.show');

    Route::delete('/destroy/{questionId}', 'QuestionController@destroy')
        ->name('question.destroy');
});

Route::group(['prefix' => 'answer'], function (){
    Route::post('/store', 'AnswerController@store')
        ->name('answer.store');

    Route::put('/update/{questionId}', 'AnswerController@update')
        ->name('answer.update');
});
