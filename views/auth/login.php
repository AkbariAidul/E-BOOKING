<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?page=dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Luminary Stays</title>
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
                    <div class="inline-block p-4 bg-sky-500/20 rounded-full mb-3">
                        <i class="fa-solid fa-hotel text-4xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Luminary Stays</h1>
                    <p class="text-white/70">Welcome back, Admin!</p>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="bg-red-500/50 border border-red-700 text-white px-4 py-3 rounded-lg relative text-center text-sm" role="alert">
                        <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])): ?>
                    <div class="bg-green-500/50 border border-green-700 text-white px-4 py-3 rounded-lg relative text-center text-sm" role="alert">
                        <span><?php echo htmlspecialchars($_GET['success']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="../../controllers/auth_controller.php?action=login" method="POST" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-white/80">Username</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa fa-user text-white/50"></i></span>
                            <input type="text" name="username" id="username" class="pl-10 block w-full bg-black/20 border border-white/20 text-white rounded-lg py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-white/80">Password</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa fa-lock text-white/50"></i></span>
                            <input type="password" name="password" id="password" class="pl-10 block w-full bg-black/20 border border-white/20 text-white rounded-lg py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg font-semibold text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-sky-500 transition-all duration-300">
                            Masuk
                        </button>
                    </div>
                </form>

                <p class="text-center text-white/60 text-sm mt-6">
                    Belum punya akun? <a href="register.php" class="font-semibold text-sky-400 hover:text-sky-300">Register di sini</a>
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