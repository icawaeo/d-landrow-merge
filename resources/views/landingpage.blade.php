<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>D-LANDROW</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
    }
  </style>
</head>
<body class="relative h-screen overflow-hidden">

  <!-- Background -->
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bg-landing.png') }}');"></div>

  <!-- Logo BUMN kiri atas -->
  <img src="{{ asset('images/logo-bumn.png') }}" alt="BUMN" class="absolute top-6 left-6 w-40 md:w-32">
  <!-- Logo PLN kanan atas -->
  <img src="{{ asset('images/logo-pln.png') }}" alt="PLN" class="absolute top-6 right-6 w-20 md:w-16">

  <!-- Logo PLN Mobile & AKHLAK kiri bawah -->
  <div class="absolute bottom-6 left-6 flex space-x-4">
    <img src="{{ asset('images/pln-mobile-logo.png') }}" alt="PLN Mobile" class="w-28 md:w-22">
    <img src="{{ asset('images/logo-akhlak.png') }}" alt="AKHLAK" class="w-28 md:w-22">
  </div>

  <!-- Konten teks dan tombol -->
  <div class="relative z-10 h-full flex items-center justify-end pr-[10vw] md:pr-[5vw]">
    <div class="text-right transform -translate-y-20 md:-translate-y-12 mr-16 md:mr-8">
      <h1 class="text-6xl md:text-5xl font-extrabold italic text-[#0a3a4a] drop-shadow-lg">
        D-LANDROW
      </h1>
      <p class="text-lg md:text-base uppercase tracking-widest text-[#0a3a4a] mt-2">
        SISTEM DIGITALISASI PENGADAAN TANAH & ROW
      </p>
      <a href="{{ route('login') }}"
         class="inline-block mt-6 px-8 py-3 bg-[#0a3a4a] text-white font-semibold rounded-full shadow-lg border-b-4 border-white hover:bg-[#082f3b] transition">
        Login With IAM
      </a>
    </div>
  </div>

</body>
</html>
