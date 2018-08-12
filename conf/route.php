<?php
use think\Route;

Route::rule('/','index/index/index');

Route::rule('upload/add','api/upload/add');
Route::rule('upload/update','api/upload/update');
Route::rule('upload/delete','api/upload/delete');
Route::rule('upload/get','api/upload/get');
Route::rule('upload/page','api/upload/page');
Route::rule('upload/all','api/upload/all');

