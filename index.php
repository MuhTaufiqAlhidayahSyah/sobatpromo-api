<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SobatPromo – Promo Terbaik Hari Ini</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
      padding: 20px;
      max-width: 600px;
      margin: 20px auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .promo {
      margin: 10px 0;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background: #fafafa;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }

    .promo b {
      font-size: 18px;
      color: #2b2b2b;
    }

    .promo small {
      display: block;
      color: #555;
      margin: 5px 0;
    }

    .promo em {
      color: #8b5a2b;
      font-style: italic;
    }

    footer {
      text-align: center;
      padding: 15px;
      background: #000;
      color: white;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <header>SobatPromo</header>

  <main>
    <h2>Promo Terbaru</h2>
    <div id="promoList">Memuat promo...</div>
  </main>

  <footer>
    &copy; <?php echo date("Y"); ?> SobatPromo – Temukan promo terbaikmu!
  </footer>

  <script>
    async function loadInternal() {
      const apiURL = "https://sobatpromo-api-production.up.railway.app/api.php?action=list";

      try {
        const response = await fetch(apiURL);
        const data = await response.json();

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
              </div>
            `;
          });
        }

        document.getElementById("promoList").innerHTML = html;
      } catch (error) {
        console.error("Error:", error);
        document.getElementById("promoList").innerHTML = "⚠️ Gagal memuat data dari API.";
      }
    }

    window.onload = loadInternal;
  </script>

</body>
</html>
