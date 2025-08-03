<?php

namespace App\Services\Common;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Obtém dados do cache ou executa callback
     */
    public function remember(string $key, \Closure $callback, int $ttl = 3600): mixed
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Obtém dados do cache
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    /**
     * Armazena dados no cache
     */
    public function put(string $key, mixed $value, int $ttl = 3600): bool
    {
        return Cache::put($key, $value, $ttl);
    }

    /**
     * Remove dados do cache
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Limpa todo o cache
     */
    public function flush(): bool
    {
        return Cache::flush();
    }

    /**
     * Verifica se chave existe no cache
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Obtém estatísticas do cache
     */
    public function getStats(): array
    {
        return [
            'driver' => config('cache.default'),
            'prefix' => config('cache.prefix'),
            'stores' => array_keys(config('cache.stores')),
        ];
    }

    /**
     * Cache para dados de dashboard
     */
    public function getDashboardData(string $type, \Closure $callback): array
    {
        $key = "dashboard.{$type}";

        return $this->remember($key, $callback, 300);
    }

    /**
     * Cache para relatórios
     */
    public function getReportData(string $reportType, array $filters, \Closure $callback): array
    {
        $key = "report.{$reportType}." . md5(serialize($filters));

        return $this->remember($key, $callback, 1800);
    }

    /**
     * Cache para dados de usuário
     */
    public function getUserData(int $userId, string $dataType, \Closure $callback): mixed
    {
        $key = "user.{$userId}.{$dataType}";

        return $this->remember($key, $callback, 600);
    }

    /**
     * Invalida cache relacionado a um usuário
     */
    public function invalidateUserCache(int $userId): void
    {
        $pattern = "user.{$userId}.*";
        $this->flushPattern($pattern);
    }

    /**
     * Invalida cache de dashboard
     */
    public function invalidateDashboardCache(): void
    {
        $this->flushPattern('dashboard.*');
    }

    /**
     * Invalida cache de relatórios
     */
    public function invalidateReportCache(): void
    {
        $this->flushPattern('report.*');
    }

    /**
     * Remove cache por padrão (implementação básica)
     */
    private function flushPattern(string $pattern): void
    {
        // Implementação básica - em produção usar Redis ou similar
        $this->flush();
    }
}
