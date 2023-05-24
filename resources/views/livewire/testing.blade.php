<div>
    {{ tenant()->getTenantKey() }}
    <input wire:model="message" type="text">
    MESSAGE: {{ $message }}
</div>
