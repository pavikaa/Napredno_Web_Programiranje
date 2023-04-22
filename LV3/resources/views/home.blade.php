@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Projects</h2>
        @if(count($projects) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->end_date }}</td>
                        <td>{{ $project->price }}</td>
                        <td>
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>You don't have any projects yet.</p>
        @endif
    </div>
@endsection
