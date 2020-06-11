<?php

use Illuminate\Database\Eloquent\Model;
use Hashemi\Fireworks\Fireworks;

class User extends Model
{
    use Fireworks;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'count',
    ];

    protected function onModelNameCreating($model, $new)
    {
        $model->name = \Illuminate\Support\Str::studly($new);
    }

    protected function onModelNameUpdating($model, $new, $old)
    {
        $model->name = \Illuminate\Support\Str::studly($new);
    }

    protected function onModelNameDeleting($model, $new, $old)
    {
        $model->name = \Illuminate\Support\Str::studly($new);
    }

    protected function onModelNameSaving($model, $new, $old)
    {
        $model->name = \Illuminate\Support\Str::studly($new);
    }

    protected function onModelCreating()
    {

    }

    protected function onModelSaving()
    {

    }

    protected function onModelDeleting()
    {

    }


}