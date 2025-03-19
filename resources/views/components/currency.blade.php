@props([
    'amount' => null
])

{{ \App\Helpers\Formatter::currency($amount) }}