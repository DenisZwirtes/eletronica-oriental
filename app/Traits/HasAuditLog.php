<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait HasAuditLog
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getActivityDescription(string $eventName): string
    {
        $modelName = class_basename($this);

        return match($eventName) {
            'created' => "{$modelName} foi criado",
            'updated' => "{$modelName} foi atualizado",
            'deleted' => "{$modelName} foi deletado",
            default => "{$modelName} foi {$eventName}"
        };
    }

    public function getActivityProperties(): array
    {
        return $this->getDirty();
    }

    public function shouldLogActivity(string $eventName): bool
    {
        return in_array($eventName, ['created', 'updated', 'deleted']);
    }

    public function getTableName(): string
    {
        return $this->getTable();
    }

    public function getStatusLabel(): string
    {
        if (isset($this->ativo)) {
            return $this->ativo ? 'Ativo' : 'Inativo';
        }

        return 'N/A';
    }
}
