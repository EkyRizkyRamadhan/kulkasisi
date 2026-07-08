@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white border-slate-300 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm placeholder-slate-400']) }}>
