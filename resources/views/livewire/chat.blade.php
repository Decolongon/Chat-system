<div class="flex h-screen" x-init="Echo.private('messages.{{ auth()->id() }}')
    .listen('MessageEvent', (event) => {
        $wire.refreshMessages(event);
    })">
    <!-- Users List Sidebar - Mobile responsive -->
    <div class="w-full md:w-1/4 bg-gray-100 border-r border-gray-300 flex-col flex {{ $selectedUser ? 'hidden md:flex' : 'flex' }}">
        <div class="p-4 border-b border-gray-300">
            <h2 class="text-xl font-bold">Chats</h2>
            {{-- <p class="text-sm text-gray-600">{{ auth()->user()->name }}</p> --}}
        </div>
        
        <div class="overflow-y-auto h-[calc(100vh-80px)]">
            @foreach($this->getUsers as $user)
                <button 
                    wire:click="selectUser({{ $user->id }})"
                    class="w-full p-4 flex items-center space-x-3 hover:bg-gray-200 transition duration-200 {{ $selectedUser == $user->id ? 'bg-blue-100' : '' }}"
                >
                    {{-- <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div> --}}
                    <div class="text-left">
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col {{ $selectedUser ? 'flex' : 'hidden md:flex' }}">
        @if($selectedUser)
            <!-- Chat Header with Back Button for Mobile -->
            <div class="p-4 border-b border-gray-300 bg-white">
                <div class="flex items-center space-x-3">
                    <!-- Back Button for Mobile -->
                    <button 
                        class="md:hidden mr-2"
                        wire:click="clearSelectedUser"
                        type="button"
                    >
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </button>
                    
                    {{-- <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ $selectedUserName }}
                    </div> --}}
                    <div class="flex-1">
                        <h2 class="font-bold">{{ $selectedUserName }}</h2>
                        <p class="text-sm text-gray-500">{{ $selectedUserEmail }}</p>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div 
                class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50"
                id="messages-container"
                {{-- wire:igonore --}}
            >
                @foreach($this->getMessages as $msg)
                    @if($msg->sender_id == auth()->id())
                        <!-- Sender Message (Current User) -->
                        <div class="flex justify-end" wire:key="message-{{ $msg->id }}" wire:ignore>
                            <div class="max-w-xs lg:max-w-md">
                                <div class="bg-blue-500 text-white rounded-lg p-3 rounded-br-none">
                                    <p>{{ $msg->message }}</p>
                                </div>
                                <p class="text-xs text-gray-500 text-right mt-1">
                                    {{-- {{ $msg->created_at->format('h:i A') }} --}}
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Receiver Message -->
                        <div class="flex justify-start" wire:key="message-{{ $msg->id }}" wire:ignore>
                            <div class="max-w-xs lg:max-w-md">
                                <div class="bg-gray-200 text-gray-800 rounded-lg p-3 rounded-bl-none">
                                    <p>{{ $msg->message }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{-- {{ $msg->created_at->format('h:i A') }} --}}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="p-4 border-t border-gray-300 bg-white">
                <form wire:submit.prevent="sendMessage" class="flex space-x-2">
                    <input 
                        type="text" 
                        wire:model="message"
                        placeholder="Type your message..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <button 
                        type="submit"
                        class="bg-blue-500 text-white px-4 md:px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200"
                    >
                        <span class="hidden md:inline">Send</span>
                        <svg class="w-6 h-6 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-50">
                <div class="text-center p-8">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Select a chat</h3>
                    <p class="text-gray-500 hidden md:block">Choose a conversation from the left to start messaging</p>
                    <p class="text-gray-500 md:hidden">Choose a conversation to start messaging</p>
                </div>
            </div>
        @endif
    </div>
</div>