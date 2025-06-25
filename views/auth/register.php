<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Luminary Stays</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900">

    <div id="particles-js"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4 z-10">
        <div class="w-full max-w-md">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 space-y-6 border border-white/20">
                
                <div class="text-center mb-4">
                    <h1 class="text-3xl font-bold text-white">Buat Akun Admin</h1>
                    <p class="text-white/70">Isi form di bawah untuk mendaftar</p>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="bg-red-500/50 border border-red-700 text-white px-4 py-3 rounded-lg relative text-center text-sm" role="alert">
                        <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="../../controllers/auth_controller.php?action=register" method="POST" class="space-y-4">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-white/80">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="mt-1 block w-full bg-black/20 border border-white/20 text-white rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-white/80">Username</label>
                        <input type="text" name="username" id="username" class="mt-1 block w-full bg-black/20 border border-white/20 text-white rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-white/80">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full bg-black/20 border border-white/20 text-white rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                    </div>
                    <div>
                        <label for="konfirmasi_password" class="block text-sm font-medium text-white/80">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="mt-1 block w-full bg-black/20 border border-white/20 text-white rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg font-semibold text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-sky-500 transition-all duration-300">
                            Register
                        </button>
                    </div>
                </form>

                <p class="text-center text-white/60 text-sm mt-6">
                    Sudah punya akun? <a href="login.php" class="font-semibold text-sky-400 hover:text-sky-300">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 250, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#ffffff" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.8, "random": true, "anim": { "enable": true, "speed": 1, "opacity_min": 0.1, "sync": false } },
                "size": { "value": 3, "random": true, "anim": { "enable": false, "speed": 4, "size_min": 0.3, "sync": false } },
                "line_linked": { "enable": false },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "bottom",
                    "random": true,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": { "enable": false, "rotateX": 600, "rotateY": 1200 }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": { "onhover": { "enable": false }, "onclick": { "enable": false }, "resize": true }
            },
            "retina_detect": true
        });
    </script>
</body>
</html>