@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-secondary/50 bg-white/10 text-primary placeholder-primary/50 focus:border-secondary focus:ring-secondary rounded-md shadow-sm']) }}>
