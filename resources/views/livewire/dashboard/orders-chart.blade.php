<div>
    <canvas id="orderChart" width="400" height="100"></canvas>
</div>

{{-- @push('scripts') --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // document.addEventListener('livewire:load', function () {
        //     Livewire.on('ordersFetched', function () {
                var ctx = document.getElementById('orderChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($orders->map(function($order) {
                            return $order->month . '-' . $order->year;
                        })),
                        datasets: [{
                            label: @json($title),
                            data: @json($orders->pluck('total')),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 4
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
        //     });
        // });
    </script>
{{-- @endpush --}}