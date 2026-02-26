@php
    $flashes = [];
    foreach (['success', 'error', 'warning', 'info'] as $t) {
        if (session()->has($t)) {
            $flashes[] = ['type' => $t, 'message' => session($t)];
        }
    }
    if (session()->has('status')) {
        $flashes[] = ['type' => 'info', 'message' => session('status')];
    }
@endphp

<div
    x-data="toastManager()"
    x-init="init({{ json_encode($flashes) }})"
    class="fixed bottom-4 right-4 z-50 flex flex-col gap-3 items-end pointer-events-none"
    aria-live="polite"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            @mouseenter="pause(toast)"
            @mouseleave="resume(toast)"
            :class="typeClasses(toast.type)"
            class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg min-w-64 max-w-sm pointer-events-auto"
        >
            <span x-html="typeIcon(toast.type)" class="shrink-0 mt-0.5"></span>
            <span class="flex-1 text-sm font-medium leading-relaxed" x-text="toast.message"></span>
            <button @click="dismiss(toast)" class="shrink-0 opacity-60 hover:opacity-100 transition-opacity text-lg leading-none">&times;</button>
        </div>
    </template>
</div>
