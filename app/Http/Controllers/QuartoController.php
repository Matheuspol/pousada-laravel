<?php

namespace App\Http\Controllers;

use App\Models\Quarto;
use App\Models\CategoriaQuarto;
use Illuminate\Http\Request;

class QuartoController extends Controller
{
    public function index(Request $request)
    {
        $busca  = $request->input('busca');
        $status = $request->input('status');

        $quartos = Quarto::with('categoria')
            ->when($busca, function ($query, $busca) {
                $query->where('numero', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('numero')
            ->paginate(10)
            ->withQueryString();

        return view('quartos.index', compact('quartos', 'busca', 'status'));
    }

    public function create()
    {
        $categorias = CategoriaQuarto::orderBy('nome')->get();
        return view('quartos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero'       => 'required|string|max:10|unique:quartos,numero',
            'categoria_id' => 'required|exists:categorias_quarto,id',
            'preco_diaria' => 'required|numeric|min:0',
            'status'       => 'required|in:disponivel,ocupado,manutencao',
            'descricao'    => 'nullable|string',
        ], [
            'numero.required'       => 'O número do quarto é obrigatório.',
            'numero.unique'         => 'Este número de quarto já existe.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists'   => 'Categoria inválida.',
            'preco_diaria.required' => 'O preço da diária é obrigatório.',
            'status.required'       => 'O status é obrigatório.',
        ]);

        Quarto::create($data);

        return redirect()->route('quartos.index')
            ->with('success', 'Quarto cadastrado com sucesso!');
    }

    public function show(string $id)
    {
        $realId = decrypt($id);
        $quarto = Quarto::with('categoria')->findOrFail($realId);
        return view('quartos.show', compact('quarto'));
    }

    public function edit(string $id)
    {
        $realId     = decrypt($id);
        $quarto     = Quarto::findOrFail($realId);
        $categorias = CategoriaQuarto::orderBy('nome')->get();
        return view('quartos.edit', compact('quarto', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $realId = decrypt($id);
        $quarto = Quarto::findOrFail($realId);

        $data = $request->validate([
            'numero'       => 'required|string|max:10|unique:quartos,numero,' . $quarto->id,
            'categoria_id' => 'required|exists:categorias_quarto,id',
            'preco_diaria' => 'required|numeric|min:0',
            'status'       => 'required|in:disponivel,ocupado,manutencao',
            'descricao'    => 'nullable|string',
        ]);

        $quarto->update($data);

        return redirect()->route('quartos.index')
            ->with('success', 'Quarto atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $realId = decrypt($id);
        $quarto = Quarto::findOrFail($realId);

        if ($quarto->reservas()->exists()) {
            return back()->with('error', 'Não é possível excluir: há reservas vinculadas a este quarto.');
        }

        $quarto->delete();

        return redirect()->route('quartos.index')
            ->with('success', 'Quarto excluído com sucesso!');
    }
}
