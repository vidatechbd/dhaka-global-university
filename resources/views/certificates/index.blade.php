@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">
    @if(auth()->user()->hasRole('Student'))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-[#0f172a] leading-tight">
                {{ __('My Certificates') }}
            </h2>
        </x-slot>

        <div class="py-6 max-w-7xl mx-auto">
            <div class="bg-white border border-slate-200 overflow-hidden shadow-sm sm:rounded-2xl p-6">
                <h3 class="text-lg font-bold text-[#0f172a] mb-4">{{ __('My Issued Certificates') }}</h3>
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">{{ __('Title/Subject') }}</th>
                                <th class="px-6 py-3 text-left">{{ __('Issued By') }}</th>
                                <th class="px-6 py-3 text-left">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                            @forelse($certificates as $certificate)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-[#0f172a]">{{ $certificate->subject }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $certificate->creator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $certificate->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium space-x-3">
                                        <a href="{{ route('certificates.show', $certificate) }}" class="text-[#0a3a60] hover:text-[#072740] font-bold">{{ __('View') }}</a>
                                        <a href="{{ route('certificates.show', $certificate) }}?print=true" target="_blank" class="text-[#d97d10] hover:text-[#f7941d] font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            {{ __('Download') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 italic">{{ __('No certificates found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Admin / Teacher Full Width Certificate Page -->
        <style>
            @media print {
                body * { visibility: hidden; }
                #sidebar, header, #form-section, .no-print, nav { display: none !important; }
                #certificate-section, #certificate-section * { visibility: visible; }
                #certificate-section {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    box-shadow: none;
                    border: none;
                }
                body { background-color: white; }
                @page { size: A4 landscape; margin: 15mm; }
                .print-border { border-color: #000 !important; }
            }
        </style>

        <div class="flex flex-col gap-6 w-full">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-semibold rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-xs font-semibold rounded-r-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Generated Certificates List Table (Full Width) -->
            <x-admin.card title="All Generated Certificates" subtitle="Every certificate issued on the portal." icon="ph-bold ph-certificate">
                <x-slot name="actions">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-admin.btn href="{{ route('certificates.create') }}" variant="primary" size="sm">
                            <i class="ph-bold ph-plus text-xs"></i>
                            Generate Certificate
                        </x-admin.btn>
                    </div>
                </x-slot>

                <div class="overflow-x-auto">
                    <table class="w-full text-left admin-table">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                                <th class="px-6 py-4 text-center" style="width: 48px;">#</th>
                                <th class="px-6 py-4">{{ __('Student Name') }}</th>
                                <th class="px-6 py-4">{{ __('Subject') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('Roll') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('CGPA') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                            @forelse($certificates as $index => $certificate)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 text-center text-slate-400 font-medium" data-label="#">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-800" data-label="Student Name">{{ $certificate->name }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-700" data-label="Subject">{{ $certificate->subject }}</td>
                                    <td class="px-6 py-4 text-center font-mono text-slate-500" data-label="Roll">{{ $certificate->roll }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-800" data-label="CGPA">{{ $certificate->cgpa }} / {{ $certificate->out_of }}</td>
                                    <td class="px-6 py-4 text-center" data-label="Status">
                                        <x-admin.badge color="navy">Generated</x-admin.badge>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap" data-label="">
                                        <div class="inline-flex items-center gap-1.5 justify-end">
                                            <a href="{{ route('certificates.show', $certificate) }}" class="inline-flex items-center justify-center p-2 bg-[#e0edf7] hover:bg-[#d0e2f2] text-primary rounded-lg transition" title="View Certificate">
                                                <i class="ph-bold ph-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('certificates.show', $certificate) }}?print=true" target="_blank" class="inline-flex items-center justify-center p-2 bg-[#fde9d0] hover:bg-[#fad9a8] text-[#d97d10] rounded-lg transition" title="Download PDF">
                                                <i class="ph-bold ph-download-simple text-xs"></i>
                                            </a>
                                            <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this certificate?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition" title="Delete Certificate">
                                                    <i class="ph-bold ph-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" data-label="" class="px-6 py-14 text-center">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                                <i class="ph-bold ph-certificate text-2xl"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-500">{{ __('No certificates generated yet.') }}</span>
                                            <x-admin.btn href="{{ route('certificates.create') }}" variant="primary" size="sm" class="mt-1">
                                                Generate your first certificate
                                            </x-admin.btn>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-admin.card>
        </div>
    @endif
</x-dynamic-component>
