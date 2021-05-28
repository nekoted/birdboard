<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Arr;

trait RecordsActivity
{

    public $oldAttributes = [];


    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * Generate the activity description
     *
     * @param $event
     * @return void
     */
    public function activityDescription($event)
    {
        return "{$event}_" . strtolower(class_basename($this));
    }

    /**
     * Get the recordable events for the model
     *
     * @return void
     */
    public static function recordableEvents()
    {
        $recordableEvents = ['created', 'updated', 'deleted'];
        if (isset(static::$recordableEvents)) {
            $recordableEvents = static::$recordableEvents;
        }
        return $recordableEvents;
    }

    /**
     * Record the activity of the model
     *
     * @param [type] $description
     * @return void
     */
    public function recordActivity($description)
    {
        $this->activities()->create([
            'user_id' => auth()->id(),
            'description' => $description,
            'project_id' => class_basename($this) == 'Project' ? $this->id : $this->project_id,
            'changes' => $this->activityChanges(),
        ]);
    }

    /**
     * Activities relationships
     *
     * @return void
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * Builds an array with the changes before and after
     *
     * @return array
     */
    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }
}
