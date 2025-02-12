@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Gestión de Cajeros</h1>
    
    <div class="mb-4">
        <a href="{{ route('users.create') }}" 
           class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
            + Nuevo Cajero
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Taquilla</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t">
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->counter->name ?? 'Sin asignar' }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('users.edit', $user) }}" 
                            class="text-blue-500 hover:text-blue-700 mr-2">Editar</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                class="text-red-500 hover:text-red-700"
                                onclick="return confirm('¿Eliminar cajero?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection