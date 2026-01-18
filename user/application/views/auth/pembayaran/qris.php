<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Scan QRIS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="user-body-default" style="background-color: #8c4141; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; font-family: 'Poppins', sans-serif;">

    <div style="background: white; border-radius: 50px; padding: 40px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" style="width: 120px; margin-bottom: 20px;">
        
        <h4 style="margin: 0; color: #555; font-weight: normal;">Scan untuk Membayar</h4>

        <div style="margin: 20px 0; position: relative;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PEMBAYARAN_KOST_<?= $pemesanan->id_pemesanan ?>" 
                 style="width: 100%; max-width: 250px; height: auto; border: 1px solid #eee; padding: 10px; border-radius: 15px;">
        </div>

        <p style="font-size: 14px; color: #777; margin-bottom: 5px;">Total Tagihan</p>
        <p style="font-size: 24px; color: #333; font-weight: 800; margin: 0 0 25px 0;">
            Rp <?= number_format($total_bayar, 0, ',', '.') ?>
        </p>

        <div style="display: flex; gap: 10px; justify-content: center; margin-bottom: 35px;">
            <div class="timer-box">
                <div class="timer-val" id="hours">23</div>
                <div class="timer-label">Jam</div>
            </div>
            <div class="timer-box">
                <div class="timer-val" id="minutes">59</div>
                <div class="timer-label">Menit</div>
            </div>
            <div class="timer-box">
                <div class="timer-val" id="seconds">59</div>
                <div class="timer-label">Detik</div>
            </div>
        </div>

        <button onclick="checkStatus(true)" style="background: white; border: 2px solid #8c4141; color: #8c4141; padding: 10px 20px; border-radius: 50px; font-weight: bold; cursor: pointer; margin-bottom: 15px; width: 80%;">
            <i class="fas fa-sync-alt"></i> Cek Status Pembayaran
        </button>

        <a href="<?= site_url('pemesanan') ?>" 
           style="background: #8c4141; color: white; padding: 12px 0; border-radius: 50px; text-decoration: none; font-weight: bold; display: block; width: 80%; margin: 0 auto; transition: 0.3s; box-shadow: 0 5px 15px rgba(140, 65, 65, 0.3);">
            Kembali
        </a>
    </div>

    <style>
        .timer-box {
            border: 1px solid #eee;
            padding: 8px;
            border-radius: 15px;
            width: 60px;
            background-color: #f9f9f9;
        }
        .timer-val {
            color: #8c4141;
            font-weight: 800;
            font-size: 18px;
        }
        .timer-label {
            font-size: 10px;
            color: #999;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var timeLimit = 2 * 60 * 60;
        function startTimer(duration, displayHours, displayMinutes, displaySeconds) {
            var timer = duration, hours, minutes, seconds;
            setInterval(function () {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                displayHours.textContent = hours;
                displayMinutes.textContent = minutes;
                displaySeconds.textContent = seconds;

                if (--timer < 0) {
                    timer = 0;
                    alert("Waktu pembayaran habis!");
                    window.location.href = "<?= site_url('pemesanan') ?>";
                }
            }, 1000);
        }
        window.onload = function () {
            var displayHours = document.querySelector('#hours');
            var displayMinutes = document.querySelector('#minutes');
            var displaySeconds = document.querySelector('#seconds');
            startTimer(timeLimit, displayHours, displayMinutes, displaySeconds);
        };
        function checkStatus(manual = false) {
            if(manual) {
                $('button i').addClass('fa-spin'); 
            }

            $.ajax({
                url: "<?= site_url('pembayaran/cek_status_pembayaran/' . $pemesanan->id_pemesanan) ?>",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.status === 'success' || data.status === 'settlement') {
                        window.location.href = "<?= site_url('pemesanan') ?>";
                    } else {
                        if(manual) {
                            alert('Pembayaran belum terdeteksi. Silakan coba sesaat lagi.');
                            $('button i').removeClass('fa-spin');
                        }
                    }
                },
                error: function() {
                    if(manual) $('button i').removeClass('fa-spin');
                }
            });
        }
        setInterval(function() {
            checkStatus(false);
        }, 5000);
    </script>

</body>
</html>