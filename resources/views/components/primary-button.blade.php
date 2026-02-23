<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-primary uppercase tracking-widest hover:bg-secondary/80 focus:bg-secondary/80 active:bg-secondary focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 focus:ring-offset-accent transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
