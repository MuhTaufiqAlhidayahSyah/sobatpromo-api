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
      margin: 0; padding: 0;
    }
    header {
      background: #000; color: white;
      text-align: center; padding: 20px 10px;
      font-size: 24px; font-weight: bold;
    }
    main {
      max-width: 700px; margin: 20px auto;
      background: white; padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    button {
      background: #000; color: white;
      border: none; padding: 10px 15px;
      border-radius: 8px; cursor: pointer;
      transition: 0.3s;
    }
    button:hover { background: #8b5a2b; }
    .nav-btn { display:block; margin:20px auto; text-align:center; }
    /* (style CRUD sama seperti versi sebelumnya) */
  </style>
</head>
<body>
  <header>SobatPromo</header>
  <main>
    <h2>Kelola Promo</h2>

    <!-- Tombol ke halaman API Lain -->
    <div class="nav-btn">
      <button onclick="window.location.href='apilain.php'">API Kelompok Lain</button>
    </div>

    <!-- Form CRUD kamu (tetap sama seperti versi sebelumnya) -->
    <!-- ...seluruh isi CRUD form dan daftar promo di sini... -->
  </main>
  <footer>
    &copy; <?php echo date("Y"); ?> SobatPromo – CRUD by Railway
  </footer>
</body>
</html>
