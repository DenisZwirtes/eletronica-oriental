<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\HasUserRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUserRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo_path',
        'ativo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Relacionamento com ordens de serviço
     */
    public function ordensServico(): HasMany
    {
        return $this->hasMany(OrdemServico::class, 'tecnico_id');
    }

    /**
     * Relacionamento com orçamentos
     */
    public function orcamentos(): HasMany
    {
        return $this->hasMany(Orcamento::class, 'atendente_id');
    }

    /**
     * Escopo para usuários ativos
     */
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Escopo para usuários inativos
     */
    public function scopeInativo($query)
    {
        return $query->where('ativo', false);
    }

    /**
     * Verifica se é proprietário
     */
    public function isProprietario(): bool
    {
        return $this->hasRole('proprietario');
    }

    /**
     * Obtém o nome completo do usuário
     */
    public function getNomeCompletoAttribute(): string
    {
        return $this->name;
    }

    /**
     * Obtém a URL da foto do perfil
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return null;
    }

    /**
     * Obtém estatísticas gerais do proprietário
     */
    public function getEstatisticasGeraisAttribute(): array
    {
        return [
            'total_ordens' => OrdemServico::count(),
            'ordens_pendentes' => OrdemServico::where('status', 'pendente')->count(),
            'ordens_em_andamento' => OrdemServico::where('status', 'em_andamento')->count(),
            'ordens_concluidas' => OrdemServico::where('status', 'concluida')->count(),
            'total_orcamentos' => Orcamento::count(),
            'orcamentos_pendentes' => Orcamento::where('status', 'pendente')->count(),
            'orcamentos_aprovados' => Orcamento::where('status', 'aprovado')->count(),
            'total_clientes' => Cliente::count(),
            'total_receita' => OrdemServico::where('status', 'concluida')->sum('valor_total'),
        ];
    }
}
