<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SobatPromo - Demo API Kelompok</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #FFF5E1, #8B5A2B);
      margin: 0;
      padding: 20px;
      color: #333;
    }
    h1, h2 { text-align: center; }
    .buttons {
      text-align: center;
      margin-bottom: 20px;
    }
    .buttons button {
      background-color: black;
      color: white;
      margin: 5px;
      border: none;
      padding: 10px 15px;
      border-radius: 8px;
      cursor: pointer;
    }
    .promo {
      border: 1px solid #ccc;
      background-color: white;
      padding: 10px;
      border-radius: 8px;
      margin: 10px auto;
      width: 80%;
    }
    .form-container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      margin: 20px auto;
    }
    input, textarea {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .btn {
      background: black;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
    }
    .btn:hover { background: #333; }
  </style>
</head>
<body>

<h1>🌐 SobatPromo API Dashboard</h1>

<div class="buttons">
  <!-- tombol kelompok -->
  <script>
    for (let i = 1; i <= 10; i++) {
      if (i !== 7) document.write(`<button onclick="loadAPI(${i})">Kelompok ${i}</button>`);
    }
  </script>
</div>

<h2 id="apiTitle">Pilih API Kelompok</h2>

<div id="promoList"></div>

<!-- FORM CRUD -->
<div class="form-container">
  <h3>Tambah / Update Data</h3>
  <input type="hidden" id="id">
  <input type="text" id="title" placeholder="Judul / Nama">
  <textarea id="description" placeholder="Deskripsi"></textarea>
  <input type="text" id="price" placeholder="Harga (opsional)">
  <button class="btn" onclick="createOrUpdate()">Simpan</button>
</div>

<script>
const apiList = {
  1: "https://projekkelompok1-production.up.railway.app/api/produk",
  2: "https://projekkelompok2-production.up.railway.app/api/barang",
  3: "https://projekkelompok3-production.up.railway.app/api/promo",
  4: "https://projekkelompok4-production-3d9b.up.railway.app/api/makanan",
  5: "https://projekkelompok5-production.up.railway.app/api/data",
  6: "https://projekkelompok6-production.up.railway.app/api/game",
  8: "https://projekkelompok8-production.up.railway.app/api/toko",
  9: "https://projekkelompok9-production.up.railway.app/api/get_dataWR.php",
  10:"https://projekkelompok10-production.up.railway.app/api/barang"
};

let currentAPI = "";

async function loadAPI(num) {
  currentAPI = apiList[num];
  document.getElementById("apiTitle").textContent = "Kelompok " + num;
  document.getElementById("promoList").innerHTML = "Memuat data...";
  
  try {
    const res = await fetch(`https://sobatpromo.infinityfree.me/proxy.php?url=${encodeURIComponent(currentAPI)}`);
    const data = await res.json();
    console.log("Data Kelompok " + num + ":", data);

    const items = Array.isArray(data) ? data : data.data;
    if (!Array.isArray(items)) {
      document.getElementById("promoList").innerHTML = "Format data tidak sesuai.";
      return;
    }

    let html = "";
    items.forEach(item => {
      html += `
        <div class="promo">
          <b>${item.title || item.name || item.penjual || "Tanpa Judul"}</b><br>
          <small>${item.description || item.deskripsi || "Tidak ada deskripsi"}</small><br>
          <em>Harga: ${item.price || "0"}</em><br>
          <button class="btn" onclick="editData(${item.id}, '${item.title || item.name || item.penjual}', '${item.description || item.deskripsi}', '${item.price || ''}')">Edit</button>
          <button class="btn" onclick="deleteData(${item.id})">Hapus</button>
        </div>
      `;
    });
    document.getElementById("promoList").innerHTML = html;

  } catch (e) {
    console.error(e);
    document.getElementById("promoList").innerHTML = "Gagal memuat data.";
  }
}

// Fungsi Create / Update
async function createOrUpdate() {
  if (!currentAPI) {
    alert("Pilih API terlebih dahulu!");
    return;
  }

  const id = document.getElementById("id").value;
  const title = document.getElementById("title").value;
  const description = document.getElementById("description").value;
  const price = document.getElementById("price").value;

  const formData = new FormData();

  // deteksi API yang sedang aktif
  if (currentAPI.includes("kelompok9")) {
    formData.append("penjual", title);
    formData.append("deskripsi", description);
    formData.append("price", price);
    formData.append("skin", "0");
    formData.append("level", "0");
    formData.append("hero", "0");
  } else {
    formData.append("title", title);
    formData.append("description", description);
    formData.append("valid_until", price);
  }

  const endpoint = id
    ? `${currentAPI}?action=update`
    : `${currentAPI}?action=create`;

  try {
    const res = await fetch(endpoint, { method: "POST", body: formData });
    const result = await res.json();
    alert(result.message || "Berhasil disimpan!");
    loadAPI(Object.keys(apiList).find(key => apiList[key] === currentAPI));
  } catch (e) {
    console.error(e);
    alert("Gagal menyimpan data.");
  }
}



// Fungsi Delete
async function deleteData(id) {
  if (!confirm("Yakin ingin menghapus data ini?")) return;

  const endpoint = `${currentAPI}?action=delete&id=${id}`;
  try {
    const res = await fetch(endpoint);
    const result = await res.json();
    alert(result.message || "Berhasil dihapus!");
    loadAPI(Object.keys(apiList).find(key => apiList[key] === currentAPI));
  } catch (e) {
    console.error(e);
    alert("Gagal menghapus data.");
  }
}


function editData(id, title, description, price) {
  document.getElementById("id").value = id;
  document.getElementById("title").value = title;
  document.getElementById("description").value = description;
  document.getElementById("price").value = price;
  window.scrollTo(0, document.body.scrollHeight);
}
</script>

</body>
</html>
