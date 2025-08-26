@props([
'responsive' => false,
'soft' => false,
'outline' => false,
'dash' => false,
'active' => false,
'wide' => false,
'link' => false,
'ghost' => false,
'square' => false,
'circle' => false,
'block' => false,
])

@php
$classes = 'btn';
if ($responsive) {
$classes .= ' btn-xs sm:btn-sm md:btn-md lg:btn-lg xl:btn-xl';
}
if ($soft) {
$classes .= ' btn-soft';
}
if ($outline) {
$classes .= ' btn-outline';
}
if ($dash) {
$classes .= ' btn-dash';
}
if ($active) {
$classes .= ' btn-active';
}
if ($wide) {
$classes .= ' btn-wide';
}
if ($link) {
$classes .= ' btn-link';
}
if ($ghost) {
$classes .= ' btn-ghost';
}
if ($square) {
$classes .= ' btn-square';
}
if ($circle) {
$classes .= ' btn-circle';
}
if ($block) {
$classes .= ' btn-block';
}
@endphp

<button {!! $attributes->merge(['class' => $classes]) !!}>
    {{ $slot }}
</button>