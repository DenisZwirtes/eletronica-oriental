<?php

namespace App\Services\Common;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityLoggerService
{
    /**
     * Registra uma atividade no sistema
     */
    public function log(string $action, string $description, ?User $user = null, array $context = []): void
    {
        $user = $user ?? Auth::user();

        Log::create([
            'user_id' => $user?->id,
            'action' => $action,
            'description' => $description,
            'context' => $context,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Registra login de usuário
     */
    public function logLogin(User $user): void
    {
        $this->log(
            'login',
            "Usuário {$user->name} fez login no sistema",
            $user
        );
    }

    /**
     * Registra logout de usuário
     */
    public function logLogout(User $user): void
    {
        $this->log(
            'logout',
            "Usuário {$user->name} fez logout do sistema",
            $user
        );
    }

    /**
     * Registra criação de registro
     */
    public function logCreate(string $model, string $description, array $context = [], ?User $user = null): void
    {
        $this->log(
            'create',
            "Criado {$model}: {$description}",
            $user,
            $context
        );
    }

    /**
     * Registra atualização de registro
     */
    public function logUpdate(string $model, string $description, array $context = [], ?User $user = null): void
    {
        $this->log(
            'update',
            "Atualizado {$model}: {$description}",
            $user,
            $context
        );
    }

    /**
     * Registra exclusão de registro
     */
    public function logDelete(string $model, string $description, array $context = [], ?User $user = null): void
    {
        $this->log(
            'delete',
            "Excluído {$model}: {$description}",
            $user,
            $context
        );
    }

    /**
     * Obtém logs de um usuário específico
     */
    public function getUserLogs(User $user, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return Log::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtém logs do sistema
     */
    public function getSystemLogs(int $limit = 100): \Illuminate\Database\Eloquent\Collection
    {
        return Log::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
