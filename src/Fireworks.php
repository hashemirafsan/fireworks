<?php

declare(strict_types=1);

namespace Hashemi\Fireworks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait Fireworks
 * @package Hashemi\Fireworks
 */
trait Fireworks
{
    protected static function boot(): void
    {
        parent::boot();

        $self = (new self);

        // before event list
        $beforeEvents = ['creating', 'updating', 'saving', 'deleting'];
        // after event list
        $afterEvents  = ['retrieved', 'created', 'updated', 'saved', 'deleted'];

        foreach ($beforeEvents as $event) {
            static::{$event}(function (Model $model) use ($self, $event) {
                $method = sprintf('onModel%s', Str::studly($event));
                $self->callBeforeEvent($model, $event);
                if (method_exists($model, $method)) {
                    call_user_func_array([$model, $method], [$model]);
                }
            });
        }

        foreach ($afterEvents as $event) {
            static::{$event}(function (Model $model) use ($self, $event) {
                $method = sprintf('onModel%s', Str::studly($event));
                if (method_exists($model, $method)) {
                    call_user_func_array([$model, $method], [$model]);
                }
                $self->callAfterEvent($model, $event);
            });
        }
    }

    /**
     * @param Model $model
     * @param string $event
     */
    private function callBeforeEvent(Model $model, string $event): void
    {
        $this->callColumnsEvent($model, ('onModel%s' . Str::studly($event)));
    }

    /**
     * @param Model $model
     * @param string $event
     */
    private function callAfterEvent(Model $model, string $event): void
    {
        $this->callColumnsEvent($model, ('onModel%s'.Str::studly($event)));
    }

    /**
     * @param Model $model
     * @param string $methodConvention
     */
    private function callColumnsEvent(Model $model, string $methodConvention): void
    {
        foreach ($model->getDirty() ?? [] as $column => $newValue) {
            $method = sprintf($methodConvention, Str::studly($column));
            if (method_exists($model, $method)) {
                call_user_func_array([$model, $method], [$model, $model->getOriginal($column), $newValue]);
            }
        }
    }
}