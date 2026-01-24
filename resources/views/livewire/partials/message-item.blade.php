<div>
    @if ($msg->sender_id == auth()->id())
        <!-- Sender Message (Current User) -->
        <div class="flex justify-end" wire:key="message-{{ $msg->id }}">
            <div class="max-w-xs lg:max-w-md relative"
                 x-data="{
                     showMenu: false,
                     open: false
                 }"
                 @click="if(!open) showMenu = !showMenu"
                 x-init="$watch('open', value => { if(value) showMenu = true })">
                <div class="flex items-center justify-end">
                    <div class="bg-blue-500 text-white rounded-lg p-3 rounded-br-none">
                        <p>{{ $msg->message }}</p>
                    </div>
                    <!-- Three-dot button - Hidden by default -->
                    <div class="ml-2 relative" x-show="showMenu" x-transition>
                        <button @click.stop="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                            <button class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                    @click="open = false; $wire.deleteForMe({{ $msg->id }})">
                                Delete for me
                            </button>

                            <button class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                    @click="open = false; $wire.deleteForEveryone({{ $msg->id }})">
                                Delete for everyone
                            </button>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 text-right mt-1">
                    {{-- {{ $msg->created_at->format('h:i A') }} --}}
                </p>
            </div>
        </div>
    @else
        <!-- Receiver Message -->
        <div class="flex justify-start" wire:key="message-{{ $msg->id }}">
            <div class="max-w-xs lg:max-w-md relative"
                 x-data="{
                     showMenu: false,
                     open: false
                 }"
                 @click="if(!open) showMenu = !showMenu"
                 x-init="$watch('open', value => { if(value) showMenu = true })">
                <div class="flex items-center">
                    <div class="bg-gray-200 text-gray-800 rounded-lg p-3 rounded-bl-none">
                        <p>{{ $msg->message }}</p>
                    </div>
                    <!-- Three-dot button - Hidden by default -->
                    <div class="ml-2 relative" x-show="showMenu" x-transition>
                        <button @click.stop="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                            <button class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                    @click="open = false; $wire.deleteForMe({{ $msg->id }})">
                                Delete for me
                            </button>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    {{-- {{ $msg->created_at->format('h:i A') }} --}}
                </p>
            </div>
        </div>
    @endif
</div>
