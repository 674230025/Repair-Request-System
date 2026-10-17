<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:repair-system', function () {
    $this->info('Repair Request System is ready to configure.');
})->purpose('Display a quick status message for the repair system');
