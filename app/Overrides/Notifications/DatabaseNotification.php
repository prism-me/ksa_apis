<?php

namespace App\Overrides\Notification;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Notifications\DatabaseNotificationCollection;

class DatabaseNotification extends Eloquent
{
  protected $connection = 'mongodb'; 
}