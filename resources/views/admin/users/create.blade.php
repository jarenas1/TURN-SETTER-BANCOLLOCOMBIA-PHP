@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">{{ isset($user) ? 'Editar' : 'Nuevo' }} Cajero</h1>
    
    <form method="POST" 
          action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
        @csrf
        @isset($user) @method('PUT') @endisset

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label class="block mb-2">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                    class="w-full p-2 border rounded-lg">
            </div>
            
            <div>
                <label class="block mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                    class="w-full p-2 border rounded-lg">
            </div>
            
            <div>
                <label class="block mb-2">Contraseña</label>
                <input type="password" name="password" {{ isset($user) ? '' : 'required' }}
                    class="w-full p-2 border rounded-lg">
            </div>
            
            <div>
                <label class="block mb-2">Taquilla asignada</label>
                <select name="counter_id" class="w-full p-2 border rounded-lg">
                    <option value="">Sin asignar</option>
                    @foreach($counters as $counter)
                        <option value="{{ $counter->id }}" 
                            {{ ($user->counter_id ?? old('counter_id')) == $counter->id ? 'selected' : '' }}>
                            {{ $counter->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Guardar
        </button>
    </form>
</div>
@endsection