<nav class="navbar navbar-horizontal navbar-expand-lg navbar-dark bg-default">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">P.E.S.O Makati</a>

        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbar-default"
                aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-default">
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

            <ul class="navbar-nav ml-lg-auto d-lg-none">
                <li class="nav-item">
                    <a class="nav-link" href="/admin/dashboard">
                        <i class="fas fa-chart-bar"></i>
                        <span class="nav-link-text">
                            Dashboard
                        </span>
                    </a>
                </li>

                {{-- Company Management --}}
                <li class="nav-item">
                    <a class="nav-link" href="#parent_company_management" data-toggle="collapse"
                       role="button"
                       aria-expanded="false" aria-controls="navbar-tables" id="nav_company_management">
                        <i class="fas fa-building"></i>
                        <span class="nav-link-text">
                            Manage Companies
                        </span>
                    </a>
                    <div class="collapse" id="parent_company_management">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/management/companies/create" class="nav-link" id="employer_list">
                                    Create Company
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/management/companies" class="nav-link"
                                   id="company_list">
                                    View Companies
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Employer Management --}}
                <li class="nav-item">
                    <a class="nav-link" href="#parent_employer_management" data-toggle="collapse"
                       role="button"
                       aria-expanded="false" aria-controls="navbar-tables" id="nav_employer_management">
                        <i class="fas fa-user-tie"></i>
                        <span class="nav-link-text">
                            Manage Employers
                        </span>
                    </a>
                    <div class="collapse" id="parent_employer_management">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/management/employers/create" class="nav-link" id="employer_list">
                                    Create Employer
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/management/employers" class="nav-link"
                                   id="employer_list">
                                    View Employers
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Employee Management --}}
                <li class="nav-item">
                    <a class="nav-link" href="#parent_employee_management" data-toggle="collapse"
                       role="button"
                       aria-expanded="false" aria-controls="navbar-tables" id="nav_employee_management">
                        <i class="fas fa-users"></i>
                        <span class="nav-link-text">
                            Manage Employees
                        </span>
                    </a>
                    <div class="collapse" id="parent_employee_management">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/management/employees" class="nav-link"
                                   id="employee_list">
                                    View Employees
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#modal_logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-link-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

