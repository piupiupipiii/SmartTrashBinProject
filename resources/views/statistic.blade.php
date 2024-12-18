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
                        <!-- Data timestamp akan ditambahkan di sini -->
                    </div>
                    <div class="quantity-column">
                        <div class="column-header">Jumlah Sampah Dimasukkan</div>
                    </div>
                    <div class="category-column">
                        <div class="column-header">Kategori</div>
                        <!-- Data kategori akan ditambahkan di sini -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- MQTT.js -->
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

    <!-- Logika JavaScript -->
    <script>
        const API_URL = "https://smart-trashbin-api.onrender.com/api/getdata";

        // Mapping kode kategori ke teks
        const kategoriMap = {
            1: "Organik",
            2: "Anorganik",
            3: "B3",
        };

        // Fetch data API dan tampilkan ke date-column dan category-column
        function fetchData() {
            $.ajax({
                url: API_URL,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log("Data API:", response);
                    if (response.length > 0) {
                        populateColumns(response);
                    } else {
                        console.error("Data kosong.");
                    }
                },
                error: function(err) {
                    console.error("Gagal mengambil data:", err);
                },
            });
        }

        // Fungsi menambahkan timestamp dan kategori ke kolom
        function populateColumns(data) {
            let dateColumnContent = "";
            let categoryColumnContent = "";

            data.forEach((item) => {
                dateColumnContent += `
                    <div class="date-item">${item.timestamp}</div>
                `;
                categoryColumnContent += `
                    <div class="category-item">${kategoriMap[item.kategori] || "Tidak Diketahui"}</div>
                `;
            });

            // Tambahkan konten ke dalam kolom masing-masing
            $(".date-column").append(dateColumnContent);
            $(".category-column").append(categoryColumnContent);
        }

        // Koneksi ke MQTT broker untuk data real-time
        function connectMQTT() {
            const client = mqtt.connect("wss://broker.hivemq.com:8000/mqtt");
            const topic = "smart-trashbin";

            client.on("connect", function () {
                console.log("Terhubung ke MQTT Broker");
                client.subscribe(topic, function (err) {
                    if (!err) {
                        console.log("Berlangganan topik:", topic);
                    }
                });
            });

            client.on("message", function (topic, message) {
                const newData = JSON.parse(message.toString());
                console.log("Data MQTT:", newData);
                appendRealTimeData(newData);
            });
        }

        // Fungsi menambahkan data baru dari MQTT ke kolom
        function appendRealTimeData(newData) {
            const dateItem = `
                <div class="date-item">${newData.timestamp}</div>
            `;
            const categoryItem = `
                <div class="category-item">${kategoriMap[newData.kategori] || "Tidak Diketahui"}</div>
            `;

            $(".date-column").append(dateItem);
            $(".category-column").append(categoryItem);
        }

        // Eksekusi saat dokumen siap
        $(document).ready(function () {
            fetchData(); // Ambil data awal dari API
            connectMQTT(); // Hubungkan ke MQTT Broker
        });
    </script>
</body>
</html>
