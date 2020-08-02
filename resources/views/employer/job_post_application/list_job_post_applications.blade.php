@extends('layouts.master')

@section('body')
    @include('nav.employer.nav')

    <div class="bg-gradient-default">
        <div class="container-fluid">
            <div class="row pt-3 pb-4">
                <div class="col-sm-12 px-0">
                    <div class="mx-4">
                        <h1 class="mb-0 text-white mr-2">Job Post Applications</h1>

                        <ol class="breadcrumb breadcrumb-custom px-0">
                            <li class="breadcrumb-item"><a href="/employer/job_posts">Job Post</a></li>
                            <li class="breadcrumb-item"><a href="#">Applications</a></li>
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

            <div class="col-sm-12 col-md-10 col-lg-8 mx-2">
                @include('response_notifiers.response_card')

                <div class="card my-2">
                    <div class="card-header">
                        <div class="d-flex">
                            <h2 class="mb-0 flex-grow-1">
                                Job Post Details
                            </h2>

                            <a href="/employer/job_post/update/{{ $job_post->id }}" class="my-auto text-orange">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="mb-0">
                            Position: {{ $job_post->position }}
                        </h4>

                        <h4 class="">Job Description</h4>
                        <p class="mb-0" style="font-size: 14px;">
                            {{ $job_post->description }}
                        </p>
                    </div>

                    <div class="card-footer">
                        <p class="mb-0" style="font-size: 14px;">Max Applicants: {{ $job_post->max_applicants }}</p>
                        <p class="mb-0" style="font-size: 14px;">Hired
                            Applicants: {{ $job_post->approved_applicants }}</p>
                    </div>
                </div>

                @if(count($job_post_applications))
                    @foreach($job_post_applications as $job_post_application)
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-auto my-auto pr-1">
                                                <img class="avatar rounded-circle py-0"
                                                     src="{{ asset($job_post_application->employee->user->userDetail->image) }}"
                                                     style="height: 48px; width: 48px;">
                                            </div>

                                            <div class="col pl-1">
                                                <h2 class="mb-0">{{ $job_post_application->employee->user->userDetail->name() }}</h2>
                                                <a href="/employee/{{ $job_post_application->employee->id }}/profile"
                                                   style="font-size: 14px;">
                                                    View Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <span class="mb-0 pr-2" data-toggle="tooltip" data-placement="right"
                                              title="{{ $job_post_application->jobPost->created_at }}">
                                            {{ \Carbon\Carbon::createFromTimeString($job_post_application->jobPost->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <p class="mb-0" style="width: auto; flex: fit-content; font-size: 14px;">
                                    Date applied:
                                    <span class="pr-2" data-toggle="tooltip" data-placement="right"
                                          title="{{ $job_post_application->created_at }}">
                                        {{ \Carbon\Carbon::createFromTimeString($job_post_application->created_at)->diffForHumans() }}
                                    </span>
                                </p>
                                <p class="mb-0" style="font-size: 14px;">
                                    Application Status: {{ $job_post_application->jobPostApplicationStatus->status }}
                                </p>
                            </div>

                            @if(!$job_post_application->jobOfferSent())
                                <div class="card-footer">
                                    @if($job_post_application->job_post_application_status_id == \App\Models\JobPost\JobPostApplicationStatus::$HIRED)
                                        <span class="mb-0 d-inline-flex align-middle mr-2 text-green">
                                            <span class="my-auto mr-2"><b>Applicant Accepted</b></span>
                                            <i class="fas fa-check-circle text-green fa-2x my-auto"></i>
                                        </span>
                                    @endif

                                    @if($job_post->max_applicants > $job_post->approved_applicants)
                                        @if($job_post_application->reviewable())
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#review_job_application_{{ $job_post_application->id }}">
                                                Place under review
                                            </button>
                                        @elseif($job_post_application->hireable())
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#accept_job_application_{{ $job_post_application->id }}">
                                                Hire Applicant
                                            </button>
                                        @endif

                                        {{-- TODO :: Add fallback for cancellable (if offer has already been sent) --}}
                                        @if($job_post_application->rejectable())
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#cancel_job_application_{{ $job_post_application->id }}">
                                                Reject Application
                                            </button>
                                        @else
                                            {{-- TODO :: Add dismiss applicant --}}
                                            {{--                                        <button type="button" class="btn btn-warning" disabled>--}}
                                            {{--                                            Reject Application--}}
                                            {{--                                        </button>--}}
                                        @endif
                                    @else
                                        <p class="mb-0 text-red" style="font-size: 14px;">
                                            Max applicants reached. If you wish to accept more applicants for this
                                            position, update the job posting, and increase the number of max applicants.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Modal for placing applicant under review --}}
                        <form method="post" action="/job_application/update">
                            {{ csrf_field() }}

                            <input type="hidden" name="job_post_application_id"
                                   value="{{ $job_post_application->id }}">
                            <input type="hidden" name="job_post_application_status_id"
                                   value="{{ \App\Models\JobPost\JobPostApplicationStatus::$UNDER_REVIEW }}">

                            <div class="modal fade" id="review_job_application_{{ $job_post_application->id }}"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="review_job_application_{{ $job_post_application->id }}"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title mb-0">Review Job Application</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body py-0">
                                            <p class="mb-0">
                                                Are you sure you want to place this applicant under review?
                                            </p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Place under review</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Modal for accepting applicant --}}
                        <form method="post" action="/job_offer/create">
                            {{ csrf_field() }}

                            <input type="hidden" name="job_post_application_id"
                                   value="{{ $job_post_application->id }}">
                            {{--                            <input type="hidden" name="job_post_application_status_id"--}}
                            {{--                                   value="{{ \App\Models\JobPost\JobPostApplicationStatus::$HIRE }}">--}}

                            <div class="modal fade" id="accept_job_application_{{ $job_post_application->id }}"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="accept_job_application_{{ $job_post_application->id }}"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title mb-0">Hire Applicant</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body py-0">
                                            <div class="form-group mb-0">
                                                <p class="mb-2" style="font-size: 12px;">Add additional information like
                                                    benefits for joining your company, etc..</p>

                                                <label for="description">Job Offer Description</label>
                                                <textarea id="description" name="description" minlength="128"
                                                          maxlength="8096"
                                                          class="form-control" required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-success">Hire Applicant</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Modal for Cancel Job Post Application --}}
                        <form method="post" action="/job_application/update">
                            {{ csrf_field() }}

                            <input type="hidden" name="job_post_application_id"
                                   value="{{ $job_post_application->id }}">

                            <input type="hidden" name="job_post_application_status_id"
                                   value="{{ \App\Models\JobPost\JobPostApplicationStatus::$CANCELLED }}">

                            <div class="modal fade" id="cancel_job_application_{{ $job_post_application->id }}"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="cancel_job_application_{{ $job_post_application->id }}"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title mb-0">Cancel Job Application</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body py-0">
                                            <p class="mb-0">
                                                Are you sure you want to cancel your job application for the
                                                position {{ $job_post_application->jobPost->position }}
                                            </p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-danger">Cancel Application</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                @else
                    <div class="card my-2">
                        <div class="card-body">
                            <p class="mb-0">
                                No applicants found
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
