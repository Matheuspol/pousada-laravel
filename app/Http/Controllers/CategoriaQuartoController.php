<?php

namespace App\Http\Controllers;

use App\Models\CategoriaQuarto;
use Illuminate\Http\Request;

class CategoriaQuartoController extends Controller
{
    /**
     * Lista todas as categorias com paginação e pesquisa.
     */
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $categorias = CategoriaQuarto::when($busca, function ($query, $busca) {
                $query->where('nome', 'like', "%{$busca}%")
                      ->orWhere('descricao', 'like', "%{$busca}%");
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('categorias-quarto.index', compact('categorias', 'busca'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('categorias-quarto.create');
    }

    /**
     * Persiste nova categoria.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'        => 'required|string|max:100',
            'descricao'   => 'nullable|string',
            'capacidade'  => 'required|integer|min:1',
        ], [
            'nome.required'       => 'O nome é obrigatório.',
            'capacidade.required' => 'A capacidade é obrigatória.',
            'capacidade.min'      => 'A capacidade deve ser ao menos 1.',
        ]);

        CategoriaQuarto::create($data);

        return redirect()->route('categorias-quarto.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Detalhes de uma categoria.
     */
    public function show(string $id)
    {
        // Criptografia de rota: decodifica o ID
        $realId = decrypt($id);
        $categoria = CategoriaQuarto::findOrFail($realId);
        return view('categorias-quarto.show', compact('categoria'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(string $id)
    {
        $realId = decrypt($id);
        $categoria = CategoriaQuarto::findOrFail($realId);
        return view('categorias-quarto.edit', compact('categoria'));
    }

    /**
     * Atualiza a categoria.
     */
    public function update(Request $request, string $id)
    {
        $realId = decrypt($id);
        $categoria = CategoriaQuarto::findOrFail($realId);

        $data = $request->validate([
            'nome'       => 'required|string|max:100',
            'descricao'  => 'nullable|string',
            'capacidade' => 'required|integer|min:1',
        ]);

        $categoria->update($data);

        return redirect()->route('categorias-quarto.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove a categoria.
     */
    public function destroy(string $id)
    {
        $realId = decrypt($id);
        $categoria = CategoriaQuarto::findOrFail($realId);

        if ($categoria->quartos()->exists()) {
            return back()->with('error', 'Não é possível excluir: há quartos vinculados a esta categoria.');
        }

        $categoria->delete();

        return redirect()->route('categorias-quarto.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
