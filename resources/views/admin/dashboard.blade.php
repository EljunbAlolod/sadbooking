<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    {{ __('Platform Analytics') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Real-time overview of your boarding house ecosystem.</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                    Live System
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">


                <a href="{{ route('admin.landlords.index') }}"
                    class="group bg-white shadow-sm sm:rounded-3xl p-8 border border-slate-100 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-50/50 transition-all relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-pink-50/50 transition-colors">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <p
                                class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-pink-600 transition-colors">
                                {{ __('Landlords') }}</p>
                        </div>
                        <p class="text-4xl font-bold text-slate-900 leading-none">{{ $userCounts['landlord'] }}</p>
                        <p
                            class="text-sm text-slate-400 mt-4 group-hover:text-pink-500 transition-colors flex items-center gap-1">
                            Manage accounts
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.tenants.index') }}"
                    class="group bg-white shadow-sm sm:rounded-3xl p-8 border border-slate-100 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-50/50 transition-all relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-pink-50/50 transition-colors">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <p
                                class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-pink-600 transition-colors">
                                {{ __('Tenants') }}</p>
                        </div>
                        <p class="text-4xl font-bold text-slate-900 leading-none">{{ $userCounts['tenant'] }}</p>
                        <p
                            class="text-sm text-slate-400 mt-4 group-hover:text-pink-500 transition-colors flex items-center gap-1">
                            Manage accounts
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </p>
                    </div>
                </a>

                <div
                    class="bg-white shadow-sm sm:rounded-3xl p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-pink-50/50 transition-colors">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                            {{ __('Boarding Houses') }}</p>
                        <p class="text-4xl font-bold text-slate-900 leading-none">{{ $boardingHouseCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- User Growth Chart -->
                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-3xl p-8 border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="font-bold text-lg text-slate-900">User Registration Trend</h3>
                            <p class="text-sm text-slate-500">Monthly growth of landlords and tenants.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-pink-600"></span>
                                <span class="text-xs font-semibold text-slate-600 uppercase">Tenants</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                                <span class="text-xs font-semibold text-slate-600 uppercase">Landlords</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-80 w-full">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>

                <!-- Reservation Pie Chart -->
                <div class="bg-white shadow-sm sm:rounded-3xl p-8 border border-slate-100">
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Reservation Status</h3>
                    <p class="text-sm text-slate-500 mb-8">Overall distribution of all time bookings.</p>
                    <div class="h-64 w-full relative flex items-center justify-center">
                        <canvas id="reservationStatusChart"></canvas>
                    </div>
                    <div class="mt-8 space-y-3">
                        @foreach($reservationStats['labels'] as $index => $label)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full"
                                        style="background-color: {{ $reservationStats['colors'][$index] }}"></span>
                                    <span class="text-slate-600">{{ $label }}</span>
                                </div>
                                <span class="font-bold text-slate-900">{{ $reservationStats['data'][$index] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Recent Landlords -->
                <div class="bg-white shadow-sm sm:rounded-3xl border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-lg text-slate-900">Newest Landlords</h3>
                        <a href="{{ route('admin.landlords.index') }}"
                            class="text-sm font-bold text-pink-600 hover:text-pink-700 transition-colors">View
                            all</a>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($recentLandlords as $landlord)
                            <div class="p-6 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-pink-50 flex items-center justify-center text-pink-600 font-bold border border-pink-100 overflow-hidden shrink-0">
                                        @if($landlord->profile_photo_path)
                                            <img src="{{ asset('storage/' . $landlord->profile_photo_path) }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            {{ substr($landlord->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 leading-none">{{ $landlord->name }}</p>
                                        <p class="text-xs text-slate-400 mt-1">{{ $landlord->email }}</p>
                                    </div>
                                </div>
                                <span
                                    class="text-xs text-slate-400 font-medium">{{ $landlord->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 text-sm">No recent activity.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Tenants -->
                <div class="bg-white shadow-sm sm:rounded-3xl border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-lg text-slate-900">Newest Tenants</h3>
                        <a href="{{ route('admin.tenants.index') }}"
                            class="text-sm font-bold text-pink-600 hover:text-pink-700 transition-colors">View
                            all</a>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($recentTenants as $tenant)
                            <div class="p-6 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 font-bold border border-slate-100 overflow-hidden shrink-0">
                                        @if($tenant->profile_photo_path)
                                            <img src="{{ asset('storage/' . $tenant->profile_photo_path) }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            {{ substr($tenant->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 leading-none">{{ $tenant->name }}</p>
                                        <p class="text-xs text-slate-400 mt-1">{{ $tenant->email }}</p>
                                    </div>
                                </div>
                                <span
                                    class="text-xs text-slate-400 font-medium">{{ $tenant->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 text-sm">No recent activity.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // User Growth Chart
                const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
                new Chart(growthCtx, {
                    type: 'line',
                    data: {
                        labels: @json($registrationTrend['labels']),
                        datasets: [
                            {
                                label: 'Tenants',
                                data: @json($registrationTrend['tenants']),
                                borderColor: '#db2777',
                                backgroundColor: 'rgba(219, 39, 119, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#db2777',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Landlords',
                                data: @json($registrationTrend['landlords']),
                                borderColor: '#94a3b8',
                                backgroundColor: 'rgba(148, 163, 184, 0.05)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9' },
                                ticks: { font: { size: 11 }, color: '#64748b' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11 }, color: '#64748b' }
                            }
                        }
                    }
                });

                // Reservation Status Chart
                const statusCtx = document.getElementById('reservationStatusChart').getContext('2d');
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($reservationStats['labels']),
                        datasets: [{
                            data: @json($reservationStats['data']),
                            backgroundColor: @json($reservationStats['colors']),
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
