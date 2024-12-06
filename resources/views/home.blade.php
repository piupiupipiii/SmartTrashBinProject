<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Trash Bin</title>
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container">
    <header>
      <h1>Smart Trash Bin</h1>
      <nav>
        <ul>
          <li><a href="{{ url('/home') }}">Home</a></li>
          <li><a href="{{ url('/statistic') }}">Statistics</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section class="monthly-status">
        <h2>Jumlah Sampah Bulanan</h2>
        <p><strong>Total Sampah Bulan Ini:</strong> <span id="total-sampah-bulanan">Loading...</span> kali</p>
        <p class="more-link">
          <a href="{{ url('/statistic') }}">More <span class="arrow">&rarr;</span></a>
        </p>
      </section>

      <section class="current-status">
        <h2>Status Kapasitas Tong Sampah</h2>

        <div class="status-section">
          <h3>Organik</h3>
          <p>Jarak: <span id="organik-jarak">Loading...</span> cm</p>
          <p>Status: <span id="organik-status">Loading...</span></p>
          <div class="capacity-bar">
            <div id="organik-capacity" class="capacity-fill" style="width: 0%;"></div>
          </div>
          <p>Volume: <span id="organik-volume">0%</span></p>
        </div>

        <div class="status-section">
          <h3>Anorganik</h3>
          <p>Jarak: <span id="anorganik-jarak">Loading...</span> cm</p>
          <p>Status: <span id="anorganik-status">Loading...</span></p>
          <div class="capacity-bar">
            <div id="anorganik-capacity" class="capacity-fill" style="width: 0%;"></div>
          </div>
          <p>Volume: <span id="anorganik-volume">0%</span></p>
        </div>

        <div class="status-section">
          <h3>B3</h3>
          <p>Jarak: <span id="b3-jarak">Loading...</span> cm</p>
          <p>Status: <span id="b3-status">Loading...</span></p>
          <div class="capacity-bar">
            <div id="b3-capacity" class="capacity-fill" style="width: 0%;"></div>
          </div>
          <p>Volume: <span id="b3-volume">0%</span></p>
        </div>
      </section>
    </main>
  </div>

  <script>
    function fetchData() {
      $.ajax({
        url: 'https://smart-trashbin-api.onrender.com/api/getdata',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          $('#total-sampah-bulanan').text(response.total_bulanan);
          $('#organik-jarak').text(response.organik.jarak);
          $('#organik-status').text(response.organik.status);
          $('#organik-capacity').css('width', response.organik.capacity + '%');
          $('#organik-volume').text(response.organik.capacity + '%');
          $('#anorganik-jarak').text(response.anorganik.jarak);
          $('#anorganik-status').text(response.anorganik.status);
          $('#anorganik-capacity').css('width', response.anorganik.capacity + '%');
          $('#anorganik-volume').text(response.anorganik.capacity + '%');
          $('#b3-jarak').text(response.b3.jarak);
          $('#b3-status').text(response.b3.status);
          $('#b3-capacity').css('width', response.b3.capacity + '%');
          $('#b3-volume').text(response.b3.capacity + '%');
        },
        error: function() {
          console.error('Error fetching data.');
        }
      });
    }

    setInterval(fetchData, 5000);
    fetchData();
  </script>
</body>
</html>
