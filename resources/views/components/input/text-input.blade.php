@props([
'disabled' => false,
'withLabel' => false,
'labelText' => '',
'badgeText' => '',
])

@if ($withLabel)
<label class="input text-base-content">
    @if ($labelText)
    <span class="mr-2">{{ $labelText }}</span>
    @endif

    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'grow']) !!}
    />

    @if ($badgeText)
    <span class="badge badge-neutral badge-xs ml-2">{{ $badgeText }}</span>
    @endif
</label>
@else
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'input text-base-content']) !!}
/>
@endif