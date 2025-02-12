<div class="bg-gray-900 text-white min-h-screen p-8">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-8">TURNO ACTUAL</h2>
        
        <div class="grid grid-cols-2 gap-8 text-center">
            <div class="bg-blue-600 p-6 rounded-lg">
                <div class="text-2xl mb-2">Turno</div>
                <div class="text-6xl font-bold">001</div>
            </div>
            
            <div class="bg-green-600 p-6 rounded-lg">
                <div class="text-2xl mb-2">Módulo</div>
                <div class="text-6xl font-bold">1</div>
            </div>
        </div>

        <div class="mt-12">
            <h3 class="text-2xl text-center mb-4">PRÓXIMOS TURNOS</h3>
            <div class="grid gap-4">
                @foreach([2, 3, 4] as $ticket)
                    <div class="bg-gray-800 p-4 rounded-lg flex justify-between items-center">
                        <div class="text-xl">Turno 00{{ $ticket }}</div>
                        <div class="text-xl">Módulo 1</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>