window.filterTahun = function (tahun) {
    window.location.href = `${window.dashboardData.filterRoute}?tahun=${tahun}`;
};

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById('monthlyChart')) {

        const data = window.dashboardData;

        var optionsMonthly = {
            series: [{
                name: "Pendaftar",
                data: data.monthlyData
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false },
                fontFamily: 'Plus Jakarta Sans, sans-serif',
            },
            colors: ['#EF4444'],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '50%',
                    dataLabels: { position: 'top'},
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -30,
                style: { fontSize: '12px', colors: ["#6B7280"]} 
            },
            xaxis: {
                categories: data.monthlyLabels,
                axisBorder: { show: false},
                axisTicks: { show: false}
            },
            yaxis: { 
                show: false,
                max: function (val) {
                    return val === 0 ? 10 : val * 1.2;
                }
            },
            grid: {
                borderColor: '#F3F4F6',
                strokeDashArray: 4,
                yaxis: { lines: { show: true}},
                padding: {
                    right: 15,
                    left: 10
                }
            }
        };

        var chartMonthly = new ApexCharts(document.querySelector("#monthlyChart"), optionsMonthly);
        chartMonthly.render();

        const finalKategoriData = data.kategoriData.length > 0 ? data.kategoriData : [1];
        const finalKategoriLabels = data.kategoriLabels.length > 0 ? data.kategoriLabels : ['Belum ada data'];

        var optionsKategori = {
            series: finalKategoriData,
            chart: {
                type: 'donut',
                height: 280,
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            labels: finalKategoriLabels,
            colors: ['#6366F1', '#14B8A6', '#F43F5E', '#FBBF24'], 
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: { show: true, fontSize: '10px', color: '#9CA3AF', fontWeight: 'bold' },
                            value: { show: true, fontSize: '24px', fontWeight: '900', color: '#111827' },
                            total: { show: true, label: 'TOTAL', color: '#9CA3AF', fontWeight: 'bold' }
                        }              
                    }
                }
            },
            dataLabels: { enabled: false },
            stroke: { width: 0 },
            legend: {
                position: 'bottom',
                markers: { radius: 12 },
                itemMargin: { horizontal: 5, vertical: 5 }
            }
        };

        var chartKategori = new ApexCharts(document.querySelector("#kategoriChart"), optionsKategori);
        chartKategori.render();
    }
});