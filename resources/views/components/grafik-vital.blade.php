@if(count($grafikData['labels']) >= 2)

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white fw-bold border-0 pt-3 d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-graph-up text-primary me-2"></i>Grafik Tanda Vital
        </span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary active" onclick="tampilGrafik('beratSuhu')">
                BB & Suhu
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="tampilGrafik('tekananDarah')">
                Tekanan Darah
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="tampilGrafik('bmi')">
                BMI
            </button>
        </div>
    </div>
    <div class="card-body">

        {{-- Grafik BB & Suhu --}}
        <div id="chartBeratSuhu">
            <canvas id="grafikBeratSuhu" height="120"></canvas>
        </div>

        {{-- Grafik Tekanan Darah --}}
        <div id="chartTekananDarah" style="display:none;">
            <canvas id="grafikTekananDarah" height="120"></canvas>
        </div>

        {{-- Grafik BMI --}}
        <div id="chartBmi" style="display:none;">
            <canvas id="grafikBmi" height="120"></canvas>
            <div class="d-flex gap-3 mt-2 justify-content-center small">
                <span><span class="badge bg-success">●</span> Normal (18.5–24.9)</span>
                <span><span class="badge bg-warning text-dark">●</span> Kelebihan (25–29.9)</span>
                <span><span class="badge bg-danger">●</span> Obesitas (≥30)</span>
                <span><span class="badge bg-info">●</span> Kekurangan (<18.5)< /span>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($grafikData['labels']);
    const beratBadan = @json($grafikData['beratBadan']);
    const suhuTubuh = @json($grafikData['suhuTubuh']);
    const sistolik = @json($grafikData['sistolik']);
    const diastolik = @json($grafikData['diastolik']);
    const bmiData = @json($grafikData['bmi']);

    // ================================
    // GRAFIK 1: Berat Badan & Suhu
    // ================================
    const ctx1 = document.getElementById('grafikBeratSuhu').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Berat Badan (kg)',
                    data: beratBadan,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    borderWidth: 2,
                    pointRadius: 5,
                    fill: true,
                    tension: 0.3,
                    yAxisID: 'y',
                },
                {
                    label: 'Suhu Tubuh (°C)',
                    data: suhuTubuh,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    borderWidth: 2,
                    pointRadius: 5,
                    fill: false,
                    tension: 0.3,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const unit = ctx.dataset.label.includes('Berat') ? ' kg' : ' °C';
                            return ctx.dataset.label + ': ' + (ctx.raw ?? '-') + unit;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Berat Badan (kg)'
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Suhu Tubuh (°C)'
                    },
                    min: 35,
                    max: 42,
                    grid: {
                        drawOnChartArea: false
                    },
                    // Garis batas normal suhu
                    afterDataLimits: scale => {
                        scale.max = Math.max(scale.max, 42);
                        scale.min = Math.min(scale.min, 35);
                    }
                }
            }
        }
    });

    // ================================
    // GRAFIK 2: Tekanan Darah
    // ================================
    const ctx2 = document.getElementById('grafikTekananDarah').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Sistolik (mmHg)',
                    data: sistolik,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    borderWidth: 2,
                    pointRadius: 5,
                    fill: true,
                    tension: 0.3,
                },
                {
                    label: 'Diastolik (mmHg)',
                    data: diastolik,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253,126,20,0.1)',
                    borderWidth: 2,
                    pointRadius: 5,
                    fill: true,
                    tension: 0.3,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': ' + (ctx.raw ?? '-') + ' mmHg'
                    }
                },
                // Garis batas normal
                annotation: {
                    annotations: {
                        normalSistolik: {
                            type: 'line',
                            yMin: 120,
                            yMax: 120,
                            borderColor: 'rgba(220,53,69,0.3)',
                            borderDash: [5, 5],
                            label: {
                                content: 'Batas Normal Sistolik',
                                display: true
                            }
                        }
                    }
                }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'mmHg'
                    },
                    min: 40,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                }
            }
        }
    });

    // ================================
    // GRAFIK 3: BMI (Bar)
    // ================================
    const ctx3 = document.getElementById('grafikBmi').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'BMI',
                data: bmiData,
                backgroundColor: bmiData.map(b => {
                    if (!b) return 'rgba(0,0,0,0.1)';
                    if (b < 18.5) return 'rgba(13,202,240,0.7)'; // kekurangan - info
                    if (b <= 24.9) return 'rgba(25,135,84,0.7)'; // normal - success
                    if (b <= 29.9) return 'rgba(255,193,7,0.7)'; // kelebihan - warning
                    return 'rgba(220,53,69,0.7)'; // obesitas - danger
                }),
                borderColor: bmiData.map(b => {
                    if (!b) return 'rgba(0,0,0,0.2)';
                    if (b < 18.5) return '#0dcaf0';
                    if (b <= 24.9) return '#198754';
                    if (b <= 29.9) return '#ffc107';
                    return '#dc3545';
                }),
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const b = ctx.raw;
                            if (!b) return 'BMI: -';
                            let kategori = '';
                            if (b < 18.5) kategori = '(Kekurangan berat badan)';
                            else if (b <= 24.9) kategori = '(Normal)';
                            else if (b <= 29.9) kategori = '(Kelebihan berat badan)';
                            else kategori = '(Obesitas)';
                            return `BMI: ${b} ${kategori}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Indeks Massa Tubuh'
                    },
                    min: 10,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                }
            }
        }
    });

    // ================================
    // Toggle Grafik
    // ================================
    function tampilGrafik(jenis) {
        document.getElementById('chartBeratSuhu').style.display = 'none';
        document.getElementById('chartTekananDarah').style.display = 'none';
        document.getElementById('chartBmi').style.display = 'none';

        document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));

        if (jenis === 'beratSuhu') {
            document.getElementById('chartBeratSuhu').style.display = 'block';
            document.querySelectorAll('.btn-group .btn')[0].classList.add('active');
        } else if (jenis === 'tekananDarah') {
            document.getElementById('chartTekananDarah').style.display = 'block';
            document.querySelectorAll('.btn-group .btn')[1].classList.add('active');
        } else {
            document.getElementById('chartBmi').style.display = 'block';
            document.querySelectorAll('.btn-group .btn')[2].classList.add('active');
        }
    }
</script>

@else
<div class="card shadow-sm mb-4">
    <div class="card-body text-center text-muted py-3">
        <i class="bi bi-graph-up" style="font-size: 2rem;"></i>
        <p class="mt-2 mb-0">Grafik tersedia setelah minimal <strong>2 kali</strong> kunjungan.</p>
    </div>
</div>
@endif