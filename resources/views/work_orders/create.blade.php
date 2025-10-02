<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold">Nueva orden</h1>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <form method="POST" action="{{ route('work-orders.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Título</label>
                <input name="title" class="w-full rounded border px-3 py-2" value="{{ old('title') }}" required>
                @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Descripción</label>
                <textarea name="description" class="w-full rounded border px-3 py-2" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Asignado a (ID)</label>
                    <input name="assigned_to" type="number" class="w-full rounded border px-3 py-2" value="{{ old('assigned_to') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Estado</label>
                    <select name="status" class="w-full rounded border px-3 py-2">
                        @foreach (['pendiente','en_progreso','completada','cancelada'] as $s)
                            <option value="{{ $s }}" @selected(old('status')===$s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Fecha límite</label>
                    <input name="due_date" type="datetime-local" class="w-full rounded border px-3 py-2" value="{{ old('due_date') }}">
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('work-orders.index') }}" class="inline-flex items-center rounded-md px-4 py-2 border">Cancelar</a>
                <button class="inline-flex items-center rounded-md px-4 py-2 border bg-gray-900 text-white">Crear</button>
            </div>
        </form>
    </div>
</x-app-layout>