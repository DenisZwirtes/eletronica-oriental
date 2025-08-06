<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasAuditLog;

class Cliente extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf_cnpj',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamento com ordens de serviço
     */
    public function ordensServico(): HasMany
    {
        return $this->hasMany(OrdemServico::class);
    }

    /**
     * Relacionamento com orçamentos
     */
    public function orcamentos(): HasMany
    {
        return $this->hasMany(Orcamento::class);
    }

    /**
     * Escopo para clientes ativos
     */
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Escopo para clientes inativos
     */
    public function scopeInativo($query)
    {
        return $query->where('ativo', false);
    }

    /**
     * Escopo para buscar por nome
     */
    public function scopePorNome($query, string $nome)
    {
        return $query->where('nome', 'like', "%{$nome}%");
    }

    /**
     * Escopo para buscar por email
     */
    public function scopePorEmail($query, string $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }

    /**
     * Escopo para buscar por telefone
     */
    public function scopePorTelefone($query, string $telefone)
    {
        return $query->where('telefone', 'like', "%{$telefone}%");
    }

    /**
     * Obtém o nome completo do cliente
     */
    public function getNomeCompletoAttribute(): string
    {
        return $this->nome;
    }

    /**
     * Obtém o endereço completo
     */
    public function getEnderecoCompletoAttribute(): string
    {
        $endereco = $this->endereco ?? '';
        $cidade = $this->cidade ?? '';
        $estado = $this->estado ?? '';
        $cep = $this->cep ?? '';

        return trim(implode(', ', array_filter([$endereco, $cidade, $estado, $cep])));
    }

    /**
     * Verifica se o cliente tem ordens de serviço
     */
    public function temOrdensServico(): bool
    {
        return $this->ordensServico()->exists();
    }

    /**
     * Verifica se o cliente tem orçamentos
     */
    public function temOrcamentos(): bool
    {
        return $this->orcamentos()->exists();
    }

    /**
     * Obtém o total gasto pelo cliente
     */
    public function getTotalGastoAttribute(): float
    {
        return $this->ordensServico()->where('status', 'concluido')->sum('valor_total');
    }

    /**
     * Obtém a quantidade de ordens de serviço
     */
    public function getQuantidadeOrdensAttribute(): int
    {
        return $this->ordensServico()->count();
    }

    /**
     * Obtém a quantidade de orçamentos
     */
    public function getQuantidadeOrcamentosAttribute(): int
    {
        return $this->orcamentos()->count();
    }
}
