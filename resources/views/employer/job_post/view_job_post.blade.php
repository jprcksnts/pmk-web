@extends('layouts.master')

@section('body')
    @include('nav.employer.nav')

    <div class="bg-gradient-default">
        <div class="container-fluid">
            <div class="row pt-3 pb-4">
                <div class="col-sm-12 px-0">
                    <div class="mx-4">
                        <h1 class="mb-0 text-white mr-2">Job Post Details</h1>

                        <ol class="breadcrumb breadcrumb-custom px-0">
                            <li class="breadcrumb-item"><a href="/employer/job_posts">Job Posts</a></li>
                            <li class="breadcrumb-item"><a href="#">Job Post Details</a></li>
                        </ol>

                        <a href="/employer/job_posts" class="btn btn-primary mx-0 mt-4">
                            Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row py-4">

            <div class="col-sm-12 col-md-10 order-md-2 order-lg-1 col-lg-8 my-2 mx-auto">
                @include('response_notifiers.response_card')

                <div class="card my-2" style="border-radius: 0px">
                    <div class="card-header">
                        <div class="d-flex">
                            <h2 class="mb-0 flex-grow-1">{{ $job_post->position }}</h2>

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
                        <p class="mb-0">
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
            </div>

        </div>
    </div>
@endsection
