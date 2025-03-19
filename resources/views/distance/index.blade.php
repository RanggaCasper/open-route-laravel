<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Rute Lokasi dengan Leaflet</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Bootstrap CSS untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center">Peta Rute Lokasi</h1>

    <!-- Form untuk memasukkan dua lokasi -->
    <div class="form-group">
        <label for="location1">Lokasi 1:</label>
        <input type="text" id="location1" class="form-control" placeholder="Masukkan lokasi pertama">
    </div>
    <div class="mt-3 form-group">
        <label for="location2">Lokasi 2:</label>
        <input type="text" id="location2" class="form-control" placeholder="Masukkan lokasi kedua">
    </div>
    <button id="btn" class="mt-3 btn btn-primary">Cari Rute</button>

    <!-- Peta akan ditampilkan di sini -->
    <x-card
    <div id="map"></div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // API key sebaiknya disembunyikan untuk alasan keamanan
    const apiKey = "5b3ce3597851110001cf62481e8742d73f854911923ceb0967d16137";

    // Event listener untuk tombol
    $(document).ready(function() {
        $("#btn").on("click", function () {
            const location1 = $("#location1").val();
            const location2 = $("#location2").val();

            if (location1 && location2) {
                // Kirim permintaan ke backend Laravel menggunakan AJAX
                $.ajax({
                    url: '{{ route('distance.get') }}',  // Ubah endpoint ke yang sesuai dengan server Anda
                    type: 'GET',
                    data: {
                        location1: location1,
                        location2: location2
                    },
                    success: function(data) {
                        if (data.error) {
                            console.error('Error:', data.error);
                        } else {
                            // Dapatkan rute dan tampilkan di peta
                            const coordinates1 = data.route.features[0].geometry.coordinates[0]; // [longitude, latitude]
                            const coordinates2 = data.route.features[0].geometry.coordinates[data.route.features[0].geometry.coordinates.length - 1]; // [longitude, latitude]
                            
                            const map = L.map("map").setView([coordinates1[1], coordinates1[0]], 13);

                            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                                attribution: '© OpenStreetMap contributors',
                            }).addTo(map);

                            // Tambahkan marker untuk kedua lokasi
                            [coordinates1, coordinates2].forEach(function (loc, index) {
                                L.marker([loc[1], loc[0]])
                                    .addTo(map)
                                    .bindPopup("Location " + (index + 1))
                                    .openPopup();
                            });

                            // Ambil koordinat rute dan buat polyline untuk rute
                            const routeCoordinates = data.route.features[0].geometry.coordinates;
                            const latLngs = routeCoordinates.map(function (coord) {
                                return [coord[1], coord[0]]; // [latitude, longitude]
                            });

                            L.polyline(latLngs, { color: "blue", weight: 5 }).addTo(map);

                            map.fitBounds(latLngs);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            } else {
                console.log("Please enter both locations.");
            }
        });
    });
</script>

</body>
</html>
