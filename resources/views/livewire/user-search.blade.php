<div class="form-input relative">
    <div class="flex gap-2">
        <input
            type="text"
            wire:model.live="name"
            placeholder="Search for a registered user by name"
        >
        <button wire:click.prevent="select()" class="btn btn-sm">{{ $buttonText }}</button>
    </div>
    <div class="bg-gray-700 rounded-md border border-white border-t-0 absolute w-full z-10 {{ is_null($user) && (count($results) > 0 || Str::length($name) > 1) ? 'block' : 'hidden' }}">
        @if (count($results) === 0 && is_null($user))
            <div class="p-2 text-gray-400">No users found for <i>{{ $name }}</i></div>
        @endif
        @foreach ($results as $result)
            <div class="p-2"><a wire:click.prevent="found({{$result->id}})" class="text-sm block cursor-pointer text-gray-200 hover:text-white">{{ $result->name }}</a></div>
            {{-- <div class="p-2"><a wire:click.prevent="dispatch('user-search:user-found')" class="block cursor-pointer text-gray-200 hover:text-white">{{ $result->name }}</a></div> --}}
        @endforeach
    </div>
</div>
