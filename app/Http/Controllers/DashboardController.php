<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'user' => \Illuminate\Support\Facades\Auth::user(),
            'stats' => [
                'total_clientes' => \App\Models\Cliente::count(),
                'ordens_abertas' => \App\Models\OrdemServico::whereIn('status', ['pendente', 'em_andamento'])->count(),
                'orcamentos_pendentes' => \App\Models\Orcamento::where('status', 'pendente')->count(),
            ]
        ]);
    }
}
