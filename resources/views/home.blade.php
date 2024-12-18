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

  <!-- JavaScript -->
  <script>
    $(document).ready(function () {
      fetchStaticData();
    });

    function fetchStaticData() {
      $.ajax({
        url: 'https://smart-trashbin-api.onrender.com/api/getdata', // Endpoint API localhost Anda
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          console.log('Response Data:', response); // Debug respons API

          let data = response; // Data langsung dari API
          if (!Array.isArray(data)) {
            console.error('Data tidak valid:', data);
            alert('Data tidak valid. Periksa format API Anda.');
            return;
          }

          const totalBulanan = data.length;
          $('#total-sampah-bulanan').text(totalBulanan);

          updateStatus(data);
        },
        error: function (xhr, status, error) {
          console.error('Error fetching data:', status, error);
          alert('Gagal mengambil data. Periksa server API Anda.');
        }
      });
    }

    function updateStatus(data) {
  // Inisialisasi objek untuk kategori dan statusnya
      const statusData = {
        organik: { jarak: 0, volume: 0 },
        anorganik: { jarak: 0, volume: 0 },
        b3: { jarak: 0, volume: 0 },
      };

      // Kelompokkan dan hitung jarak per kategori
      data.forEach(function (item) {
        let kategori = '';
        // Tentukan kategori berdasarkan nilai kategori
        switch (item.kategori) {
          case 1:
            kategori = 'organik';
            break;
          case 2:
            kategori = 'anorganik';
            break;
          case 3:
            kategori = 'b3';
            break;
          default:
            return; // Jika kategori tidak dikenali, lewati
        }

        const jarak = parseFloat(item.jarak); // Pastikan jarak adalah angka
        if (statusData[kategori] && !isNaN(jarak)) {
          statusData[kategori].jarak = jarak;
          // Hitung volume berdasarkan jarak
          statusData[kategori].volume = Math.min(100, 100 - (jarak / 50 * 100)).toFixed(0);
        }
      });

      // Perbarui UI berdasarkan statusData
      Object.keys(statusData).forEach(function (category) {
        const jarak = statusData[category].jarak;
        const volume = statusData[category].volume;
        let statusText = '';
        let barColor = ''; // Untuk menyimpan warna bar

        // Menentukan status dan warna bar berdasarkan jarak
        if (jarak < 10) {
          statusText = 'Penuh';
          barColor = 'red'; // Bar merah
        } else if (jarak >= 10 && jarak <= 20) {
          statusText = 'Setengah Penuh';
          barColor = 'yellow'; // Bar kuning
        } else if (jarak > 20 && jarak < 25) {
          statusText = 'Tersedia';
          barColor = 'green'; // Bar hijau
        }

        $(`#${category}-status`).text(statusText);
        $(`#${category}-jarak`).text(jarak + ' cm');
        $(`#${category}-volume`).text(volume + '%');
        $(`#${category}-capacity`).css({
          'width': volume + '%',
          'background-color': barColor // Atur warna bar
        });
      });
    }






  </script>
</body>
</html>
