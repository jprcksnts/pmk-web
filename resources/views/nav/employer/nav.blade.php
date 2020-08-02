<?php
$nav_notifications = \App\Models\Notification\Notification::where('recipient_id', auth()->user()->id)
    ->orderBy('created_at', 'desc')
    ->get();
?>

<nav class="navbar navbar-horizontal navbar-expand-lg navbar-dark bg-default ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">P.E.S.O Makati</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default"
                aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-default">
            {{-- Header --}}
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="#" class="d-flex">
                            <img src="{{ asset('/old/pesologo.png') }}" style="height: 64px; width: 64px; ">
                            <h2 class="mb-0 ml-2 my-auto">
                                P.E.S.O Makati
                            </h2>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            {{-- End of Header --}}

            <ul class="navbar-nav ml-lg-auto">
                {{-- Job Posts --}}
                <li class="nav-item dropdown text-white my-auto">
                    <a class="nav-link nav-link-icon" href="#" id="navbar-job-posts-dropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Job Posts
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbar-job-posts-dropdown">
                        <a class="dropdown-item" href="/employer/job_post/create">
                            Create Job Post
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="/employer/job_posts">
                            View Created Job Posts
                        </a>
                    </div>
                </li>
                {{-- End of Job Posts --}}

                {{-- Job Offers --}}
                <li class="nav-item text-white my-auto">
                    <a href="/employer/job_offers" class="nav-link nav-link-icon">
                        Job Offers
                    </a>
                </li>
                {{-- End of Job Offers --}}

                {{-- Notifications --}}
                <li class="nav-item dropdown text-white">
                    <a href="#" class="nav-link nav-link-icon d-none d-lg-block" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Notifications
                    </a>

                    <a href="#" class="nav-link nav-link-icon d-lg-none" role="button"
                       data-toggle="modal" data-target="#modal_nav_notifications">
                        Notifications
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-notifications">
                        @if(count($nav_notifications) > 0)
                            @foreach($nav_notifications as $notification)
                                <div class="card mx-3 my-2 bg-transluscent-dark">
                                    <div class="card-body py-2 px-3">
                                        <h1 class="mb-0" style="font-size: 16px;">
                                            {{ $notification->title }}
                                        </h1>

                                        <p class="mb-0 text-small">
                                            {{ $notification->message }}
                                        </p>

                                        <hr class="bg-white my-2"/>

                                        <span class="mb-0 pr-2 my-auto text-smaller" data-toggle="tooltip"
                                              data-placement="right" title="{{ $notification->created_at }}">
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card mx-3 my-2 bg-transluscent-dark">
                                <div class="card-body py-2 px-3">
                                    <p class="mb-0">No recent notifications</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </li>
                {{-- End of Notifications --}}

                {{-- Profile Dropdown --}}
                <li class="nav-item dropdown text-white">
                    <a class="nav-link nav-link-icon py-0" href="#" id="navbar-user-icon-dropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <div class="dropdown-divider mb-3 d-md-none"></div>

                        <div class="d-flex">
                            <img class="avatar rounded-circle py-0"
                                 src="{{ asset(auth()->user()->userDetail->image) }}"
                                 style="height: 48px; width: 48px;">

                            <div class="my-auto ml-2 d-block d-md-none">
                                <strong class="mb-0 text-small">
                                    {{ strtoupper(auth()->user()->userDetail->name()) }}
                                </strong>
                                <p class="mb-0 text-smaller">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-user-icon-dropdown">
                        <a href="#" class="dropdown-item d-none d-md-block">
                            {{-- <img class="avatar rounded-circle" src="{{ auth()->user()->userDetail->image }}" style="height: 32px; width: 32px;"> --}}
                            <strong>
                                {{ strtoupper(auth()->user()->userDetail->name()) }}
                            </strong>

                            <p class="mb-0" style="font-size: 12px;">
                                {{ strtolower(auth()->user()->email) }}
                            </p>
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="/company/{{ auth()->user()->employer->company_id }}" class="dropdown-item">
                            <img src="{{ asset(auth()->user()->employer->company->image) }}"
                                 style="height: 32px; width: 32px;">
                            {{ auth()->user()->employer->company->name }}
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </li>
                {{-- End of Profile Dropdown --}}
            </ul>

        </div>
    </div>
</nav>

{{-- Notifications Modal --}}
<div class="modal fade" id="modal_nav_notifications" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h2 class="mb-0">Notifications</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div style="max-height: 512px; overflow: auto">
                @if(count($nav_notifications) > 0)
                    @foreach($nav_notifications as $notification)
                        <div class="card m-3 bg-transluscent-dark">
                            <div class="card-body py-2 px-3">
                                <h1 class="mb-0" style="font-size: 16px;">
                                    {{ $notification->title }}
                                </h1>

                                <p class="mb-0 text-small">
                                    {{ $notification->message }}
                                </p>

                                <hr class="bg-white my-2"/>

                                <span class="mb-0 pr-2 my-auto text-smaller" data-toggle="tooltip"
                                      data-placement="right" title="{{ $notification->created_at }}">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card mx-3 my-2 bg-transluscent-dark">
                        <div class="card-body py-2 px-3">
                            <p class="mb-0">No recent notifications</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
