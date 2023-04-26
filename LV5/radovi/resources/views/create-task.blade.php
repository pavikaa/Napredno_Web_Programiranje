<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create task') }}
        </h2>
    </x-slot>

    <x-auth-card>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div>
            <!-- Role selection -->
            <form class="mt-4" action="/createTask" method="POST">
            @csrf
                <!-- Name -->
                <div>
                    <x-label for="name" :value="__('messages.name')" />

                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required/>
                </div>

                <!-- English name -->
                <div class="mt-4">
                    <x-label for="english_name" :value="__('messages.english_name')" />

                    <x-input id="english_name" class="block mt-1 w-full" type="text" name="english_name" :value="old('english_name')" required/>
                </div>

                <!-- Assignment -->
                <div class="mt-4">
                    <x-label for="assignment" :value="__('messages.assignment')" />

                    <x-input id="assignment" class="block mt-1 w-full" type="text" name="assignment" :value="old('assignment')" required/>
                </div>

                <div class="mt-4">
                    <x-label for="study_type_selection" :value="__('messages.study_type')" />
                    <select id="study_type_selection" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                            name="study_type" required >
                        <option value="professional">Professional study</option>
                        <option value="undergraduate">Undergraduate study</option>
                        <option value="graduate">Graduate study</option>
                    </select>
                </div>

                
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4" type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>
        </div>
    </x-auth-card>
</x-app-layout>