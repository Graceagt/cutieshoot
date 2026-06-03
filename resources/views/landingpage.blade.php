@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="py-24 px-6">

  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">

      <!-- Left -->
      <div class="flex flex-col items-center">

          <!-- Logo -->
          <div class="bg-white/20 backdrop-blur-md rounded-3xl p-10 shadow-xl">
            <div class="text-8xl">📸</div>
            <h3 class="text-white text-2xl font-bold mt-4">
                Cutieshoot
            </h3>
        </div>

      </div>

      <!-- Right -->
      <div>

          <span class="bg-white/20 backdrop-blur-md text-white px-4 py-2 rounded-full text-sm">
              📸 Online Photobooth
          </span>

          <h1 class="text-white text-5xl font-bold mt-6 mb-6">
              Cutieshoot ✨
          </h1>

          <p class="text-white/80 text-lg leading-relaxed mb-6">
              Cutieshoot is an online photobooth designed to help you
              capture memorable moments with aesthetic filters,
              customizable frames, and beautiful photo strips.
          </p>

          <p class="text-white/70 leading-relaxed mb-8">
              Take photos directly from your camera, choose your
              favorite shots, create unique photostrips, and save
              them instantly. Perfect for making fun memories with
              friends, family, or yourself.
          </p>
      </div>

  </div>

</section>

<div class="max-w-5xl mx-auto my-8">
  <div class="h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
</div>

<section class="text-center py-32">
    <h2 class="text-white text-5xl font-bold mb-6">
        Capture Your Moment ✨
    </h2>

    <p class="text-white/80 text-lg mb-8">
        Aesthetic photobooth for your memories
    </p>

    <a href="{{ route('booth') }}"
       class="bg-white text-pink-600 font-semibold px-8 py-3 rounded-2xl shadow-lg hover:scale-105 transition duration-300">
        Start Booth
    </a>
</section>

<div class="max-w-4xl mx-auto my-8">
  <div class="h-px bg-white/20"></div>
</div>

<section class="py-20">
  <div class="text-center mb-10">

    <div class="relative mb-10">

      <h2 class="text-white text-4xl font-bold text-center">
          Gallery 📸
      </h2>
  
      <a href="{{ route('gallery') }}"
         class="absolute right-10 top-1/2 -translate-y-1/2 bg-white text-pink-600 px-4 py-2 rounded-xl font-medium shadow hover:scale-105 transition">
          View All →
      </a>
  
  </div>
  
  <p class="text-white/70 mb-10 text-center">
      Moments captured from our photobooth
  </p>

</div>

        <div class="grid grid-cols-3 md:grid-cols-5 gap-3 justify-items-center">

            @forelse ($photos as $photo)
                <div class="bg-white/20 backdrop-blur-md p-2 rounded-xl shadow border border-white/20 w-18">

                    <img
                        src="{{ asset('storage/' . $photo->image) }}"
                        alt="Photo"
                        onclick="openModal('{{ asset('storage/' . $photo->image) }}')"
                        class="rounded-lg w-full aspect-square object-cover cursor-pointer hover:scale-105 transition duration-300"
                    >

                    <div class="text-xs mt-1 text-white/80 text-center">
                        {{ $photo->created_at->format('d M Y') }}
                    </div>

                </div>
            @empty
                <p class="col-span-full text-white/60">
                    No Photos Yet ✨
                </p>
            @endforelse

        </div>

    </div>
</section>


<!-- Modal -->
<div id="imageModal"
     class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50"
     onclick="closeModal()">

    <button
        type="button"
        onclick="closeModal()"
        class="absolute top-5 right-6 text-white text-5xl hover:text-gray-300">
        &times;
    </button>

    <img
        id="modalImage"
        class="max-w-[90vw] max-h-[90vh] rounded-xl shadow-2xl"
        onclick="event.stopPropagation()"
    >
</div>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}

// Tutup modal dengan tombol ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection