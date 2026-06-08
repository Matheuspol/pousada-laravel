<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospedeController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $hospedes = Hospede::when($busca, function ($query, $busca) {
            $query->where('nome', 'like', "%{$busca}%")
                ->orWhere('cpf', 'like', "%{$busca}%")
                ->orWhere('email', 'like', "%{$busca}%")
                ->orWhere('cidade', 'like', "%{$busca}%");
        })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('hospedes.index', compact('hospedes', 'busca'));
    }

    public function create()
    {
        return view('hospedes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'     => 'required|string|max:150',
            'cpf'      => 'required|string|max:14|unique:hospedes,cpf',
            'email'    => 'nullable|email|max:150|unique:hospedes,email',
            'telefone' => 'nullable|string|max:20',
            'cidade'   => 'nullable|string|max:100',
            'estado'   => 'nullable|string|size:2',
            'anexo'    => 'nullable|mimes:pdf|max:2048',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.required'  => 'O CPF é obrigatório.',
            'cpf.unique'    => 'Este CPF já está cadastrado.',
            'email.unique'  => 'Este e-mail já está em uso.',
            'email.email'   => 'Informe um e-mail válido.',
        ]);

        // Faz upload do PDF
        if ($request->hasFile('anexo')) {
            $data['anexo'] = $request->file('anexo')
                ->store('hospedes', 'public');
        }

        Hospede::create($data);

        return redirect()->route('hospedes.index')
            ->with('success', 'Hóspede cadastrado com sucesso!');
    }

    public function show(string $id)
    {
        $realId  = decrypt($id);
        $hospede = Hospede::findOrFail($realId);

        return view('hospedes.show', compact('hospede'));
    }

    public function edit(string $id)
    {
        $realId  = decrypt($id);
        $hospede = Hospede::findOrFail($realId);

        return view('hospedes.edit', compact('hospede'));
    }

    public function update(Request $request, string $id)
    {
        $realId  = decrypt($id);
        $hospede = Hospede::findOrFail($realId);

        $data = $request->validate([
            'nome'     => 'required|string|max:150',
            'cpf'      => 'required|string|max:14|unique:hospedes,cpf,' . $hospede->id,
            'email'    => 'nullable|email|max:150|unique:hospedes,email,' . $hospede->id,
            'telefone' => 'nullable|string|max:20',
            'cidade'   => 'nullable|string|max:100',
            'estado'   => 'nullable|string|size:2',
            'anexo'    => 'nullable|mimes:pdf|max:2048',
        ]);

        // Substitui o PDF antigo
        if ($request->hasFile('anexo')) {

            if ($hospede->anexo) {
                Storage::disk('public')->delete($hospede->anexo);
            }

            $data['anexo'] = $request->file('anexo')
                ->store('hospedes', 'public');
        }

        $hospede->update($data);

        return redirect()->route('hospedes.index')
            ->with('success', 'Hóspede atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $realId  = decrypt($id);
        $hospede = Hospede::findOrFail($realId);

        if ($hospede->reservas()->exists()) {
            return back()->with('error', 'Não é possível excluir: há reservas vinculadas a este hóspede.');
        }

        // Remove o PDF ao excluir o hóspede
        if ($hospede->anexo) {
            Storage::disk('public')->delete($hospede->anexo);
        }

        $hospede->delete();

        return redirect()->route('hospedes.index')
            ->with('success', 'Hóspede excluído com sucesso!');
    }
}