<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    {{ __('Landlord Management') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Manage all registered landlords and their properties.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-8 text-slate-900">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-400">Landlord</th>
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-400">Email</th>
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-400">Properties</th>
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-400">Joined</th>
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse ($landlords as $landlord)
                                    <tr class="group hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 rounded-full bg-pink-50 flex items-center justify-center text-pink-600 font-bold border border-pink-100 overflow-hidden shrink-0">
                                                    @if($landlord->profile_photo_path)
                                                        <img src="{{ asset('storage/' . $landlord->profile_photo_path) }}" class="h-full w-full object-cover">
                                                    @else
                                                        {{ substr($landlord->name, 0, 1) }}
                                                    @endif
                                                </div>
                                                <span class="font-semibold text-slate-900">{{ $landlord->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-slate-600">{{ $landlord->email }}</td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                                                {{ $landlord->boarding_houses_count }} {{ Str::plural('House', $landlord->boarding_houses_count) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-slate-500 text-sm">
                                            {{ $landlord->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.users.edit', $landlord) }}" class="p-2 text-slate-400 hover:text-pink-600 transition-colors rounded-lg hover:bg-pink-50" title="Edit User">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $landlord) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this landlord? All their listings will be affected.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors rounded-lg hover:bg-rose-50" title="Delete User">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <p>No landlords found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $landlords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
