<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Work Orders') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">
        @if (session('status'))
            <div class="mb-4 rounded border p-3 text-sm bg-green-50 border-green-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('workorders.create') }}"
                class="inline-flex items-center rounded-md px-4 py-2 border text-sm font-medium hover:bg-gray-50">
                Nueva orden
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg border">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Título</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Asignado</th>
                        <th class="px-4 py-2 text-left">Fecha límite</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $wo)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $wo->id }}</td>
                            <td class="px-4 py-2">{{ $wo->title }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block rounded px-2 py-0.5 text-xs border">
                                    {{ $wo->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $wo->assigned_to ?? '—' }}</td>
                            <td class="px-4 py-2">{{ optional($wo->due_date)->format('Y-m-d H:i') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Sin órdenes todavía</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
