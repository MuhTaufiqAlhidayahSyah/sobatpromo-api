<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SobatPromo</title>
</head>
<body>
  <h1>Daftar Promo</h1>
  <div id="promoList">Memuat data...</div>

  <script>
  async function loadPromos() {
    const res = await fetch("https://sobatpromo-production.up.railway.app/api.php?action=list");
    const data = await res.json();
    let html = "";
    data.forEach(p => {
      html += `<p><b>${p.title}</b> - ${p.description} (berlaku hingga ${p.valid_until})</p>`;
    });
    document.getElementById("promoList").innerHTML = html;
  }
  loadPromos();
  </script>
</body>
</html>
