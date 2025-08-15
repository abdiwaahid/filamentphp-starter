<?php

namespace Abdiwaahid\Users\Observers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;

class ActivityObserver
{
    public function created(Model $model)
    {
        $this->log($model, 'Created');
    }

    public function updated(Model $model)
    {
        $changes = $model->getChanges();
        if (count($changes) == 1 && array_key_exists('remember_token', $changes)) {
            return;
        }
        $this->log($model, 'Updated', null);
    }

    public function deleted(Model $model)
    {
        $this->log($model, 'Deleted');
    }

    public function getUser()
    {
        return Auth::check() ? Auth::user() : null;
    }

    protected function log($model, $event, $description = null)
    {
        $changes = $model->getAttributes();
        $original = $model->getOriginal();
        unset($original['password'], $original['remember_token'], $original['email_verified_at'],$changes['password'], $changes['remember_token'], $changes['email_verified_at']);
        $properties = (blank($original)) ? $changes : [
            'attributes' => $changes,
            'old' => $original,
        ];

        return app(ActivityLogger::class)
        ->useLog('Resource')
        ->setLogStatus(app(ActivityLogStatus::class))
        ->withProperties($properties)
        ->event($event)
        ->by($this->getUser())
        ->on($model)
        ->log($description ? $description : str($model->getMorphClass())->afterLast('\\'). ' '.$event);
    }
}
