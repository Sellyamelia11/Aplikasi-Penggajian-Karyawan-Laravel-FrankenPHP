@extends('layouts.app')

@section('content')
  <h2 class="text-3xl font-bold text-center md:text-center text-white drop-shadow-md tracking-wide mt-8">
    SISTEM PENGGAJIAN KARYAWAN
  </h2>
  
  <!-- Main Content -->
  <main class="px-6 md:px-24">
  <div class="mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    
    <!-- Left Text Section -->
    <div class="max-w-xl">
      <p class="text-lg text-black">
        <span class="text-red-600 font-semibold">Welcome,</span>
        <a href="#" class="text-black-100 font-semibold underline">Admin !</a>
      </p>
      
      <p class="mt-3 text-gray-800 leading-relaxed">
        Pantau dan kelola data karyawan serta penggajian mereka dengan mudah. Melalui sistem ini,
        Anda dapat menambahkan, memperbarui, dan menghapus data karyawan, serta mencatat rincian
        penggajian setiap periode dengan akurat.
      </p>
      
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('karyawan.index') }}"
          class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-700 transition">
          Data Karyawan
          </a>
        <a href="{{ route('gaji.index') }}"
          class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-700 transition">
          Gaji Karyawan
        </a>
      </div>
    </div>
    
    <!-- Right Image Section -->
    <div class="flex justify-center md:justify-end">
      <img src="assets/images/dashboard-illustration.png"
      alt="Gambar Dashboard"
      class="w-72 md:w-[450px] h-auto object-contain drop-shadow-lg">
    </div>

  </div>
  </main>
@endsection