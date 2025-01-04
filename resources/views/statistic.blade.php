@extends('layouts.app')

@section('title', 'Statistics - Smart Trash Bin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/statistic.css') }}">
@endpush

@section('content')
            <div class="statistics-wrapper">
                <div class="picture-container">
                    <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 1" class="statistics-chart">
                    <img src="{{ asset('image/trash.png') }}" alt="Statistik Gambar 2" class="statistics-chart">
                    <img src="{{ asset('image/stats.png') }}" alt="Statistik Gambar 3" class="statistics-chart">
                    <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 4" class="statistics-chart">
                    <img src="{{ asset('image/trash.png') }}" alt="Statistik Gambar 5" class="statistics-chart">
                    <img src="{{ asset('image/stats.png') }}" alt="Statistik Gambar 6" class="statistics-chart">
                    <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 7" class="statistics-chart">
                    <img src="{{ asset('image/trash.png') }}" alt="Statistik Gambar 8" class="statistics-chart">
                    <img src="{{ asset('image/stats.png') }}" alt="Statistik Gambar 9" class="statistics-chart">
                    <img src="{{ asset('image/leaf.png') }}" alt="Statistik Gambar 10" class="statistics-chart">
                </div>

                <!-- Filter Container -->
                <div class="filter-container">
                    <div class="filter-date">
                        <label for="filter-date">Filter Tanggal:</label>
                        <select id="filter-date" class="filter-select">
                            <option value="all">Semua</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                        </select>
                    </div>
                    <div class="filter-category">
                        <label for="filter-category">Filter Kategori:</label>
                        <select id="filter-category" class="filter-select">
                            <option value="all">Semua</option>
                            <option value="Organik">Organik</option>
                            <option value="Anorganik">Anorganik</option>
                            <option value="B3">B3</option>
                        </select>
                    </div>
                </div>
            </div>
                
                <div class="statistics-container">
                    <div class="date-column">
                        <div class="column-header">Tanggal</div>
                    </div>
                    <div class="category-column">
                        <div class="column-header">Kategori</div>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
    <!-- MQTT.js -->
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

    <!-- Logika JavaScript -->
    <script>
        const API_URL = "https://smart-trashbin-api.onrender.com/api/getdata";

        const kategoriMap = {
            1: "Organik",
            2: "Anorganik",
            3: "B3",
        };

        function fetchData() {
            $.ajax({
                url: API_URL,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log("Data API:", response);
                    populateColumns(response);
                },
                error: function(err) {
                    console.error("Gagal mengambil data:", err);
                },
            });
        }

        function populateColumns(data) {
            let dateContent = "";
            let categoryContent = "";

            data.forEach((item) => {
                dateContent += `<div class="date-item">${item.timestamp}</div>`;
                categoryContent += `<div class="category-item">${kategoriMap[item.kategori] || "Tidak Diketahui"}</div>`;
            });

            $(".date-column").append(dateContent);
            $(".category-column").append(categoryContent);
        }

        function filterData() {
            const selectedFilter = $("#filter-date").val(); 
            const selectedCategory = $("#filter-category").val(); 

            $.ajax({
                url: API_URL,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let filteredData = response;

                    // Filter tanggal
                    if (selectedFilter !== "all") {
                        const now = new Date();
                        filteredData = response.filter((item) => {
                            const date = new Date(item.timestamp);
                            if (selectedFilter === "today") {
                                return date.toDateString() === now.toDateString();
                            } else if (selectedFilter === "week") {
                                const startOfWeek = new Date(now.setDate(now.getDate() - now.getDay()));
                                const endOfWeek = new Date(now.setDate(startOfWeek.getDate() + 6));
                                return date >= startOfWeek && date <= endOfWeek;
                            } else if (selectedFilter === "month") {
                                return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
                            }
                        });
                    }

                    // Filter kategori
                    if (selectedCategory !== "all") {
                        filteredData = filteredData.filter(
                            (item) => kategoriMap[item.kategori] === selectedCategory
                        );
                    }

                    populateColumns(filteredData);
                },
            });
        }

        $(document).ready(function () {
            fetchData();

            // Event handler untuk dropdown filter
            $("#filter-date, #filter-category").change(function () {
                filterData();
            });
        });

    </script>
@endpush
