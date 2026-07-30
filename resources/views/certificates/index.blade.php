@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">
    @if(auth()->user()->hasRole('Student'))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Certificates') }}
            </h2>
        </x-slot>

        <div class="py-6 max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">{{ __('My Issued Certificates') }}</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Issued By') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse($certificates as $certificate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-semibold">{{ $certificate->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $certificate->creator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $certificate->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium space-x-3">
                                        <a href="{{ route('certificates.show', $certificate) }}" class="text-blue-600 hover:text-[#0a3a60] font-semibold">{{ __('View') }}</a>
                                        <a href="{{ route('certificates.show', $certificate) }}?print=true" target="_blank" class="text-green-600 hover:text-[#00875a] font-semibold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            {{ __('Download') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">{{ __('No certificates found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Admin / Teacher Full Width Certificate & Transcript Page -->
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
                @page { size: A4 portrait; margin: 15mm; }
                .print-border { border-color: #000 !important; }
            }
        </style>

        <div class="flex flex-col gap-6 w-full">
            @if(session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs font-medium rounded-r-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Generated Certificates List Table (Full Width) -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm w-full">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h2 class="text-xl font-bold text-[#072740]">{{ __('All Generated Certificates') }}</h2>
                    
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('certificates.create') }}" class="px-4 py-2 bg-[#0a3a60] hover:bg-[#072740] text-white font-bold text-xs rounded-lg shadow transition">
                            + Generate Certificate
                        </a>
                        <button type="button" class="px-4 py-1.5 bg-[#00875a] text-white font-bold text-[11px] rounded-md shadow-sm">CSV</button>
                        <button type="button" class="px-4 py-1.5 bg-[#d81b60] text-white font-bold text-[11px] rounded-md shadow-sm">Excel</button>
                        <button type="button" class="px-4 py-1.5 bg-[#f7941d] text-white font-bold text-[11px] rounded-md shadow-sm">PDF</button>
                        <button type="button" onclick="window.print()" class="px-4 py-1.5 bg-[#0070c0] text-white font-bold text-[11px] rounded-md shadow-sm">Print</button>
                    </div>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-gray-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-4 text-center">#</th>
                                <th class="px-6 py-4">Student Name</th>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Department</th>
                                <th class="px-6 py-4 text-center">Exam Roll</th>
                                <th class="px-6 py-4 text-center">Result</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs text-slate-700">
                            @forelse($certificates as $index => $certificate)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $certificate->student->name }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $certificate->title }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-600">{{ $certificate->department ?: 'CSE' }}</td>
                                    <td class="px-6 py-4 text-center font-mono">{{ $certificate->exam_roll ?: (46437 + $index) }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-900">{{ $certificate->result ?: '3.96' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-2.5 py-1 bg-green-50 border border-green-200 text-green-700 font-bold text-[10px] rounded-md tracking-wider">
                                            GENERATED
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                        <a href="{{ route('certificates.show', $certificate) }}" class="inline-flex items-center justify-center p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md transition shadow-sm" title="View Transcript">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('certificates.show', $certificate) }}?print=true" target="_blank" class="inline-flex items-center justify-center p-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-md transition shadow-sm" title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this certificate?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-md transition shadow-sm" title="Delete Certificate">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400 font-medium">
                                        {{ __('No certificates generated yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</x-dynamic-component>
