<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Volt::route('/', 'hour2decimal-converter');
Volt::route('/base64-decode', 'base64-decode');
Volt::route('/markdown2text', 'markdown2text');
