<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="py-20 px-6">

<div class="flex flex-col items-center text-center">

    <div class="p-10">
        <h3
            class="text-white text-6xl drop-shadow-lg"
            style="font-family: 'Pacifico', cursive;"
        >
            Cutieshoot
        </h3>

        <p class="mt-3 text-pink-100 text-lg tracking-[0.3em] uppercase">
            Capture • Smile • Memories
        </p>

        <p class="mt-5 text-white/75 max-w-sm leading-relaxed">
            Every click tells a story. Create beautiful memories with
            aesthetic filters, custom frames, and instant photostrips.
        </p>
    </div>

</div>

  </div>

</section>

<div class="max-w-5xl mx-auto my-8">
    <div class="h-px bg-white/40"></div>
</div>

<section class="text-center py-32">
    <h2
        class="text-white text-5xl mb-6 drop-shadow-lg"
        style="font-family: 'Pacifico', cursive;"
    >
        ~ Capture Your Moment ~
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
    <div class="h-px bg-white/40"></div>
</div>

<section class="py-20">
  <div class="text-center mb-10">

    <div class="relative mb-10">

      <h2  class="text-white text-5xl mb-6 drop-shadow-lg"
      style="font-family: 'Pacifico', cursive;">
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
                    No Photos Yet 
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

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection