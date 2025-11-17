<!DOCTYPE html>
<html>
<head>
<title>HTML Table to Chart</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> </head>
<body>

<table id="myTable">
  <thead>
    <tr>
      <th>Year</th>
      <th>Sales</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>2020</td>
      <td>100</td>
    </tr>
    <tr>
      <td>2021</td>
      <td>150</td>
    </tr>
    <tr>
      <td>2022</td>
      <td>200</td>
    </tr>
  </tbody>
</table>

<canvas id="myChart"></canvas>

<script>
  const table = document.getElementById('myTable');
  const labels = [];
  const data = [];

  // Extract data from the table
  for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip header
    const row = table.rows[i];
    labels.push(row.cells[0].textContent);
    data.push(parseInt(row.cells[1].textContent)); // Parse as integer
  }

  // Create the chart
  const ctx = document.getElementById('myChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar', // Choose your chart type
    data: {
      labels: labels,
      datasets: [{
        label: 'Sales',
        data: data,
        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Customize colors
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true // Start y-axis at 0
        }
      }
    }
  });
</script>

</body>
</html>