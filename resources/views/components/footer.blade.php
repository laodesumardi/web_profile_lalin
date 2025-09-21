<!-- Footer Component -->
<footer class="bg-primary text-white py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Brand Section -->
            <div class="md:col-span-2">
                <h3 class="text-2xl font-bold mb-4">BPTD</h3>
                <p class="text-blue-200 mb-4 leading-relaxed">
                    Balai Pengelolaan Transportasi Darat yang berkomitmen melayani masyarakat dengan profesional dan mengembangkan sistem transportasi yang aman, nyaman, dan berkelanjutan.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150" aria-label="Facebook">
                        <i class="fab fa-facebook-f text-base"></i>
                    </a>
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150" aria-label="Twitter">
                        <i class="fab fa-twitter text-base"></i>
                    </a>
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150" aria-label="Instagram">
                        <i class="fab fa-instagram text-base"></i>
                    </a>
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in text-base"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Menu Utama</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition duration-150 flex items-center">
                            <i class="fas fa-home mr-2 text-sm"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}" class="text-blue-200 hover:text-white transition duration-150 flex items-center">
                            <i class="fas fa-newspaper mr-2 text-sm"></i>Berita
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employees.index') }}" class="text-blue-200 hover:text-white transition duration-150 flex items-center">
                            <i class="fas fa-users mr-2 text-sm"></i>Pegawai
                        </a>
                    </li>
                    @guest
                        <li>
                            <a href="{{ route('register') }}" class="text-blue-200 hover:text-white transition duration-150 flex items-center">
                                <i class="fas fa-user-plus mr-2 text-sm"></i>Bergabung
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
                <div class="space-y-3 text-blue-200">
                    <div class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-3 text-sm"></i>
                        <div>
                            <p class="font-medium">Email</p>
                            <a href="mailto:info@bptd.go.id" class="hover:text-white transition duration-150">info@bptd.go.id</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-phone mt-1 mr-3 text-sm"></i>
                        <div>
                            <p class="font-medium">Telepon</p>
                            <a href="tel:+622112345678" class="hover:text-white transition duration-150">(021) 1234-5678</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-sm"></i>
                        <div>
                            <p class="font-medium">Alamat</p>
                            <p>Kementrian perhubungan darat, BPTD kelas II maluku</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-blue-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <p class="text-blue-200">
                        &copy; {{ date('Y') }} BPTD - Balai Pengelolaan Transportasi Darat.
                        <span class="hidden sm:inline">Semua hak dilindungi undang-undang.</span>
                    </p>
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150">Kebijakan Privasi</a>
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150">Syarat & Ketentuan</a>
                    <a href="#" class="text-blue-200 hover:text-white transition duration-150">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>