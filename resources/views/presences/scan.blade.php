@extends('layouts.app')
@section('title', 'Scan QR Absensi')
@section('content')
<div class="relative min-h-[80vh] flex flex-col items-center justify-center">
    <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-emerald-300/40 blur-3xl"></div>
        <div class="absolute -right-10 top-10 h-80 w-80 rounded-full bg-blue-300/30 blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-lg">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Scanner Absensi</h1>
            <p class="text-slate-500 mt-2">Tunjukkan QR Code karyawan ke kamera</p>
        </div>

        <div class="bg-white p-4 rounded-3xl shadow-2xl ring-1 ring-slate-200 overflow-hidden">
            <div id="reader" class="rounded-2xl overflow-hidden bg-slate-100 aspect-square"></div>
        </div>

        <div id="result-container" class="mt-6 hidden animate-bounce">
            <div id="result-card" class="p-6 rounded-2xl text-center shadow-xl">
                <div id="result-icon" class="mb-3 flex justify-center text-4xl"></div>
                <h3 id="result-name" class="text-xl font-bold"></h3>
                <p id="result-msg" class="text-sm mt-1"></p>
                <p id="result-time" class="text-xs mt-2 font-mono opacity-70"></p>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4">
            <a href="{{ route('presences.calendar') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200 transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.location.reload()" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                <i class="fa-solid fa-sync"></i> Refresh Kamera
            </button>
        </div>
    </div>
</div>

{{-- Audio Feedback --}}
<audio id="beepSuccess" src="https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3" preload="auto"></audio>
<audio id="beepError" src="https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3" preload="auto"></audio>

@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const resultContainer = document.getElementById('result-container');
    const resultCard = document.getElementById('result-card');
    const resultIcon = document.getElementById('result-icon');
    const resultName = document.getElementById('result-name');
    const resultMsg = document.getElementById('result-msg');
    const resultTime = document.getElementById('result-time');
    
    const beepSuccess = document.getElementById('beepSuccess');
    const beepError = document.getElementById('beepError');

    let isScanning = true;

    function onScanSuccess(decodedText, decodedResult) {
        if (!isScanning) return;
        
        isScanning = false;
        console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Kirim ke server
        fetch("{{ route('presences.scanStore') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: decodedText })
        })
        .then(response => response.json())
        .then(data => {
            showResult(data);
            if (data.success) {
                beepSuccess.play().catch(e => console.log('Audio play failed', e));
            } else {
                beepError.play().catch(e => console.log('Audio play failed', e));
            }
            
            // Tunggu 3 detik sebelum scan lagi
            setTimeout(() => {
                resultContainer.classList.add('hidden');
                isScanning = true;
            }, 4000);
        })
        .catch(error => {
            console.error('Error:', error);
            showResult({ success: false, message: 'Terjadi kesalahan sistem.' });
            beepError.play().catch(e => console.log('Audio play failed', e));
            setTimeout(() => {
                resultContainer.classList.add('hidden');
                isScanning = true;
            }, 4000);
        });
    }

    function showResult(data) {
        resultContainer.classList.remove('hidden');
        
        if (data.success) {
            if (data.already) {
                resultCard.className = 'p-6 rounded-2xl text-center shadow-xl bg-amber-50 text-amber-700 ring-1 ring-amber-200';
                resultIcon.innerHTML = '⚠️';
            } else {
                resultCard.className = 'p-6 rounded-2xl text-center shadow-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200';
                resultIcon.innerHTML = '✅';
            }
            resultName.innerText = data.employee ? data.employee.nama : 'Berhasil';
            resultMsg.innerText = data.message;
            resultTime.innerText = data.time || '';
        } else {
            resultCard.className = 'p-6 rounded-2xl text-center shadow-xl bg-rose-50 text-rose-700 ring-1 ring-rose-200';
            resultIcon.innerHTML = '❌';
            resultName.innerText = 'Gagal';
            resultMsg.innerText = data.message;
            resultTime.innerText = '';
        }
    }

    function onScanFailure(error) {
        // console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { 
            fps: 10, 
            qrbox: {width: 250, height: 250},
            aspectRatio: 1.0
        },
        /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush
