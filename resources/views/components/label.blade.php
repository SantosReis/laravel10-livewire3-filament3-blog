@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-yellow-500']) }}>
    {{ $value ?? $slot }}
</label>
