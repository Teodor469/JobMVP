const ICONS = {
    success: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
    error:   '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>',
    warning: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>',
    info:    '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
};

const TYPE_CLASSES = {
    success: 'bg-[#3a6b5a] text-[#E3E4ED]',
    error:   'bg-[#9e3535] text-[#E3E4ED]',
    warning: 'bg-[#8a5e2a] text-[#E3E4ED]',
    info:    'bg-[#7697c6] text-[#E3E4ED]',
};

const DISMISS_DELAY = 4500;
const RESUME_DELAY  = 2000;

export default function toastManager() {
    return {
        toasts: [],
        _counter: 0,

        init(flashes) {
            window.toast = (message, type = 'info') => this.add(message, type);
            flashes.forEach(f => this.$nextTick(() => this.add(f.message, f.type)));
        },

        add(message, type) {
            const toast = {
                id:      ++this._counter,
                message,
                type,
                visible: true,
                timer:   null,
            };
            this.toasts.push(toast);
            this._schedule(toast, DISMISS_DELAY);
        },

        dismiss(toast) {
            clearTimeout(toast.timer);
            toast.visible = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== toast.id);
            }, 200);
        },

        pause(toast) {
            clearTimeout(toast.timer);
        },

        resume(toast) {
            this._schedule(toast, RESUME_DELAY);
        },

        typeClasses(type) {
            return TYPE_CLASSES[type] ?? TYPE_CLASSES.info;
        },

        typeIcon(type) {
            return ICONS[type] ?? ICONS.info;
        },

        _schedule(toast, delay) {
            toast.timer = setTimeout(() => this.dismiss(toast), delay);
        },
    };
}
