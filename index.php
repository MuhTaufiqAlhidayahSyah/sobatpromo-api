<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SobatPromo – Manajemen Promo</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #fff5e1, #8b5a2b);
      margin: 0;
      padding: 0;
    }

    header {
      background: #000;
      color: white;
      text-align: center;
      padding: 20px 10px;
      font-size: 24px;
      font-weight: bold;
    }

    main {
      max-width: 700px;
      margin: 20px auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 25px;
    }

    input, textarea {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    button {
      background: #000;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #8b5a2b;
    }

    .nav-btn {
      text-align: center;
      margin-bottom: 20px;
    }

    .promo {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 10px;
      background: #fafafa;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }

    .promo b {
      font-size: 18px;
    }

    .promo small {
      display: block;
      color: #555;
      margin: 5px 0;
    }

    .promo em {
      color: #8b5a2b;
    }

    .actions {
      margin-top: 8px;
    }

    .actions button {
      margin-right: 8px;
      background: #333;
    }

    .actions button.delete {
      background: #a00000;
    }

    footer {
      text-align: center;
      padding: 15px;
      background: #000;
      color: white;
      font-size: 14px;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <header>SobatPromo</header>

  <main>
    <h2>Kelola Promo</h2>

    <!-- Tombol ke halaman API Kelompok Lain -->
    <div class="nav-btn">
      <button onclick="window.location.href='apilain.php'">🌐 API Kelompok Lain</button>
    </div>

    <!-- Form Tambah / Edit Promo -->
    <form id="promoForm">
      <input type="hidden" id="promoId" />
      <input type="text" id="title" placeholder="Judul Promo" required />
      <textarea id="description" placeholder="Deskripsi Promo" required></textarea>
      <input type="date" id="valid_until" required />
      <button type="submit">Tambah Promo</button>
    </form>

    <div id="promoList">Memuat promo...</div>
  </main>

  <footer>
    &copy; <?php echo date("Y"); ?> SobatPromo – CRUD by Railway
  </footer>

  <script>
    const API_URL = "https://sobatpromo-api-production.up.railway.app/api.php";

    async function loadPromos() {
      const res = await fetch(`${API_URL}?action=list`);
      const data = await res.json();
      let html = "";

      if (data.length === 0) {
        html = "<p>Tidak ada promo saat ini.</p>";
      } else {
        data.forEach(item => {
          html += `
            <div class="promo">
              <b>${item.title}</b>
              <small>${item.description}</small>
              <em>Berlaku sampai ${item.valid_until}</em>
              <div class="actions">
                <button onclick="editPromo(${item.id}, '${item.title}', '${item.description}', '${item.valid_until}')">Edit</button>
                <button class="delete" onclick="deletePromo(${item.id})">Hapus</button>
              </div>
            </div>
          `;
        });
      }
      document.getElementById("promoList").innerHTML = html;
    }

    async function createPromo(e) {
      e.preventDefault();
      const id = document.getElementById("promoId").value;
      const title = document.getElementById("title").value;
      const description = document.getElementById("description").value;
      const valid_until = document.getElementById("valid_until").value;

      const method = id ? "PUT" : "POST";
      const action = id ? `update&id=${id}` : "create";

      const res = await fetch(`${API_URL}?action=${action}`, {
        method: method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title, description, valid_until })
      });

      const result = await res.json();
      alert(result.message || "Berhasil!");

      document.getElementById("promoForm").reset();
      document.querySelector("#promoForm button").textContent = "Tambah Promo";
      loadPromos();
    }

    async function deletePromo(id) {
      if (!confirm("Yakin ingin menghapus promo ini?")) return;

      const res = await fetch(`${API_URL}?action=delete&id=${id}`, { method: "DELETE" });
      const result = await res.json();
      alert(result.message || "Promo dihapus.");
      loadPromos();
    }

    function editPromo(id, title, description, valid_until) {
      document.getElementById("promoId").value = id;
      document.getElementById("title").value = title;
      document.getElementById("description").value = description;
      document.getElementById("valid_until").value = valid_until;
      document.querySelector("#promoForm button").textContent = "Perbarui Promo";
    }

    document.getElementById("promoForm").addEventListener("submit", createPromo);

    window.onload = loadPromos;
  </script>
</body>
</html>
