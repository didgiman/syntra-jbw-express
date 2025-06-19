<div>
    <div class="flex justify-between">
        <p>
            Ticket <b>#{{ $index+1 }}</b>
            <span class="text-sm {{ $attendee->user->id !== Auth::id() ? 'text-green-500' : (!$isFirst ? 'text-red-500' : '') }}">assigned to {{ $attendee->user->name }}</span>
            <span class="text-sm">{{ $attendee->user->id === Auth::id() ? '(You)' : '' }}</span>
        </p>
        @if ($isAssigned)
            <button wire:click="changeAssignee()" class="text-sm underline cursor-pointer">Change</button>
        @endif
    </div>
    @if (!$isAssigned)
        <livewire:user-search onSelect="ticket-user-selected.{{ $attendee->id }}" />
    @endif
    <div class="text-violet-500">{{ $message }}</div>
    
    @error ('user')
        <div class="validationError">{{ $message }}</div>
    @enderror
</div>