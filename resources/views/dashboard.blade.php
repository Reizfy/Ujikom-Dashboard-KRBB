@extends('layouts.user_type.auth')

@section('content')

  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Member</p>
                <h5 class="font-weight-bolder mb-0">
                {{ $totalMember }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-user-circle text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Saldo</p>
                <h5 class="font-weight-bolder mb-0">
                  Rp.{{ $saldo ?? 0 }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-money-bill text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Kredit</p>
                <h5 class="font-weight-bolder mb-0">
                  Rp.{{ $totalKredit }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fas fa-arrow-up text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Debit</p>
                <h5 class="font-weight-bolder mb-0">
                Rp.{{ $totalDebit }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fas fa-arrow-down text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Uang Kas overview</h6>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@push('dashboard')
  <script>
    window.onload = function() {
  var totalSaldo = <?php echo $saldo; ?>;
  var totalDebit = <?php echo $totalDebit; ?>;
  var totalKredit = <?php echo $totalKredit; ?>;
  var ctx = document.getElementById("chart-line").getContext("2d");

  var chartLine = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Saldo', 'Debit', 'Kredit'],
      datasets: [{
        label: 'Jumlah',
        data: [totalSaldo, totalDebit, totalKredit],
        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
        borderWidth: 1,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      tooltips: {
        callbacks: {
          label: function(context) {
            var label = '';
            if (context.datasetIndex === 0) {
              switch (context.label) {
                case 'Saldo':
                  label = 'Total Saldo: ' + context.parsed.y;
                  break;
                case 'Debit':
                  label = 'Total Debit: ' + context.parsed.y;
                  break;
                case 'Kredit':
                  label = 'Total Kredit: ' + context.parsed.y;
                  break;
              }
            }
            return label;
          }
        }
      }
    }
  });
};



  </script>
@endpush

