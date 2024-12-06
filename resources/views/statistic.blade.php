<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Statistik Masukkan Sampah</title>
  <link rel="stylesheet" href="{{ asset('css/statistic.css') }}">
</head>
<body>
  <div class="container">
    <header class="main-header">
        <h1>Smart Trash Bin</h1>
        <nav>
            <ul>
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a href="{{ url('/statistic') }}">Statistics</a></li>
            </ul>
        </nav>
    </header>



    <main>
      <div class="statistics-wrapper">
        <div class="picture-container">
          <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 1" class="statistics-chart">
          <img src="{{ asset('image/trash.png') }}" alt="Statistik Gambar 2" class="statistics-chart">
          <img src="{{ asset('image/stats.png') }}" alt="Statistik Gambar 3" class="statistics-chart">
          <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 4" class="statistics-chart">
          <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 5" class="statistics-chart">
        </div>
        <div class="statistics-container">
          <div class="date-column">
            <div class="column-header">Tanggal</div>
          </div>
          <div class="quantity-column">
            <div class="column-header">Jumlah Sampah Dimasukkan</div>
          </div>
          <div class="category-column">
            <div class="column-header">Kategori</div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function fetchData() {
      $.ajax({
        url: 'https://smart-trashbin-api.onrender.com/api/getdata',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          var dateColumn = '';
          var quantityColumn = '';
          var categoryColumn = '';

          response.data.forEach(function(item) {
            var timestamp = item.timestamp;
            var category = item.category;
            dateColumn += `<div class="column-item">${timestamp}</div>`;
            quantityColumn += `<div class="column-item">1 Kali</div>`;
            categoryColumn += `<div class="column-item">${category}</div>`;
          });

          $('.date-column').html(`<div class="column-header">Tanggal</div>${dateColumn}`);
          $('.quantity-column').html(`<div class="column-header">Jumlah Sampah Dimasukkan</div>${quantityColumn}`);
          $('.category-column').html(`<div class="column-header">Kategori</div>${categoryColumn}`);
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
