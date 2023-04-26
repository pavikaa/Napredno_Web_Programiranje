<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (count($users) > 0) 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-center">
                    <table>
                        <tr class="font-semibold uppercase text-xl">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            @if($loggedUser->role === 'admin')
                            <th>Edit role</th>
                            @endif
                        </tr>
                        @foreach ($users as $user)
                        <tr class="text-lg">
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            @if($loggedUser->role === 'admin')
                            <th><a href="/edit/{{$user->id}}">Edit</a> </th>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (count($tasks) > 0) 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-center">
                    <table>
                        <tr class="font-semibold uppercase text-xl">
                            <th>Name</th>
                            <th>English name</th>
                            <th>Assignment</th>
                            <th>Study type</th>
                        </tr>
                        @foreach ($tasks as $task)
                        @if ($loggedUser->role === 'student' && $task->isReserved === 0)
                        <tr class="text-lg">
                            <td>{{$task->name}}</td>
                            <td>{{$task->english_name}}</td>
                            <td>{{$task->assignment}}</td>
                            <td>{{$task->study_type}}</td>
                            <td>
                                <form method="post" action="{{route('apply.for.task')}}">
                                @csrf
                                    <input type="hidden" id="taskId" name="taskId" value="{{$task->id}}">
                                    <x-button class="ml-4">
                                    {{ __('Apply') }}
                                    </x-button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        
                        @if ($loggedUser->role === 'professor') 
                        <tr class="text-lg">
                            <td>{{$task->name}}</td>
                            <td>{{$task->english_name}}</td>
                            <td>{{$task->assignment}}</td>
                            <td>{{$task->study_type}}</td>
                            @if ($task->isReserved === 1)
                            <td>
                            {{ __('Reserved') }}
                            </td>
                            @else
                            <td>
                                <a href="/getApplicationsView/{{$task->id}}" class="ml-4">{{ __('Applications') }} </a>
                            </td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>