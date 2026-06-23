<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about-task', function () {
    $this->info('PRITECH Mini Issue Tracker');
});
