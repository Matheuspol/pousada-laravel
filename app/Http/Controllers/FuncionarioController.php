<?php

namespace App\Http\Controllers;

// Model utilizado para acessar a tabela de funcionários
use App\Models\Funcionario;

use Illuminate\Http\Request;

// Controller responsável por intermediar a comunicação entre as Views, Models e Banco de Dados
class FuncionarioController extends Controller
{
    // Exibe a listagem de funcionários
    public function index(Request $request)
    {
        // Recebe o texto informado na pesquisa
        $busca = $request->input('busca');

        // Consulta os funcionários aplicando filtros
        $funcionarios = Funcionario::when($busca, function ($query, $busca) {
            $query->where('nome', 'like', "%{$busca}%")
                ->orWhere('cpf', 'like', "%{$busca}%")
                ->orWhere('cargo', 'like', "%{$busca}%");
        })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        // Envia os dados para a View
        return view('funcionarios.index', compact('funcionarios', 'busca'));
    }

    // Carrega a tela de cadastro de funcionário
    public function create()
    {
        return view('funcionarios.create');
    }

    // Salva um novo funcionário no banco
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário
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

        // Insere o registro no banco
        Funcionario::create($data);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário cadastrado com sucesso!');
    }

    // Exibe os detalhes de um funcionário
    public function show(string $id)
    {
        // Descriptografa o ID recebido pela URL
        $realId = decrypt($id);

        // Busca o funcionário no banco
        $funcionario = Funcionario::findOrFail($realId);

        return view('funcionarios.show', compact('funcionario'));
    }

    // Carrega a tela de edição
    public function edit(string $id)
    {
        // Descriptografa o ID recebido pela URL
        $realId = decrypt($id);

        // Busca o funcionário para edição
        $funcionario = Funcionario::findOrFail($realId);

        return view('funcionarios.edit', compact('funcionario'));
    }

    // Atualiza os dados de um funcionário
    public function update(Request $request, string $id)
    {
        // Descriptografa o ID recebido pela URL
        $realId = decrypt($id);

        // Busca o funcionário no banco
        $funcionario = Funcionario::findOrFail($realId);

        // Valida os dados informados na edição
        $data = $request->validate([
            'nome'     => 'required|string|max:150',
            'cpf'      => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'cargo'    => 'required|string|max:80',
            'email'    => 'nullable|email|max:150|unique:funcionarios,email,' . $funcionario->id,
            'telefone' => 'nullable|string|max:20',
        ]);

        // Atualiza o registro no banco
        $funcionario->update($data);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    // Exclui um funcionário
    public function destroy(string $id)
    {
        // Descriptografa o ID recebido pela URL
        $realId = decrypt($id);

        // Busca o funcionário no banco
        $funcionario = Funcionario::findOrFail($realId);

        // Verifica se existem reservas vinculadas
        if ($funcionario->reservas()->exists()) {
            return back()->with(
                'error',
                'Não é possível excluir: há reservas vinculadas a este funcionário.'
            );
        }

        // Remove o registro do banco
        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário excluído com sucesso!');
    }
}