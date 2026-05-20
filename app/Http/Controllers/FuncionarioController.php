<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $funcionarios = Funcionario::when($busca, function ($query, $busca) {
                $query->where('nome', 'like', "%{$busca}%")
                      ->orWhere('cpf', 'like', "%{$busca}%")
                      ->orWhere('cargo', 'like', "%{$busca}%");
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('funcionarios.index', compact('funcionarios', 'busca'));
    }

    public function create()
    {
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'     => 'required|string|max:150',
            'cpf'      => 'required|string|max:14|unique:funcionarios,cpf',
            'cargo'    => 'required|string|max:80',
            'email'    => 'nullable|email|max:150|unique:funcionarios,email',
            'telefone' => 'nullable|string|max:20',
        ], [
            'nome.required'  => 'O nome é obrigatório.',
            'cpf.required'   => 'O CPF é obrigatório.',
            'cpf.unique'     => 'Este CPF já está cadastrado.',
            'cargo.required' => 'O cargo é obrigatório.',
            'email.unique'   => 'Este e-mail já está em uso.',
        ]);

        Funcionario::create($data);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function show(string $id)
    {
        $realId      = decrypt($id);
        $funcionario = Funcionario::findOrFail($realId);
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(string $id)
    {
        $realId      = decrypt($id);
        $funcionario = Funcionario::findOrFail($realId);
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, string $id)
    {
        $realId      = decrypt($id);
        $funcionario = Funcionario::findOrFail($realId);

        $data = $request->validate([
            'nome'     => 'required|string|max:150',
            'cpf'      => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'cargo'    => 'required|string|max:80',
            'email'    => 'nullable|email|max:150|unique:funcionarios,email,' . $funcionario->id,
            'telefone' => 'nullable|string|max:20',
        ]);

        $funcionario->update($data);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $realId      = decrypt($id);
        $funcionario = Funcionario::findOrFail($realId);

        if ($funcionario->reservas()->exists()) {
            return back()->with('error', 'Não é possível excluir: há reservas vinculadas a este funcionário.');
        }

        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário excluído com sucesso!');
    }
}
