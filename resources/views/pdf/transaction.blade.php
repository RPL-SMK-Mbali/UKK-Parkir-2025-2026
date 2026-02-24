<html>
    <head>
        <style>
            @page {
                margin: 0cm 0cm;
            }

            body {
                margin-top: 0.5cm;
                margin-left: 0.5cm;
                margin-right: 0.2cm;
                margin-bottom: 0.2cm;
                font-size: 12px;
                font-family: 'Arial', sans-serif !important;
                font-weight: normal !important;
            }

            /* --- STYLE TABLE --- */
            table {
                width: 100%; /* Tabel memenuhi lebar halaman */
                border-collapse: collapse; /* Menggabungkan border agar tidak double */
                margin-top: 10px;
                margin-bottom: 10px;
            }

            th, td {
                border: 1px solid #000; /* Garis tepi hitam tipis */
                padding: 6px 8px; /* Jarak antar teks dan garis */
                font-size: 11px; /* Ukuran font sedikit lebih kecil di dalam tabel */
                vertical-align: middle; /* Teks rata tengah secara vertikal */
            }

            th {
                background-color: #f2f2f2; /* Warna background header abu-abu muda */
                font-weight: bold;
                text-align: center; /* Teks header rata tengah */
                text-transform: uppercase; /* Opsional: Membuat teks header kapital semua */
                letter-spacing: 0.5px;
            }

            td {
                text-align: left; /* Teks isi rata kiri */
            }
            
            /* Opsional: Jika ingin kolom Durasi rata tengah/kanan */
            td:last-child {
                text-align: center; 
            }
        </style>
    </head>
    <body>
       <h1 style="font-size: 16px; margin-bottom: 5px;">Transaction</h1>
       
       <table>
           <thead>
               <tr>
                   <th width="30%">Nama Area Parkir</th>
                   <th width="20%">Nomor Kendaraan</th>
                   <th width="15%">Masuk</th>
                   <th width="15%">Keluar</th>
                   <th width="20%">Durasi</th>
                   <th width="20%" style="text-align: right !important">Total</th>
               </tr>
           </thead>

           <tbody>
               @foreach ($transactions as $transaction)
                   <tr>
                       <td>{{ $transaction->parking_area->name }}</td>
                       <td style="text-align: center;">{{ $transaction->vehicle_id }}</td>
                       <td>{{ $transaction->date_in }}</td>
                       <td>{{ $transaction->date_out }}</td>
                       <td>{{ $transaction->minutes_duration }} menit</td>
                       <td style="text-align: right !important">Rp. {{ $transaction->amountAt }}</td>
                   </tr>
               @endforeach
           </tbody>
       </table>
    </body>
</html>