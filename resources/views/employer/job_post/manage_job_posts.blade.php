@extends('layouts.master')

@section('body')
    @include('nav.employer.nav')

    <div class="bg-gradient-default">
        <div class="container-fluid">
            <div class="row pt-3 pb-4">
                <div class="col-sm-12 px-0">
                    <div class="mx-4">
                        <h1 class="mb-0 text-white mr-2">Job Posts</h1>

                        <ol class="breadcrumb breadcrumb-custom px-0">
                            <li class="breadcrumb-item"><a href="#">Job Posts</a></li>
                        </ol>

                        <a href="/employer/job_post/create" class="btn btn-primary mx-0 mt-4">
                            Create a job post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row py-4 px-2">

            <div class="col-sm-12 col-md-10 order-md-2 order-lg-1 col-lg-8 my-2">

                @include('response_notifiers.response_card')

                @if(count($job_posts) > 0)
                    @foreach($job_posts as $job_post)
                        <div class="card my-2" style="border-radius: 0px">
                            <div class="card-header">
                                <div class="d-flex">
                                    <a href="/employer/job_post/{{ $job_post->id }}" class="mb-0 flex-grow-1">
                                        <h2 class="mb-0">{{ $job_post->position }}</h2>
                                    </a>

                                    <span class="mb-0 my-auto mx-4 pr-2" data-toggle="tooltip" data-placement="right"
                                          title="{{ $job_post->created_at }}">
                                        {{ \Carbon\Carbon::createFromTimeString($job_post->created_at)->diffForHumans() }}
                                    </span>

                                    <a href="/employer/job_post/update/{{ $job_post->id }}" class="my-auto text-orange">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <p>
                                    {{ $job_post->description }}
                                </p>
                            </div>

                            <div class="card-footer">
                                <p class="mr-4 mb-0" style="font-size: 14px;">
                                    <b>Max Applicants:</b> {{ $job_post->max_applicants }}
                                </p>
                                <p class="mr-4 mb-0" style="font-size: 14px;">
                                    <b>Hired Applicants:</b> {{ $job_post->approved_applicants }}
                                </p>
                            </div>

                            <div class="card-footer">
                                <a href="/employer/job_post/{{ $job_post->id }}/applicants" class="btn btn-primary">
                                    View Applicants
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card my-2">
                        <div class="card-body">
                            <p class="mb-0">
                                No Job posts created
                            </p>
                        </div>
                    </div>
                @endif

            </div>

            <div class="col-sm-12 col-md-10 order-md-1 order-lg-2 col-lg-4 my-2 mx-auto">
                <div class="card my-2">
                    <div class="card-header">
                        <h2 class="mb-0">Recent Applicants</h2>
                    </div>

                    <div class="card-body">
                        @if(count($job_applications) > 0)
                            @foreach($job_applications as $index => $job_application)
                                <div class="bg-transluscent border-rounded p-4">
                                    <a href="/employer/job_post/{{ $job_application->job_post_id }}">
                                        <p class="mb-0">
                                            {{ $job_application->jobPost->position }}
                                        </p>
                                    </a>

                                    <div class="row py-2">
                                        <div class="col-auto my-auto pr-1">
                                            <img class="avatar rounded-circle py-0"
                                                 src="{{ asset($job_application->employee->user->userDetail->image) }}"
                                                 style="height: 48px; width: 48px;">
                                        </div>

                                        <div class="col-auto my-auto">
                                            <p class="mb-0">
                                                {{--                                    /employee/{{ $job_application->employee_id }}/profile--}}
                                                <strong>
                                                    {{ $job_application->employee->user->userDetail->name() }}
                                                </strong>
                                            </p>

                                            <p class="mb-0" style="font-size: 12px;">
                                                {{ $job_application->employee->user->email }}
                                            </p>
                                        </div>
                                    </div>

                                    <p class="mb-0">
                                        <a href="/employee/{{ $job_application->employee->id }}/profile"
                                           style="font-size: 14px;">
                                            View Profile
                                        </a>
                                    </p>

                                    <span class="p mb-0" style="font-size: 12px;" data-toggle="tooltip"
                                          data-placement="right"
                                          title="{{ $job_application->jobPost->created_at }}">
                                        Submitted
                                        <span class="mr-2">
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $job_application->jobPost->created_at)->diffForHumans() }}
                                        </span>
                                    </span>
                                </div>

                                @if($index != (count($job_applications) - 1))
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <p class="mb-0">
                                No recent applicants found
                            </p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
