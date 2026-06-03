@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

<section class="py-16 px-4">

    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">
                Gallery 📸
            </h1>

            <p class="text-white/70">
                All moments captured from Cutieshoot
            </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 justify-items-center">

            @forelse($photos as $photo)
        
                <div class="bg-white/20 backdrop-blur-md p-2 rounded-2xl shadow-lg border border-white/20 w-44">
        
                    <img
                        src="{{ asset('storage/' . $photo->image) }}"
                        alt="Photo"
                        onclick="openModal('{{ asset('storage/' . $photo->image) }}')"
                        class="rounded-xl w-full aspect-square object-cover cursor-pointer hover:scale-105 transition duration-300"
                    >
        
                </div>
        
            @empty
        
                <div class="col-span-full text-center text-white/60">
                    No photos available ✨
                </div>
        
            @endforelse
        
        </div>

        </div>

    </div>

</section>

<!-- Modal -->
<div id="imageModal"
     class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50"
     onclick="closeModal()">

    <div class="relative" onclick="event.stopPropagation()">

        <button
            type="button"
            onclick="closeModal()"
            class="absolute -top-12 right-0 text-white text-5xl hover:text-gray-300">
            &times;
        </button>

        <img
            id="modalImage"
            class="max-w-[90vw] max-h-[80vh] rounded-2xl shadow-2xl"
        >

        <div class="text-center mt-4">
            <a id="downloadBtn"
               download
               class="bg-white text-pink-600 px-6 py-3 rounded-xl font-medium shadow hover:scale-105 transition">
            Download Photo
            </a>
        </div>

    </div>

</div>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('downloadBtn').href = src;

    document.getElementById('imageModal')
        .classList.remove('hidden');

    document.getElementById('imageModal')
        .classList.add('flex');

    document.body.classList.add('overflow-hidden');
}

function closeModal() {
    document.getElementById('imageModal')
        .classList.add('hidden');

    document.getElementById('imageModal')
        .classList.remove('flex');

    document.body.classList.remove('overflow-hidden');
}

// Tutup modal dengan ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection