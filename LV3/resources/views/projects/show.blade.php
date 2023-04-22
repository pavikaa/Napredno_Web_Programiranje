@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Project Details') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Project Name') }}</label>

                            <div class="col-md-6">
                                <p>{{ $project->name }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Project Description') }}</label>

                            <div class="col-md-6">
                                <p>{{ $project->description }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <p>{{ $project->price }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="members" class="col-md-4 col-form-label text-md-right">{{ __('Project Members') }}</label>
                            <div class="col-md-6">
                                <ul>
                                    @foreach($project->members as $member)
                                        <li>{{ $member->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="completed_tasks" class="col-md-4 col-form-label text-md-right">{{ __('Project Completed Tasks') }}</label>

                            <div class="col-md-6">
                                <p>{{ $project->completed_tasks }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>

                            <div class="col-md-6">
                                <p>{{ $project->start_date }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>

                            <div class="col-md-6">
                                <p>{{ $project->end_date }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">{{ __('Edit Project') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
