@extends('layouts.app')

@section('title', 'Statistics - Segre Bin')

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
    </div>

    <!-- Filter Container -->
    <div class="filter-container">
        <div class="filter-order">
            <label for="filter-order">Urutkan Berdasarkan:</label>
            <select id="filter-order" class="filter-select">
                <option value="latest">Terbaru</option>
                <option value="oldest">Terlama</option>
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
@endsection

@push('scripts')
<!-- CDN jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Logika JavaScript -->
<script>
    const API_URL = "https://smart-trashbin-api.onrender.com/api/getdata";

    const kategoriMap = {
        1: "Organik",
        2: "Anorganik",
        3: "B3",
    };

    function fetchData(order = "latest", category = "all") {
        $.ajax({
            url: API_URL,
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log("Data API:", response);
                
                if (order === "latest") {
                    response.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
                } else if (order === "oldest") {
                    response.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
                }

                if (category !== "all") {
                    const kategoriKey = Object.keys(kategoriMap).find(
                        (key) => kategoriMap[key] === category
                    );
                    if (kategoriKey) {
                        response = response.filter((item) => item.kategori == kategoriKey);
                    }
                }

                populateColumns(response);
            },
            error: function (err) {
                console.error("Gagal mengambil data:", err);
            },
        });
    }

    function populateColumns(data) {
        $(".date-column").empty().append('<div class="column-header">Tanggal</div>');
        $(".category-column").empty().append('<div class="column-header">Kategori</div>');

        let dateContent = "";
        let categoryContent = "";

        data.forEach((item) => {
            dateContent += `<div class="date-item">${item.timestamp}</div>`;
            categoryContent += `<div class="category-item">${kategoriMap[item.kategori] || "Tidak Diketahui"}</div>`;
        });

        $(".date-column").append(dateContent);
        $(".category-column").append(categoryContent);
    }

    $(document).ready(function () {
        fetchData();

        $("#filter-order, #filter-category").change(function () {
            const order = $("#filter-order").val();
            const category = $("#filter-category").val();
            fetchData(order, category);
        });

        $("#search-button").click(function () {
            const order = $("#filter-order").val();
            const category = $("#filter-category").val();
            fetchData(order, category);
        });
    });
</script>
@endpush
