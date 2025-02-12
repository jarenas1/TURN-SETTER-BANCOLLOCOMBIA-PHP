<div class="min-h-screen bg-gray-100 p-8">
    <!-- Encabezado -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-blue-800 mb-2">IPAD VIEW TO GET A TURN</h1>
        <p class="text-xl text-gray-600">Por favor selecciona un turno</p>
    </div>

    <!-- Tarjeta de servicios -->
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid grid-cols-2 gap-4">
            @foreach($services as $service)
                <button 
                    wire:click="$set('selectedService', {{ $service->id }})"
                    class="p-4 border-2 rounded-lg text-center hover:bg-blue-50 transition-colors
                           {{ $selectedService == $service->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}"
                >
                    <span class="text-lg font-semibold text-gray-700">{{ $service->name }}</span>
                    @if($service->code)
                        <div class="text-sm text-gray-500 mt-1">{{ $service->code }}</div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <!-- Sección de documento -->
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Ingrese su número de documento</label>
            <input 
                type="number" 
                wire:model="documentNumber"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ej: 12345678"
            >
        </div>
        
        <button 
            wire:click="generateTicket"
            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors"
        >
            Generar Turno
        </button>
    </div>

    <!-- Turno asignado -->
    @if($assignedTicket)
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Su turno asignado es:</h3>
            <div class="text-6xl font-bold text-blue-600">{{ $assignedTicket }}</div>
            <p class="text-sm text-gray-500 mt-4">Base fomos indicaciones con tercera</p>
        </div>
    @endif
</div>