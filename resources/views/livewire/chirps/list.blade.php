<?php

use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Chirp;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $chirps;
    public ?Chirp $editing = null;

    /**
     * Mount the component
     * @return void
     */
    public function mount(): void
    {
        $this->getChirps();
    }

    /**
     * Get the chirps
     * @return void
     */
    #[On('chirpCreated')]
    public function getChirps(): void
    {
        $this->chirps = Chirp::with('user')
            ->latest()
            ->get();
    }

    /**
     * Edit a chirp
     * @param  App\Models\Chirp  $chirp
     * @return void
     */
    public function edit(Chirp $chirp): void
    {
        $this->editing = $chirp;
        $this->getChirps();
    }

    /**
     * Cancel the edit
     * @return void
     */
    #[On('chirpEditCanceled')]
    #[On('chirpUpdated')]
    public function cancelEdit(): void
    {
        $this->editing = null;
        $this->getChirps();
    }

    /**
     * Delete a chirp
     * @param  App\Models\Chirp  $chirp
     * @return void
     */
    public function delete(Chirp $chirp): void
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        $this->getChirps();
    }

    public function toggleLike(Chirp $chirp): void
    {
        $this->authorize('like', $chirp);
        $chirp->likedBy()->toggle(auth()->user());
        $this->getChirps();
    }
}; ?>

<div>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($chirps as $chirp)
            <div class="p-6 flex space-x-2" wire:key="{{ $chirp->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $chirp->user->name }}</span>
                            <small
                                class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($chirp->created_at->eq($chirp->updated_at))
                                <small class="ml-2 text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                        @if ($chirp->user->is(auth()->user()))
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button class="text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link wire:click="edit({{ $chirp }})">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click="delete({{ $chirp }})">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                        @endif
                        @if (auth()->user()->isNot($chirp->user))
                                        <button type="button"
                                            class="relative flex items-center space-x-1 p-1 text-gray-900 bg-gray-100 rounded-md"
                                            wire:click="toggleLike({{ $chirp }})">

                                            <svg fill="#000000" viewBox="0 0 20 20" @class([
                                'w-5 h-5 p-1 fill-gray-400' => $chirp->likedBy()->where('user_id', auth()->id())->doesntExist(),
                                'w-5 h-5 p-1 fill-blue-500' => $chirp->likedBy()->where('user_id', auth()->id())->exists()
                            ]) xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11 0h1v3l3 7v8a2 2 0 0 1-2 2H5c-1.1 0-2.31-.84-2.7-1.88L0 12v-2a2 2 0 0 1 2-2h7V2a2 2 0 0 1 2-2zm6 10h3v10h-3V10z" />
                                            </svg>
                                            <small>
                                                @if ($chirp->likedBy()->where('user_id', auth()->id())->doesntExist())
                                                    {{ __('Like') }}
                                                @else
                                                    {{ __('Liked') }}
                                                @endif
                                            </small>
                                        </button>
                        @endif
                    </div>
                    @if ($chirp->is($editing))
                        <livewire:chirps.edit :chirp="$chirp" :key="$chirp->id" />
                    @else
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    @endif
                    <span class="text-gray-400"> {{ $chirp->likedBy()->count() }} {{ __('likes') }}</span>
                </div>
            </div>
        @endforeach
    </div>