<div class="m-auto md:w-2/3 mb-4">
    @if (session('status'))
        <div class='text-green-600 font-bold'>
            {{ session('status') }}
        </div>        
    @endif
    <form wire:submit="save">
        <div class="form-input">
            <label class="block" for="name">Your name</label>
            <input type="text" id="name" wire:model.blur="name">
            @error('name')
                <div class="validationError">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="email">Your email</label>
            <input type="text" id="email" wire:model.blur="email">
            @error('email')
                <div class="validationError">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="subject">Subject</label>
            <input type="text" id="subject" wire:model.blur="subject" placeholder="Description of the issue">
            @error('subject')
                <div class="validationError">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="message">Your message</label>
            <textarea id="message" wire:model.blur="message" rows="4"></textarea>
            @error('message')
            <div class="validationError">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 md:flex md:flex-row-reverse md:gap-4 justify-between mt-8">
            <button type="submit" class="btn btn-primary block w-full md:w-1/3">Send mail</button>
        </div>
    </form>
</div>
