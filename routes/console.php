<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('scrape:data-source new_york_times')->everyFiveMinutes();
Schedule::command('scrape:data-source news_api')->everyFiveMinutes();
Schedule::command('scrape:data-source guardian')->everyFiveMinutes();
