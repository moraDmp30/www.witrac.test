<div>
    <form wire:submit.prevent="save" class="mb-10">
        <div class="sm:overflow-hidden">
            <div class="bg-white py-6 space-y-6 sm:py-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add commands</h3>
                    <p class="mt-1 text-sm text-gray-500">Use this form to upload a new command file.</p>
                </div>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <label for="file" class="block text-sm font-medium text-gray-700">
                            File
                        </label>
                        <div class="mt-1 relative flex">
                            <input type="file" wire:model="file" class="focus:ring-indigo-500 focus:border-indigo-500 flex-grow block w-full min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            @error('file')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-sm text-gray-500" id="file-description">Only .txt files. Max: 1MB</p>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600" id="file-error">{{ $message }}</p>
                        @enderror
                    </div>
  
                    <div class="col-span-3 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">
                            &nbsp;
                        </label>
                        <div class="mt-1 flex">
                            <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Upload
                            </button>
                        </div>
                    </div>

                    <div class="col-span-3">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input wire:model="delete_previous" id="delete-previous" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" value="1">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="delete-previous" class="font-medium text-gray-700">Delete previous</label>
                                <p class="text-gray-500">By checking this, all existing commands will be removed and replaced by new file.</p>
                                @error('delete_previous')
                            <p class="mt-2 text-sm text-red-600" id="delete-previous-error">{{ $message }}</p>
                        @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
