<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/beranda-hero.css') }}">

<section class="bh" id="beranda" aria-labelledby="bh-title">
    <svg class="bh-sprite" width="0" height="0" aria-hidden="true" focusable="false">
        <defs>
            <symbol id="bh-berry" viewBox="0 0 32 32">
                <path d="M16 29C9 25.500 5 19.500 5.500 14 5.900 10.800 8.500 9.300 11 9.700c1.700.3 3.200 1 5 1s3.300-.7 5-1c2.500-.4 5.100 1.100 5.500 4.300.5 5.500-3.500 11.500-10.500 15z"/>
                <path d="M9.500 9.500C11 6.500 14 6 16 8c2-2 5-1.500 6.500 1.500M16 8V4.500"/>
            </symbol>
        </defs>
    </svg>

    <svg class="bh-deco bh-deco-1" aria-hidden="true" focusable="false"><use href="#bh-berry"/></svg>
    <svg class="bh-deco bh-deco-2" aria-hidden="true" focusable="false"><use href="#bh-berry"/></svg>
    <svg class="bh-deco bh-deco-3" aria-hidden="true" focusable="false"><use href="#bh-berry"/></svg>
    <svg class="bh-deco bh-deco-4" aria-hidden="true" focusable="false"><use href="#bh-berry"/></svg>

    <div class="bh-inner">
        <div class="bh-text">
            <span class="bh-eyebrow">Strawberry Alfatih</span>
            <h1 id="bh-title">Manis untuk<br><em>Setiap Momen</em></h1>
            <p>Kue lezat dengan bahan pilihan dan rasa yang selalu istimewa, untuk menemani setiap momen berharga Anda.</p>
            <div class="bh-actions">
                <a class="bh-btn bh-btn-primary" href="{{ route('katalog') }}#katalog">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 8h12l-1 12H7L6 8z"/><path d="M9 8V7a3 3 0 0 1 6 0v1"/></svg>
                    Lihat Katalog
                </a>
                <a class="bh-btn bh-btn-outline" target="_blank" rel="noopener" href="{{ \App\Support\Whatsapp::url('Halo Strawberry Alfatih, saya ingin bertanya dan memesan kue.') }}">
                    <svg class="bh-wa" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M17.470 14.380c-.300-.150-1.760-.870-2.030-.970-.270-.100-.470-.150-.670.150-.200.300-.770.970-.940 1.160-.170.200-.350.220-.640.080-.300-.150-1.260-.460-2.390-1.470-.880-.790-1.480-1.760-1.650-2.060-.170-.300-.020-.460.130-.610.130-.130.300-.350.450-.520.150-.170.200-.300.300-.500.100-.200.050-.370-.020-.520-.080-.150-.670-1.610-.920-2.210-.240-.580-.490-.500-.670-.510h-.570c-.200 0-.520.080-.790.370-.270.300-1.040 1.020-1.040 2.480 0 1.460 1.070 2.880 1.210 3.070.150.200 2.100 3.200 5.080 4.490.710.310 1.260.490 1.690.630.710.230 1.360.200 1.870.120.570-.090 1.760-.720 2.010-1.410.250-.690.250-1.290.170-1.410-.070-.120-.270-.200-.570-.350zM12.050 21.790h-.01a9.870 9.870 0 0 1-5.030-1.380l-.360-.210-3.740.980 1-3.650-.240-.370a9.860 9.860 0 0 1-1.510-5.260c0-5.450 4.440-9.880 9.890-9.880 2.640 0 5.120 1.030 6.990 2.900a9.830 9.830 0 0 1 2.890 6.990c0 5.450-4.440 9.880-9.880 9.880zm8.410-18.300A11.820 11.820 0 0 0 12.050 0C5.500 0 .160 5.340.160 11.890c0 2.100.550 4.140 1.590 5.950L.060 24l6.310-1.650a11.880 11.880 0 0 0 5.680 1.450h.010c6.550 0 11.890-5.340 11.890-11.890a11.820 11.820 0 0 0-3.490-8.420z"/></svg>
                    Pesan via WhatsApp
                </a>
            </div>
        </div>

        <div class="bh-photo">
            <img src="{{ asset('assets/img/hero.jpg') }}" alt="Kue strawberry dengan topping stroberi segar dan pita merah" width="1619" height="971" fetchpriority="high">
        </div>
    </div>
</section>