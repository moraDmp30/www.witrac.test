<div wire:init="fetchCommands">
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($this->isDataReady())
                                @forelse ($commands as $command)
                                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $command }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            There are no commands.
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Loading commands...
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div> 
</div>
