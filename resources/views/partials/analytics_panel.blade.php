<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="h4 m-0 text-white fw-bold text-shadow">
    Device Statistical Analytics
  </h3>

  <a href="{{ route('analytics.export') }}"
     class="btn btn-success btn-sm fw-bold shadow-sm">
    <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i>
    Download CSV Report
  </a>
</div>


<div class="row mb-4 text-dark">

  <!-- Total Violations -->
  <div class="col-md-4 mb-3">
    <div class="stat-card"
         style="
           border-left-color: #0d6efd;
           background: rgba(255,255,255,0.95);
           height: 100%;
         ">

      <h6 class="text-muted text-uppercase small fw-bold">
        Total Violations Detected
      </h6>

      <h2 class="m-0 fw-bold">
        {{ $totalViolations }}
      </h2>

      <small class="text-muted">
        Lifetime device triggers
      </small>

    </div>
  </div>


  <!-- Speeding -->
  <div class="col-md-4 mb-3">
    <div class="stat-card"
         style="
           border-left-color: #ffc107;
           background: rgba(255,255,255,0.95);
           height: 100%;
         ">

      <h6 class="text-muted text-uppercase small fw-bold">
        Speeding Violations
      </h6>

      <div class="d-flex justify-content-between align-items-center mt-2">

        <div>
          <h4 class="m-0 fw-bold text-warning">
            {{ $speedDaily }}
          </h4>

          <small class="text-muted">
            Today
          </small>
        </div>

        <div class="border-start ps-3">

          <h4 class="m-0 fw-bold text-dark">
            {{ $speedMonthly }}
          </h4>

          <small class="text-muted">
            This Month
          </small>

        </div>

      </div>

    </div>
  </div>


  <!-- Loud Motorcycle -->
  <div class="col-md-4 mb-3">
    <div class="stat-card"
         style="
           border-left-color: #0dc6fd;
           background: rgba(255,255,255,0.95);
           height: 100%;
         ">

      <h6 class="text-muted text-uppercase small fw-bold">
        Loud Motorcycle Violations
      </h6>

      <div class="d-flex justify-content-between align-items-center mt-2">

        <div>

          <h4 class="m-0 fw-bold text-info">
            {{ $loudDaily }}
          </h4>

          <small class="text-muted">
            Today
          </small>

        </div>

        <div class="border-start ps-3">

          <h4 class="m-0 fw-bold text-dark">
            {{ $loudMonthly }}
          </h4>

          <small class="text-muted">
            This Month
          </small>

        </div>

      </div>

    </div>
  </div>

</div>

<div class="row">

  <!-- Peak Hours -->
  <div class="col-md-7 mb-4">

    <div class="p-3 rounded shadow-sm"
         style="
           background: rgba(255,255,255,0.95);
           min-height: 340px;
         ">

      <h5 class="text-dark fw-bold border-bottom pb-2 mb-3">
        Peak Hours of Violations
      </h5>

      <div style="
        position: relative;
        height: 260px;
      ">

        <canvas id="peakHoursChart"></canvas>

      </div>

    </div>

  </div>


  <div class="col-md-5 mb-4">

    <div class="p-3 rounded shadow-sm text-dark"
         style="
           background: rgba(255,255,255,0.95);
           min-height: 340px;
         ">

      <h5 class="text-dark fw-bold border-bottom pb-2 mb-3">
        Flagged Repeat Offenders
      </h5>

      <div class="table-responsive">

        <table class="table table-sm table-hover align-middle m-0">

          <thead class="table-light">

            <tr>
              <th>Plate Number</th>
              <th class="text-center">Detections</th>
              <th class="text-end">Risk Factor</th>
            </tr>

          </thead>

          <tbody>

            @forelse($repeatOffenders as $offender)

              <tr>

                <td class="fw-bold text-uppercase">

                  <i class="bi bi-person-badge-fill me-1 text-secondary"></i>

                  {{ $offender->plate_number }}

                </td>

                <td class="text-center fw-bold text-danger">

                  {{ $offender->total_offenses }}x

                </td>

                <td class="text-end">

                  <span class="badge
                    {{ $offender->total_offenses >= 3
                        ? 'bg-danger'
                        : 'bg-warning text-dark' }}">

                    {{ $offender->total_offenses >= 3
                        ? 'High Risk'
                        : 'Moderate' }}

                  </span>

                </td>

              </tr>

            @empty

              <tr>

                <td colspan="3"
                    class="text-center py-5 text-muted small">

                  <i class="
                    bi bi-check-circle-fill
                    text-success
                    d-block
                    fs-3
                    mb-2
                  "></i>

                  No repeat license plates verified in current logs.

                </td>

              </tr>

            @endforelse

          </tbody>

        </table>

      </div>

    </div>

  </div>

</div>


<div class="row">

  <div class="col-12 mb-4">

    <div class="p-3 rounded shadow-sm"
         style="
           background: rgba(255,255,255,0.95);
           min-height: 360px;
         ">

      <h5 class="text-dark fw-bold border-bottom pb-2 mb-3">

        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>

        Overspeeding vs Loud Motorcycle

      </h5>

      <div style="
        position: relative;
        height: 280px;
      ">

        <canvas id="violationTypeChart"></canvas>

      </div>

    </div>

  </div>

</div>



<!-- =========================
     CHARTS
========================= -->

<script>

(function () {

    /* ==========================================
       PEAK HOURS CHART
    ========================================== */

    function initializePeakHoursChart() {

        const canvas =
            document.getElementById('peakHoursChart');

        if (!canvas) return;

        const existingChart =
            Chart.getChart(canvas);

        if (existingChart) {
            existingChart.destroy();
        }

        new Chart(canvas, {

            type: 'line',

            data: {

                labels: Array.from(
                    { length: 24 },
                    (_, i) => `${i}:00`
                ),

                datasets: [

                    {
                        label: 'Violations Tracked',

                        data: @json($hourlyData),

                        borderColor: '#0d6efd',

                        backgroundColor:
                            'rgba(13, 110, 253, 0.10)',

                        borderWidth: 2.5,

                        pointBackgroundColor:
                            '#0d6efd',

                        pointRadius: 3,

                        pointHoverRadius: 5,

                        fill: true,

                        tension: 0.3
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    x: {
                        title: {
                            display: true,
                            text: 'Hour of Day'
                        }
                    },

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0,
                            stepSize: 1
                        },

                        title: {
                            display: true,
                            text: 'Violations'
                        }

                    }

                }

            }

        });

    }



    /* ==========================================
       OVERSPEEDING VS LOUD MOTORCYCLE
    ========================================== */

    function initializeViolationTypeChart() {

        const canvas =
            document.getElementById('violationTypeChart');

        if (!canvas) return;

        const existingChart =
            Chart.getChart(canvas);

        if (existingChart) {
            existingChart.destroy();
        }

        new Chart(canvas, {

            type: 'bar',

            data: {

                labels: [
                    'Overspeeding',
                    'Loud Motorcycle'
                ],

                datasets: [

                    {
                        label: 'Total Violations',

                        data: [
                            @json($speedTotal),
                            @json($loudTotal)
                        ],

                        backgroundColor: [
                            '#ffc107',
                            '#0dc6fd'
                        ],

                        borderColor: [
                            '#e0a800',
                            '#0aa2c0'
                        ],

                        borderWidth: 1,

                        borderRadius: 6,

                        barThickness: 70

                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        callbacks: {

                            label: function (context) {

                                return ` ${context.parsed.y} violations`;

                            }

                        }

                    }

                },

                scales: {

                    x: {

                        title: {
                            display: true,
                            text: 'Violation Type'
                        }

                    },

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0,
                            stepSize: 1
                        },

                        title: {
                            display: true,
                            text: 'Number of Violations'
                        }

                    }

                }

            }

        });

    }



    /* ==========================================
       INITIALIZE
    ========================================== */

    function initializeAnalyticsCharts() {

        initializePeakHoursChart();

        initializeViolationTypeChart();

    }


    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initializeAnalyticsCharts
        );

    } else {

        initializeAnalyticsCharts();

    }

})();

</script>