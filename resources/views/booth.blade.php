@extends('layouts.app')

@section('title', 'Booth')

@section('content')

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<div class="max-w-4xl mx-auto text-center px-4 pt-12">

  <h2 class="text-3xl font-bold mb-6">📸 Photo Booth</h2>

<!-- Controls -->
<div class="flex flex-wrap justify-center gap-4 mb-8">

  <!-- FILTER -->
  <select id="filter"
    class="bg-white/20 backdrop-blur-md border border-white/20 
           text-white px-4 py-2 rounded-xl">

    <option value="none" class="text-black">Normal</option>

    <option value="grayscale(100%)" class="text-black">
      Grayscale
    </option>

    <option value="sepia(80%)" class="text-black">
      Vintage
    </option>

    <option value="brightness(1.2) contrast(1.2)" class="text-black">
      Bright
    </option>

    <option value="hue-rotate(200deg)" class="text-black">
      Cool Blue
    </option>

    <option value="contrast(1.4) saturate(1.3)" class="text-black">
      Cinematic
    </option>

    <option value="saturate(1.8) brightness(1.1)" class="text-black">
      Vibrant
    </option>

    <option value="blur(1px) brightness(1.1)" class="text-black">
      Soft Glow
    </option>

    <option value="invert(1)" class="text-black">
      Invert
    </option>

    <option value="hue-rotate(320deg) saturate(1.5)" class="text-black">
      Dreamy Pink
    </option>

  </select>

  <!-- FRAME -->
  <select id="frame"
    class="bg-white/20 backdrop-blur-md border border-white/20 
           text-white px-4 py-2 rounded-xl">

    <option value="frame-white" class="text-black">White</option>
    <option value="frame-pink" class="text-black">Pink</option>
    <option value="frame-black" class="text-black">Black</option>
    <option value="frame-cute" class="text-black">Cute</option>
    <option value="frame-purple" class="text-black">Purple</option>
    <option value="frame-sunset" class="text-black">Sunset</option>

  </select>

  <!-- PHOTO COUNT -->
  <select id="photoCount"
    class="bg-white/20 backdrop-blur-md border border-white/20 
           text-white px-4 py-2 rounded-xl">

    <option value="2" class="text-black">2 Photos</option>
    <option value="4" class="text-black" selected>4 Photos</option>
    <option value="6" class="text-black">6 Photos</option>
    <option value="8" class="text-black">8 Photos</option>

  </select>

</div>

  <!-- Camera -->
  <div class="flex flex-col items-center">
    <video id="video" autoplay playsinline class="rounded-2xl shadow-lg w-full max-w-md"></video>

    <div class="mt-4 flex gap-4">
      <button onclick="startCamera()" class="bg-white text-pink-600 px-6 py-3 rounded-xl font-medium shadow hover:scale-105 transition">
        Start Camera
      </button>

      <button onclick="startStrip()" class="bg-white text-pink-600 px-6 py-3 rounded-xl font-medium shadow hover:scale-105 transition">
        Take Photo
      </button>
    </div>
  </div>

  <!-- Result -->
  <div class="mt-10">
    <h3 class="text-xl mb-4">Results</h3>
    <div id="gallery" class="flex flex-wrap justify-center gap-6"></div>
  </div>

</div>

<canvas id="canvas" class="hidden"></canvas>

<style>
  .strip {
    width: 240px;
    padding: 14px;
  }
  
  .strip img {
    width: 100%;
    display: block;
  }
  
  /* Frames */
  .frame-white {
    background: white;
  }
  
  .frame-pink {
    background: #ffe4ec;
  }
  
  .frame-black {
    background: #111827;
    color: white;
  }
  
  .frame-cute {
    background: linear-gradient(
      135deg,
      #ffd6ec,
      #e0c3fc
    );
  }
  
  .frame-purple {
    background: linear-gradient(
      135deg,
      #c084fc,
      #8b5cf6
    );
    color: white;
  }
  
  .frame-sunset {
    background: linear-gradient(
      135deg,
      #ff9a9e,
      #fad0c4,
      #fbc2eb
    );
  }
  
  /* Watermark */
  .watermark {
    font-size: 12px;
    text-align: center;
    margin-top: 5px;
  }
  </style>

<div id="flash"
     class="fixed inset-0 bg-white opacity-0 pointer-events-none z-[9999]">
</div>

<audio id="shutterSound">
  <source src="https://assets.mixkit.co/active_storage/sfx/2955/2955-preview.mp3" type="audio/mpeg">
</audio>

<div id="previewArea"
     class="grid grid-cols-4 gap-2 mt-6 max-w-xs mx-auto">
</div>

<div id="actionButtons"
     class="hidden flex justify-center gap-4 mt-6">

    <button
      onclick="generateSelectedStrip()"
      class="bg-white text-pink-600 px-6 py-3 rounded-xl font-medium shadow hover:scale-105 transition">
      Create Strip
    </button>

    <button
      onclick="retake()"
      class="bg-white text-pink-600 px-6 py-3 rounded-xl font-medium shadow hover:scale-105 transition">
      Retake
    </button>

</div>

<script>
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const gallery = document.getElementById('gallery');
const filterSelect = document.getElementById('filter');
const frameSelect = document.getElementById('frame');

let shots = [];

// filter preview
filterSelect.addEventListener('change', () => {
  video.style.filter = filterSelect.value;
});

// start camera
async function startCamera() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    video.srcObject = stream;
  } catch (err) {
    alert('Camera tidak bisa diakses');
  }
}
// ambil foto sesuai pilihan
async function startStrip() {

shots = [];

document.getElementById('previewArea').innerHTML = '';

const total = parseInt(
    document.getElementById('photoCount').value
);

for (let i = 0; i < total; i++) {

    await countdown(3);

    await takeShot();
}

showPreview();
}

// countdown
function countdown(sec) {
  return new Promise(resolve => {
    const el = document.createElement('div');
    el.className = "fixed inset-0 flex items-center justify-center text-6xl bg-black/70";
    document.body.appendChild(el);

    let c = sec;
    el.innerText = c;

    const int = setInterval(() => {
      c--;
      if (c === 0) {
        clearInterval(int);
        el.innerText = "";
        setTimeout(() => {
          el.remove();
          resolve();
        }, 500);
      } else {
        el.innerText = c;
      }
    }, 1000);
  });
}

function flashEffect() {
    return new Promise(resolve => {

        const flash = document.getElementById('flash');

        flash.classList.remove('opacity-0');
        flash.classList.add('opacity-100');

        setTimeout(() => {
            flash.classList.remove('opacity-100');
            flash.classList.add('opacity-0');

            resolve();
        }, 300);

    });
}

async function takeShot() {

document.getElementById('shutterSound').play();

await flashEffect();

const ctx = canvas.getContext('2d');

canvas.width = video.videoWidth;
canvas.height = video.videoHeight;

ctx.filter = filterSelect.value;
ctx.drawImage(video, 0, 0);

const imageData = canvas.toDataURL('image/png');

shots.push(imageData);
}

function takeShot() {
  flashEffect();

  const ctx = canvas.getContext('2d');

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  ctx.filter = filterSelect.value;
  ctx.drawImage(video, 0, 0);

  const imageData = canvas.toDataURL('image/png');
  shots.push(imageData);
}

function showPreview() {
    const preview = document.getElementById('previewArea');
    const actionButtons = document.getElementById('actionButtons');

    preview.innerHTML = '';

    shots.forEach((src, index) => {
        preview.innerHTML += `
            <div class="relative">
                <img
                    src="${src}"
                    class="rounded-xl w-20 h-20 object-cover border-2 border-white"
                >

                <input
                    type="checkbox"
                    checked
                    value="${index}"
                    class="absolute top-1 right-1 w-4 h-4"
                >
            </div>
        `;
    });

    actionButtons.classList.remove('hidden');
}

function generateSelectedStrip() {

const selected = [];

document.querySelectorAll('#previewArea input:checked')
    .forEach(cb => {
        selected.push(shots[cb.value]);
    });

if (selected.length === 0) {
    alert('Pilih minimal 1 foto');
    return;
}

shots = selected;

createStrip();

// reset preview
document.getElementById('previewArea').innerHTML = '';
document.getElementById('actionButtons').classList.add('hidden');
}

function retake() {
    shots = [];

    document.getElementById('previewArea').innerHTML = '';

    document.getElementById('actionButtons')
        .classList.add('hidden');
}

// buat strip + SAVE ke Laravel
function createStrip() {
  const wrap = document.createElement('div');
  wrap.className = "relative";

  const strip = document.createElement('div');
  strip.className = `
  strip flex flex-col gap-3 items-center
  shadow-2xl
  ${frameSelect.value}
`;

  shots.forEach(src => {
    const img = document.createElement('img');
    img.src = src;
    img.className = "rounded-lg";
    strip.appendChild(img);
  });

  const wm = document.createElement('div');
  wm.innerText = "Cutieshoot <3\n" + new Date().toLocaleDateString();
  wm.className = "watermark";
  strip.appendChild(wm);

  const del = document.createElement('button');
  del.innerText = "✕";
  del.className = "absolute top-2 right-2 bg-red-500 w-6 h-6 rounded-full";

  del.onclick = () => wrap.remove();

  wrap.appendChild(strip);
  wrap.appendChild(del);
  gallery.appendChild(wrap);
  shots = [];

  // 🔥 SAVE STRIP (INI KUNCI)
  html2canvas(strip).then(canvas => {
    const imageData = canvas.toDataURL('image/png');

    fetch('/save-photo', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        image: imageData,
        filter: filterSelect.value,
        frame: frameSelect.value
      })
    });
  });
}
</script>

@endsection