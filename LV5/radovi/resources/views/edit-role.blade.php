<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit') }} role for user {{$selectedUser->name}}
        </h2>
    </x-slot>

    <x-auth-card>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div>


            <!-- Role selection -->
            <form class="mt-4" action="/edit/{{$selectedUser->id}}" method="POST">
            @csrf
                <x-label for="role_selection" :value="__('Choose your role')" />

                <select id="role_selection" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                        name="role" required >
                    <option value="student" {{($selectedUser->role === 'student') ? 'selected' : ''}} >Student</option>
                    <option value="professor" {{($selectedUser->role === 'professor') ? 'selected' : ''}}>Professor</option>
                    <option value="admin" {{($selectedUser->role === 'admin') ? 'selected' : ''}} >Admin</option>
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4" type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>
        </div>
    </x-auth-card>
</x-app-layout>