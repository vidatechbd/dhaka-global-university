@php
    $uniName    = $setting->name    ?? 'Bayt al-Hikmah Global University';
    $uniAddress = $setting->address ?? 'Purbachal Model Town, Dhaka, Bangladesh';
    $logoPath   = ($setting->logo ?? null) ? asset($setting->logo) : null;
    $layout     = auth()->check() ? (auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout') : null;
@endphp

@if($layout)
<x-dynamic-component :component="$layout">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* MAIN CONTAINERS & DIMENSIONS (11.69in x 8.27in A4 landscape) */
        .certificate-paper-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        .certificate-paper {
            background-color: #fbf8eb;
            width: 11.69in;
            height: 8.27in;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            box-sizing: border-box;
        }

        .certificate-content-border {
            border: 1.5px solid #222;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-sizing: border-box;
        }

        .repeating-university-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            color: rgba(180, 160, 110, 0.15);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5px;
            font-weight: bold;
            line-height: 1.5;
            text-align: justify;
            overflow: hidden;
            pointer-events: none;
            padding: 8px;
            box-sizing: border-box;
        }

        .watermark-seal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 4px solid rgba(180, 160, 110, 0.3);
            z-index: 2;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(251, 248, 235, 0.65); 
        }

        .watermark-seal::before {
            content: '';
            position: absolute;
            width: 290px;
            height: 290px;
            border-radius: 50%;
            border: 1px solid rgba(180, 160, 110, 0.15);
        }

        .watermark-seal::after {
            content: 'SEAL';
            font-family: 'Cinzel', serif;
            font-size: 55px;
            color: rgba(180, 160, 110, 0.08);
            font-weight: bold;
            letter-spacing: 10px;
        }

        .text-university-name {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            font-weight: 900;
            color: #000;
            letter-spacing: -0.5px;
            transform: scaleY(1.05); 
            display: inline-block;
        }

        .text-old-english {
            font-family: 'UnifrakturMaguntia', serif;
            font-weight: normal;
            color: #000;
        }

        .text-engravers {
            font-family: 'Copperplate', 'Copperplate Gothic Bold', 'Copperplate Gothic Light', 'Cinzel', serif;
            font-weight: 800;
            color: #111;
            letter-spacing: 0.08em;
            word-spacing: 0.25em;
        }

        .text-sans-small {
            font-family: Arial, Helvetica, sans-serif;
        }

        .fill-in-line {
            display: inline-block;
            border-bottom: 2px solid #000;
            padding: 0 6px;
            font-weight: 900;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            padding: 30px 45px 15px 45px;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
            justify-content: space-between;
        }

        @media print {
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            body * { visibility: hidden; }
            #sidebar, header, .no-print, nav, aside { display: none !important; }
            #printable-certificate-container,
            #printable-certificate-container * { visibility: visible !important; }
            #printable-certificate-container {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                width: 11.69in !important;
                height: 8.27in !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .certificate-paper {
                box-shadow: none !important;
                width: 11.69in !important;
                height: 8.27in !important;
                margin: 0 !important;
            }
            @page { size: A4 landscape; margin: 0; }
        }
    </style>

    <div class="py-6 max-w-7xl mx-auto w-full">
        <div class="flex items-center justify-between mb-6 no-print">
            <a href="{{ route('certificates.index') }}" class="text-sm font-bold text-textclr-200 hover:text-textclr-100 flex items-center gap-1">
                &larr; Back to Certificates
            </a>
            <button onclick="window.print()" class="bg-primary-300 hover:bg-primary-300/90 text-white px-5 py-2 rounded-lg font-bold transition flex items-center gap-2 shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print / Save as PDF
            </button>
        </div>

        <div id="printable-certificate-container" class="certificate-paper-wrapper">
            <div class="certificate-paper">
                <div class="certificate-content-border">
                    <div class="repeating-university-bg" id="bg-text"></div>
                    <div class="watermark-seal"></div>

                    <div class="content-wrapper">
                        <!-- Main University Name -->
                        <header class="text-center mt-2 mb-6">
                            <h1 class="text-university-name text-[32px] sm:text-[40px] md:text-[46px] m-0 leading-none uppercase">
                                {{ $uniName }}
                            </h1>
                        </header>

                        <!-- Certification Text -->
                        <div class="text-center mb-4">
                            <p class="text-old-english text-[20px] md:text-[24px] m-0 tracking-wider">
                                This is to certify that
                            </p>
                        </div>

                        <!-- Student Name -->
                        <div class="text-center mb-6">
                            <h2 class="text-engravers text-[26px] md:text-[36px] m-0 uppercase font-black">
                                {{ $certificate->name }}
                            </h2>
                        </div>

                        <!-- Certificate Body Text -->
                        <div class="text-justify px-6 md:px-14 mb-auto">
                            <p class="text-engravers text-[14px] md:text-[18px] leading-[2.3] m-0 uppercase">
                                HAS FULFILLED ALL REQUIREMENTS FOR THE DEGREE 
                                OF {{ strtoupper($certificate->subject) }}. BEARING ROLL NO IS <span class="fill-in-line">{{ $certificate->roll }}</span> . HE SECURED 
                                CGPA <span class="fill-in-line">{{ $certificate->cgpa }}</span> IN ON SCALE OF <span class="fill-in-line">{{ $certificate->out_of }}</span> .
                            </p>
                        </div>

                        <!-- Footer Section -->
                        <div class="mt-4 flex flex-col justify-end">
                            
                            <!-- Middle Footer row -->
                            <div class="flex justify-between items-end px-4 md:px-12 mb-3">
                                
                                <!-- Left: QR Code -->
                                <div class="w-20 h-20 bg-white border border-black p-1">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('certificates.verify', $certificate)) }}" alt="QR Code" class="w-full h-full">
                                </div>

                                <!-- Right: Signature -->
                                <div class="flex flex-col items-center mr-4">
                                    <div class="h-10 w-44 mb-1 flex items-end justify-center">
                                        <svg viewBox="0 0 200 50" class="w-full h-full" stroke="black" stroke-width="2" fill="none">
                                            <path d="M 20,40 Q 40,-10 60,35 T 90,20 T 120,35 Q 150,15 180,30" />
                                        </svg>
                                    </div>
                                    <div class="border-t-[1.5px] border-black w-56 text-center pt-1">
                                        <p class="text-sans-small text-[9px] font-bold uppercase tracking-wider m-0">
                                            Controller of Examinations
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom N.B. Note -->
                            <div class="border-t-[1px] border-[rgba(0,0,0,0.2)] pt-1.5 ml-4">
                                <p class="text-sans-small text-[8px] md:text-[9px] text-black font-bold uppercase tracking-widest m-0">
                                    N.B : Original certificate will be issued on return of this provisional certificate
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bgContainer = document.getElementById('bg-text');
            const uniName = @json($uniName);
            bgContainer.innerText = (uniName + " ").repeat(1000);
        });
    </script>
</x-dynamic-component>
@else
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Certificate - {{ $certificate->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        .certificate-paper-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        .certificate-paper {
            background-color: #fbf8eb;
            width: 11.69in;
            height: 8.27in;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            box-sizing: border-box;
        }

        .certificate-content-border {
            border: 1.5px solid #222;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-sizing: border-box;
        }

        .repeating-university-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            color: rgba(180, 160, 110, 0.15);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5px;
            font-weight: bold;
            line-height: 1.5;
            text-align: justify;
            overflow: hidden;
            pointer-events: none;
            padding: 8px;
            box-sizing: border-box;
        }

        .watermark-seal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 4px solid rgba(180, 160, 110, 0.3);
            z-index: 2;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(251, 248, 235, 0.65); 
        }

        .watermark-seal::before {
            content: '';
            position: absolute;
            width: 290px;
            height: 290px;
            border-radius: 50%;
            border: 1px solid rgba(180, 160, 110, 0.15);
        }

        .watermark-seal::after {
            content: 'SEAL';
            font-family: 'Cinzel', serif;
            font-size: 55px;
            color: rgba(180, 160, 110, 0.08);
            font-weight: bold;
            letter-spacing: 10px;
        }

        .text-university-name {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            font-weight: 900;
            color: #000;
            letter-spacing: -0.5px;
            transform: scaleY(1.05); 
            display: inline-block;
        }

        .text-old-english {
            font-family: 'UnifrakturMaguntia', serif;
            font-weight: normal;
            color: #000;
        }

        .text-engravers {
            font-family: 'Copperplate', 'Copperplate Gothic Bold', 'Copperplate Gothic Light', 'Cinzel', serif;
            font-weight: 800;
            color: #111;
            letter-spacing: 0.08em;
            word-spacing: 0.25em;
        }

        .text-sans-small {
            font-family: Arial, Helvetica, sans-serif;
        }

        .fill-in-line {
            display: inline-block;
            border-bottom: 2px solid #000;
            padding: 0 6px;
            font-weight: 900;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            padding: 30px 45px 15px 45px;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
            justify-content: space-between;
        }
    </style>
</head>
<body class="bg-[#F0E8EE] font-sans min-h-screen flex flex-col items-center justify-center p-6 text-[#4C4C4C]">
    
    <!-- Verification Status Banner -->
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-full px-5 py-2 flex items-center gap-2 font-bold text-sm shadow-sm">
        <span class="text-lg">✓</span> Verified Academic Certificate
    </div>

    <div class="certificate-paper-wrapper">
        <div class="certificate-paper shadow-2xl">
            <div class="certificate-content-border">
                <div class="repeating-university-bg" id="bg-text"></div>
                <div class="watermark-seal"></div>

                <div class="content-wrapper">
                    <!-- Main University Name -->
                    <header class="text-center mt-2 mb-6">
                        <h1 class="text-university-name text-[32px] sm:text-[40px] md:text-[46px] m-0 leading-none uppercase">
                            {{ $uniName }}
                        </h1>
                    </header>

                    <!-- Certification Text -->
                    <div class="text-center mb-4">
                        <p class="text-old-english text-[20px] md:text-[24px] m-0 tracking-wider">
                            This is to certify that
                        </p>
                    </div>

                    <!-- Student Name -->
                    <div class="text-center mb-6">
                        <h2 class="text-engravers text-[26px] md:text-[36px] m-0 uppercase font-black">
                            {{ $certificate->name }}
                        </h2>
                    </div>

                    <!-- Certificate Body Text -->
                    <div class="text-justify px-6 md:px-14 mb-auto">
                        <p class="text-engravers text-[14px] md:text-[18px] leading-[2.3] m-0 uppercase">
                            HAS FULFILLED ALL REQUIREMENTS FOR THE DEGREE 
                            OF {{ strtoupper($certificate->subject) }}. BEARING ROLL NO IS <span class="fill-in-line">{{ $certificate->roll }}</span> . HE SECURED 
                            CGPA <span class="fill-in-line">{{ $certificate->cgpa }}</span> IN ON SCALE OF <span class="fill-in-line">{{ $certificate->out_of }}</span> .
                        </p>
                    </div>

                    <!-- Footer Section -->
                    <div class="mt-4 flex flex-col justify-end">
                        
                        <!-- Middle Footer row -->
                        <div class="flex justify-between items-end px-4 md:px-12 mb-3">
                            
                            <!-- Left: QR Code -->
                            <div class="w-20 h-20 bg-white border border-black p-1">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('certificates.verify', $certificate)) }}" alt="QR Code" class="w-full h-full">
                            </div>

                            <!-- Right: Signature -->
                            <div class="flex flex-col items-center mr-4">
                                <div class="h-10 w-44 mb-1 flex items-end justify-center">
                                    <svg viewBox="0 0 200 50" class="w-full h-full" stroke="black" stroke-width="2" fill="none">
                                        <path d="M 20,40 Q 40,-10 60,35 T 90,20 T 120,35 Q 150,15 180,30" />
                                    </svg>
                                </div>
                                <div class="border-t-[1.5px] border-black w-56 text-center pt-1">
                                    <p class="text-sans-small text-[9px] font-bold uppercase tracking-wider m-0">
                                        Controller of Examinations
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom N.B. Note -->
                        <div class="border-t-[1px] border-[rgba(0,0,0,0.2)] pt-1.5 ml-4">
                            <p class="text-sans-small text-[8px] md:text-[9px] text-black font-bold uppercase tracking-widest m-0">
                                N.B : Original certificate will be issued on return of this provisional certificate
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bgContainer = document.getElementById('bg-text');
            const uniName = @json($uniName);
            bgContainer.innerText = (uniName + " ").repeat(1000);
        });
    </script>
</body>
</html>
@endif
