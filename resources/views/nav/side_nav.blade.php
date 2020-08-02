<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-lg navbar-light bg-gradient-white d-none d-lg-block"
     id="sidenav-main">
    <div class="scrollbar-inner">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="/admin/dashboard">
                P.E.S.O Makati
            </a>

            <div class="d-none d-lg-block">
                <div class="sidenav-toggler" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">

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
    </div>
</nav>
