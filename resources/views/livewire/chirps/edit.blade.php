<?php

use Livewire\Volt\Component;
use App\Models\Chirp;
use Livewire\Attributes\Validate;

new class extends Component {

    public Chirp $chirp;

    #[Validate('required|string|min:15|max:255')]
    public string $message = '';

    public function mount(Chirp $chirp)
    {
        $this->message = $chirp->message;
    }

    public function update()
    {
        $this->authorize('update', $this->chirp);
        $validated = $this->validate();
        $this->chirp->update($validated);
        $this->dispatch('chirpUpdated');
    }

    public function cancel()
    {
        $this->dispatch('chirpEditCanceled');
    }
}; ?>

<div>
    <form wire:submit="update">

        <textarea wire:model="message"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            placeholder="Update your message..."></textarea>

        <x-input-error :messages="$errors->get('message')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        <x-secondary-button wire:click="cancel">{{ __('Cancel') }}</x-secondary-button>
    </form>
</div>