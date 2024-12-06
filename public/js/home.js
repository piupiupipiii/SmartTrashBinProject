// Fungsi untuk mengambil data dari server dengan endpoint yang diberikan
async function fetchData(endpoint) {
    try {
      const response = await fetch(endpoint);
      if (!response.ok) throw new Error(`Failed to fetch data from ${endpoint}`);
      return await response.json();
    } catch (error) {
      console.error(`Error fetching data from ${endpoint}:`, error);
      return null; // Kembalikan null jika terjadi error
    }
  }
  
  // Mengambil dan memperbarui status kapasitas tong sampah organik, anorganik, dan B3
  async function getStatus() {
    const data = await fetchData('/api/status'); // Mengambil data status dari endpoint
    if (data) {
      // Mengelompokkan data berdasarkan kategori
      const organikData = data.filter(item => item.kategori === 1); // Organik kategori 1
      const anorganikData = data.filter(item => item.kategori === 2); // Anorganik kategori 2
      const b3Data = data.filter(item => item.kategori === 3); // B3 kategori 3
  
      // Menghitung rata-rata jarak untuk organik
      const organikDistance = organikData.length > 0
        ? organikData.reduce((sum, item) => sum + item.jarak, 0) / organikData.length
        : 0;
  
      // Menghitung rata-rata jarak untuk anorganik
      const anorganikDistance = anorganikData.length > 0
        ? anorganikData.reduce((sum, item) => sum + item.jarak, 0) / anorganikData.length
        : 0;
  
      // Menghitung rata-rata jarak untuk B3
      const b3Distance = b3Data.length > 0
        ? b3Data.reduce((sum, item) => sum + item.jarak, 0) / b3Data.length
        : 0;
  
      // Update kapasitas organik
      document.getElementById('jarak-organik').textContent = `Jarak: ${organikDistance} cm`;
      document.getElementById('volume-organik').textContent = `Volume: ${organikDistance}%`;
      const organikCapacityFill = document.getElementById('capacity-fill-organik');
      const remainingDistanceOrganik = document.getElementById('remaining-distance-organik');
      organikCapacityFill.style.width = `${organikDistance}%`;  // Menyesuaikan lebar bar kapasitas
      remainingDistanceOrganik.textContent = `${100 - organikDistance}%`; // Menampilkan sisa kapasitas
  
      // Update kapasitas anorganik
      document.getElementById('jarak-anorganik').textContent = `Jarak: ${anorganikDistance} cm`;
      document.getElementById('volume-anorganik').textContent = `Volume: ${anorganikDistance}%`;
      const anorganikCapacityFill = document.getElementById('capacity-fill-anorganik');
      const remainingDistanceAnorganik = document.getElementById('remaining-distance-anorganik');
      anorganikCapacityFill.style.width = `${anorganikDistance}%`;  // Menyesuaikan lebar bar kapasitas
      remainingDistanceAnorganik.textContent = `${100 - anorganikDistance}%`; // Menampilkan sisa kapasitas
  
      // Update kapasitas B3
      document.getElementById('jarak-b3').textContent = `Jarak: ${b3Distance} cm`;
      document.getElementById('volume-b3').textContent = `Volume: ${b3Distance}%`;
      const b3CapacityFill = document.getElementById('capacity-fill-b3');
      const remainingDistanceB3 = document.getElementById('remaining-distance-b3');
      b3CapacityFill.style.width = `${b3Distance}%`;  // Menyesuaikan lebar bar kapasitas
      remainingDistanceB3.textContent = `${100 - b3Distance}%`; // Menampilkan sisa kapasitas
    } else {
      alert('Gagal mengambil data status tong sampah, coba lagi nanti.');
    }
  }
  
  // Memanggil fungsi saat halaman pertama kali dimuat
  window.onload = getStatus;
  