<div>
    <div>
        {{ tenant()?->getTenantKey() ?? 'No tenant' }}
        <input wire:model="text" type="text">
        text: {{ $text }}
    </div>

    <br>

    <div>
        <form wire:submit.prevent="save">
            <input type="file" wire:model="photo">

            @error('photo') <span class="error">{{ $message }}</span> @enderror

            <button type="submit">Save Photo</button>
        </form>
    </div>
</div>
