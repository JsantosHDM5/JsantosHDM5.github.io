document.addEventListener('DOMContentLoaded', () => {
    fetch('data.php')
        .then(response => response.json())
        .then(data => {
            const meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
            const labels = data.map(item => meses[item.mes - 1]);
            const totals = data.map(item => item.total);

            new Chart(document.getElementById("citasChart"), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Citas por mes',
                        data: totals,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
});
