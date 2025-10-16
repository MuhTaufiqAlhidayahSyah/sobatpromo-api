<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SobatPromo – API Kelompok Lain</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #fff5e1, #8b5a2b);
      margin:0; padding:0;
    }
    header {
      background:#000; color:#fff; text-align:center;
      padding:20px 10px; font-size:24px; font-weight:bold;
    }
    main {
      max-width:700px; margin:20px auto; background:white;
      padding:20px; border-radius:12px;
      box-shadow:0 4px 12px rgba(0,0,0,0.1);
    }
    button {
      background:#000; color:white; border:none;
      padding:10px 15px; border-radius:8px; cursor:pointer;
      transition:0.3s;
    }
    button:hover { background:#8b5a2b; }
    .group-buttons { display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-bottom:20px; }
    .promo {
      border:1px solid #ddd; border-radius:10px;
      padding:15px; margin-bottom:10px;
      background:#fafafa; box-shadow:0 0 5px rgba(0,0,0,0.05);
    }
    .promo b { font-size:18px; }
    .promo small { display:block; color:#555; margin:5px 0; }
    .promo em { color:#8b5a2b; }
    .actions button.delete { background:#a00000; }
    footer {
      text-align:center; padding:15px; background:#000;
      color:white; font-size:14px; margin-top:40px;
    }
  </style>
</head>
<body>
  <header>API Kelompok Lain</header>
  <main>
    <div class="group-buttons" id="kelompokButtons"></div>

    <div id="promoList">Pilih kelompok untuk memuat datanya...</div>

    <div style="text-align:center; margin-top:20px;">
      <button onclick="window.location.href='index.php'">⬅️ Kembali ke Halaman Utama</button>
    </div>
  </main>
  <footer>
    &copy; <?php echo date("Y"); ?> SobatPromo – API Antar Kelompok
  </footer>

  <script>
    const kelompokAPIs = {
      1: "https://sprightly-starburst-ae6a2a.netlify.app/api/public/products",
      2: "https://tripnesia-vm51.vercel.app/api/bookings?action=list",
      3: "http://www.cvjayatehnik.com/api/recomendations.php",
      4: "https://projekkelompok4-production-3d9b.up.railway.app/api/makanan",
      5: "https://projek5-production.up.railway.app/api/kopi",
      6: "https://rsjauhzcwslcsoktbplq.supabase.co/rest/v1/reservasi",
      8: "https://kelompok8.up.railway.app/api.php",
      9: "https://projekkelompok9-production.up.railway.app/api/get_dataAOV.php"
    };

    // --- Generate tombol kelompok ---
    const container = document.getElementById("kelompokButtons");
    Object.keys(kelompokAPIs).forEach(num => {
      const btn = document.createElement("button");
      btn.textContent = "Kelompok " + num;
      btn.onclick = () => loadExternalAPI(num);
      container.appendChild(btn);
    });

    // --- Ambil data dari API eksternal ---
    async function loadExternalAPI(num) {
      const apiURL = `${kelompokAPIs[num]}`;
      document.getElementById("promoList").innerHTML = `<p>Sedang memuat data dari Kelompok ${num}...</p>`;
      try {
        const res = await fetch(apiURL);
        const raw = await res.json();

        // deteksi struktur data otomatis
        let data = [];
        if (Array.isArray(raw)) {
          data = raw;
        } else if (raw.data && Array.isArray(raw.data)) {
          data = raw.data;
        } else if (raw.results && Array.isArray(raw.results)) {
          data = raw.results;
        } else if (raw.records && Array.isArray(raw.records)) {
          data = raw.records;
        } else {
          console.warn("Format tidak dikenali:", raw);
          data = [];
        }

        renderPromos(data, kelompokAPIs[num], num);
      } catch (err) {
        console.error("Gagal memuat data:", err);
        document.getElementById("promoList").innerHTML =
          `<p style="color:red;">Gagal memuat data dari Kelompok ${num}.</p>`;
      }
    }

    // --- Tampilkan daftar promo ---
    function renderPromos(data, baseURL, num) {
      let html = `
        <h3>Data dari ${baseURL}</h3>
        <button onclick="showAddForm('${baseURL}', ${num})">Tambah Data</button>
      `;

      if (!Array.isArray(data) || data.length === 0) {
        html += "<p>Tidak ada data.</p>";
      } else {
        data.forEach(item => {
          html += `
            <div class="promo">
              <b>${item.title || item.name || item.product_name || item.judul || 'Tanpa Judul'}</b>
              <small>${item.description || item.deskripsi || item.detail || item.desc || 'Tanpa deskripsi'}</small>
              <em>${item.valid_until || item.tanggal || item.date || item.created_at || ''}</em>
              <div class="actions">
                <button onclick="editData('${baseURL}', ${item.id || item.ID || 0}, '${item.title || item.name || ''}', '${item.description || item.deskripsi || ''}', '${item.valid_until || ''}')">Edit</button>
                <button class="delete" onclick="deleteData('${baseURL}', ${item.id || item.ID || 0})">Hapus</button>
              </div>
            </div>`;
        });
      }
      document.getElementById("promoList").innerHTML = html;
    }

    // --- Form tambah data ---
    function showAddForm(baseURL, num) {
      document.getElementById("promoList").innerHTML = `
        <h3>Tambah Data Baru</h3>
        <input id="title" placeholder="Judul"><br>
        <textarea id="description" placeholder="Deskripsi"></textarea><br>
        <input id="valid_until" type="date"><br>
        <button onclick="saveData('${baseURL}', ${num})">Simpan</button>
        <button onclick="loadExternalAPI(${num})">Batal</button>
      `;
    }

    // --- Simpan data baru ---
    async function saveData(baseURL, num) {
      const title = document.getElementById("title").value;
      const description = document.getElementById("description").value;
      const valid_until = document.getElementById("valid_until").value;
      try {
        const res = await fetch(`${baseURL}?action=create`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ title, description, valid_until })
        });
        alert("Data berhasil disimpan");
        loadExternalAPI(num);
      } catch (err) {
        alert("Gagal menyimpan data");
      }
    }

    // --- Edit data ---
    function editData(baseURL, id, title, description, valid_until) {
      document.getElementById("promoList").innerHTML = `
        <h3>Edit Data</h3>
        <input id="title" value="${title}"><br>
        <textarea id="description">${description}</textarea><br>
        <input id="valid_until" type="date" value="${valid_until}"><br>
        <button onclick="updateData('${baseURL}', ${id})">Perbarui</button>
        <button onclick="window.location.reload()">Batal</button>
      `;
    }

    // --- Update data ---
    async function updateData(baseURL, id) {
      const title = document.getElementById("title").value;
      const description = document.getElementById("description").value;
      const valid_until = document.getElementById("valid_until").value;
      try {
        await fetch(`${baseURL}?action=update&id=${id}`, {
          method: "PUT",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ title, description, valid_until })
        });
        alert("Data diperbarui");
        window.location.reload();
      } catch (err) {
        alert("Gagal memperbarui data");
      }
    }

    // --- Hapus data ---
    async function deleteData(baseURL, id) {
  if (!confirm("Hapus data ini?")) return;
  try {
    // coba dulu pakai DELETE
    let res = await fetch(`${baseURL}?action=delete&id=${id}`, { method: "DELETE" });

    // kalau gagal, coba lagi pakai POST
    if (!res.ok) {
      res = await fetch(`${baseURL}?action=delete&id=${id}`, { method: "POST" });
    }

    const result = await res.json();
    alert(result.message || "Data dihapus (respons tidak diketahui)");
    location.reload();
  } catch (err) {
    alert("Gagal menghapus data: " + err.message);
  }
}

  </script>
</body>
</html>

