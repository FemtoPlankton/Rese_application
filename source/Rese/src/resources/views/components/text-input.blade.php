@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-x-0 border-t-0 border-gray-300 focus:ring-0 focus:border-tranceparent']) !!}>
