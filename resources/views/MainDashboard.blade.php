<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ultrasonic - Traffic Violations Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background-image: url('/img/db.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background-color: rgba(0, 0, 0, 0.8);
    padding: 20px 10px;
    color: white;
    transition: transform 0.3s ease;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sidebar.hide {
    transform: translateX(-240px);
}

.sidebar h1 {
    text-align: center;
    font-size: 1.6rem;
    margin-bottom: 25px;
}

.sidebar-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    text-decoration: none;
    padding: 12px 15px;
    margin: 5px 0;
    border-radius: 8px;
    transition: 0.2s;
    cursor: pointer;
}

.sidebar-btn:hover,
.sidebar-btn.active {
    background-color: #0d6efd;
}

.sidebar .logout-btn {
    width: 100%;
    padding: 12px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 8px;
    margin-top: auto;
    cursor: pointer;
}

.sidebar .logout-btn:hover {
    background-color: #bb2d3b;
}

.content {
    margin-left: 260px;
    padding: 20px;
    color: white;
    transition: margin-left 0.3s ease;
}

.content.full-width {
    margin-left: 20px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    padding: 20px;
    color: #333;
}

.table-container {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 20px;
    border-radius: 10px;
}

#menuBtn {
    position: fixed;
    top: 8px;
    left: 5px;
    width: 30px;
    height: 30px;
    display: none;
    align-items: center;
    justify-content: center;
    background-color: #0d6efd;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 22px;
    cursor: pointer;
    z-index: 1200;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
}


.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    z-index: 999;
}

@media (min-width: 993px) {
    .sidebar {
        transform: translateX(0);
    }

    .sidebar.hide {
        transform: translateX(-240px);
    }
}

@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-240px);
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .content {
        margin-left: 20px;
    }
}
</style>
</head>

<body>

<div id="overlay" class="overlay" onclick="closeSidebar()"></div>

<button id="menuBtn" type="button" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

<div class="sidebar" id="sidebar">

    <div>

        <h1>
            <i class="bi bi-speedometer2"></i>
            Admin
        </h1>

        <a href="{{ route('dashboard') }}"
           class="sidebar-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}   onclick="hideSidebar()">
            <i class="bi bi-house-door"></i>
            Home
        </a>

        <div class="sidebar-btn" onclick="loadPanel('/analytics')">
            <i class="bi bi-graph-up"></i>
            Data Analytics
        </div>

        <div class="sidebar-btn" onclick="loadPanel('/violations/records')">
            <i class="bi bi-exclamation-triangle"></i>
            Violations
        </div>

        <div class="sidebar-btn" onclick="loadPanel('/logs')">
            <i class="bi bi-journal-text"></i>
            Record Logs
        </div>

    </div>

    <button class="logout-btn" onclick="handleLogout()">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </button>

</div>

<div class="content" id="main-content">

    <h1>
        System Overview Control
    </h1>

    <div class="row">

        <div class="col-md-4">
            <div class="stat-card" style="border-left: 5px solid #dc3545;">
                <h6 class="text-muted text-uppercase small fw-bold">
                    Total Violations Logged
                </h6>

                <h2 class="m-0 fw-bold text-dark">
                    {{ $totalCount }}
                </h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="border-left: 5px solid #198754;">
                <h6 class="text-muted text-uppercase small fw-bold">
                    Active Hardware Node
                </h6>

                <h2 class="m-0 fw-bold text-success">
                    ONLINE
                </h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="border-left: 5px solid #ffc107;">
                <h6 class="text-muted text-uppercase small fw-bold">
                    Loud Pipe Today
                </h6>

                <h2 class="m-0 fw-bold text-dark">
                    {{ $loudCount ?? 0 }}
                </h2>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">

        <h3 class="h5 m-0 text-white fw-bold">
            Recent Real-Time Sensor Triggers
        </h3>

        <button onclick="loadPanel('/violations/records')"
                class="btn btn-sm btn-primary">

            <i class="bi bi-database"></i>
            View Full Database

        </button>

    </div>

    <div class="table-container">

        <table class="table table-striped table-hover m-0">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Plate</th>
                    <th>Type</th>
                    <th>Speed</th>
                    <th>dB</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody class="table-light text-dark">

            @forelse($violations->take(5) as $violation)

                <tr>

                    <td class="text-secondary small">
                        #{{ $violation->id }}
                    </td>

                    <td class="fw-bold">
                        {{ $violation->plate_number ?? 'N/A' }}
                    </td>

                    <td>

                        @if(($violation->violation_type ?? '') == 'Both')

                            <span class="badge bg-danger">
                                Overspeeding & Loud Pipe
                            </span>

                        @elseif(($violation->violation_type ?? '') == 'Overspeeding')

                            <span class="badge bg-warning text-dark">
                                Overspeeding
                            </span>

                        @else

                            <span class="badge bg-info text-dark">
                                Loud Pipe
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $violation->recorded_speed ?? 0 }}
                        km/h
                    </td>

                    <td>
                        {{ $violation->decibel_level ?? 0 }}
                        dB
                    </td>

                    <td>
                        {{ $violation->location ?? 'Binalonan, Pangasinan' }}
                    </td>

                    <td>
                        {{ $violation->created_at?->format('Y-m-d H:i:s') ?? 'N/A' }}
                    </td>

                    <td>

                        @if(($violation->status ?? 'Pending') == 'Pending')

                            <span class="badge bg-secondary">
                                Pending
                            </span>

                        @else

                            <span class="badge bg-success">
                                Resolved
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8"
                        class="text-center py-4 text-muted">

                        No active traffic events recorded today.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<form id="logout-form"
      action="{{ route('logout') }}"
      method="POST"
      style="display: none;">

    @csrf

</form>

<script>

function handleLogout() {

    if (confirm("Logout from Ultrasonic Dashboard?")) {
        document.getElementById('logout-form').submit();
    }

}

function toggleSidebar() {

    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const content = document.getElementById('main-content');

    if (sidebar.classList.contains('hide')) {

        sidebar.classList.remove('hide');
        sidebar.classList.add('show');

        content.classList.remove('full-width'); 

        menuBtn.style.display = 'none';

    } else {

        sidebar.classList.add('hide');
        sidebar.classList.remove('show');

        content.classList.add('full-width');

        menuBtn.style.display = 'flex';

    }

}

function closeSidebar() {

    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const content = document.getElementById('main-content');

    sidebar.classList.add('hide');
    sidebar.classList.remove('show');

    content.classList.add('full-width');

    menuBtn.style.display = 'flex';

}

function loadPanel(panelUrl) {

    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const contentDiv = document.getElementById('main-content');

    sidebar.classList.add('hide');
    sidebar.classList.remove('show');

    contentDiv.classList.add('full-width');

    menuBtn.style.display = 'flex';

    contentDiv.innerHTML = `
        <h1 class="text-center mt-5 text-white">
            <div class="spinner-border"></div>
            Loading...
        </h1>
    `;

    fetch(panelUrl)

        .then(response => {

            if (!response.ok) {
                throw new Error('Failed to load panel');
            }

            return response.text();

        })

        .then(html => {

            contentDiv.innerHTML = html;

            contentDiv
                .querySelectorAll('script')
                .forEach(oldScript => {

                    const newScript =
                        document.createElement('script');

                    if (oldScript.src) {
                        newScript.src = oldScript.src;
                    } else {
                        newScript.textContent =
                            oldScript.textContent;
                    }

                    document.body.appendChild(newScript);

                    oldScript.remove();

                });

        })

        .catch(error => {

            console.error(error);

            contentDiv.innerHTML = `
                <h1 class="text-center text-danger mt-5">
                    Error loading panel
                </h1>
            `;

        });

}
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const content = document.getElementById('main-content');

    // If currently on Home/Dashboard
    @if(request()->routeIs('dashboard'))
        sidebar.classList.add('hide');
        sidebar.classList.remove('show');

        content.classList.add('full-width');

        menuBtn.style.display = 'flex';
    @endif

});


</script>

</body>
</html>