<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">

    <div class="container-fluid">

        <button
            class="btn btn-outline-secondary d-lg-none me-2"
            id="sidebarToggle"
            type="button">

            <i class="bi bi-list"></i>

        </button>

        <span class="navbar-brand fw-bold">
            @yield('page-title', 'Dashboard')
        </span>

        <div class="ms-auto d-flex align-items-center gap-3">

            <button class="btn btn-light position-relative">
                <i class="bi bi-bell fs-5"></i>

                <span class="position-absolute top-0 start-100 translate-middle
                             badge rounded-pill bg-danger">
                    3
                </span>
            </button>

            <div class="dropdown">

                <button
                    class="btn btn-light dropdown-toggle"
                    data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle me-1"></i>

                    {{ Auth::user()->name ?? 'Admin' }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>
                            Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i>
                            Settings
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('erpSidebar');

        if (button && sidebar) {
            button.addEventListener('click', function () {
                sidebar.classList.toggle('active');
            });
        }

    });
</script>