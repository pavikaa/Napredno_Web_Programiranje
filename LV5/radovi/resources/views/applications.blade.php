<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applications') }}
        </h2>
    </x-slot>

    <x-auth-card>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

       @if (count($students) > 0) 
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-center">
                        <table>
                            <tr class="font-semibold uppercase text-xl">
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                            @foreach ($students as $student)
                            <tr class="text-lg">
                                <td>{{$student->name}}</td>
                                <td>{{$student->email}}</td>
                                <td>
                                    <form method="post" action="{{route('reserve.task')}}">
                                    @csrf
                                        <input type="hidden" id="studentId" name="studentId" value="{{$student->id}}">
                                        <input type="hidden" id="taskId" name="taskId" value="{{$task->id}}">
                                        <x-button class="ml-4">
                                        {{ __('Reserve') }}
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif     
        
    </x-auth-card>
</x-app-layout>