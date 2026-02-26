<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-accent">My CVs</h1>
            <a href="{{ route('cv.create') }}"
               class="bg-accent text-primary text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-secondary transition-colors duration-150">
                + New CV
            </a>
        </div>

        {{-- Empty state --}}
        @if($cvs->isEmpty())
            <div class="text-center py-24 border-2 border-dashed border-secondary/40 rounded-2xl">
                <svg class="mx-auto mb-4 text-secondary/50" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                <p class="text-gray-500 mb-4">You haven't created any CVs yet.</p>
                <a href="{{ route('cv.create') }}"
                   class="bg-accent text-primary text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-secondary transition-colors duration-150">
                    Create your first CV
                </a>
            </div>

        {{-- CV Grid --}}
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cvs as $cv)
                    <div class="bg-white rounded-2xl shadow-sm border border-secondary/20 hover:shadow-md transition-shadow duration-150 flex flex-col">
                        {{-- Card header --}}
                        <div class="bg-secondary rounded-t-2xl px-5 py-4">
                            <h2 class="text-primary font-semibold truncate">{{ $cv->title }}</h2>
                            <span class="text-primary/70 text-xs">{{ ucfirst($cv->template) }} template</span>
                        </div>

                        {{-- Card body --}}
                        <div class="px-5 py-4 flex-1">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium text-accent">Name:</span>
                                {{ $cv->personal_info['name'] ?? '—' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                <span class="font-medium text-accent">Email:</span>
                                {{ $cv->personal_info['email'] ?? '—' }}
                            </p>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @if(!empty($cv->experience))
                                    <span class="text-xs bg-secondary/15 text-accent px-2 py-0.5 rounded-full">{{ count($cv->experience) }} exp</span>
                                @endif
                                @if(!empty($cv->education))
                                    <span class="text-xs bg-secondary/15 text-accent px-2 py-0.5 rounded-full">{{ count($cv->education) }} edu</span>
                                @endif
                                @if(!empty($cv->skills))
                                    <span class="text-xs bg-secondary/15 text-accent px-2 py-0.5 rounded-full">{{ count($cv->skills) }} skills</span>
                                @endif
                            </div>
                        </div>

                        {{-- Card footer --}}
                        <div class="px-5 py-3 border-t border-secondary/20 flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                {{ ($cv->last_edited_at ?? $cv->created_at)?->diffForHumans() ?? 'just now' }}
                            </span>
                            <a href="{{ route('cv.show', $cv) }}"
                               class="text-sm font-medium text-secondary hover:text-accent transition-colors duration-150">
                                View →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($cvs->hasPages())
                <div class="mt-8">
                    {{ $cvs->links() }}
                </div>
            @endif
        @endif

    </div>
</x-app-layout>
