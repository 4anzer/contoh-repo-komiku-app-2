-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Des 2025 pada 07.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `komiku_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comic_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `comic_id`, `created_at`) VALUES
(6, 12, 2, '2025-12-11 05:26:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `comic_id` int(11) DEFAULT NULL,
  `chapter_number` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chapters`
--

INSERT INTO `chapters` (`id`, `comic_id`, `chapter_number`, `title`, `created_at`) VALUES
(1, 2, 'Chapter 1', 'Beginning and Ending', '2025-12-08 15:56:09'),
(2, 3, 'Chapter 1', 'Ajojing', '2025-12-08 16:07:31'),
(3, 3, 'Chapter 2', 'What the dog doin', '2025-12-08 16:08:33'),
(4, 4, 'Chapter 2', 'The Ending', '2025-12-11 05:10:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comics`
--

CREATE TABLE `comics` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `status` enum('ongoing','completed') DEFAULT 'ongoing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comics`
--

INSERT INTO `comics` (`id`, `title`, `synopsis`, `cover`, `status`, `created_at`) VALUES
(2, 'Solo Leveling', 'Manhwa Solo Leveling yang dibuat oleh komikus bernama Chugong 추공 ini bercerita tentang 10 tahun yang lalu, setelah “Gerbang” yang menghubungkan dunia nyata dengan dunia monster terbuka, beberapa orang biasa, setiap hari menerima kekuatan untuk berburu monster di dalam Gerbang. Mereka dikenal sebagai “Pemburu”. Namun, tidak semua Pemburu kuat. Nama saya Sung Jin-Woo, seorang Pemburu peringkat-E. Saya seseorang yang harus mempertaruhkan nyawanya di ruang bawah tanah paling rendah, “Terlemah di Dunia”. Tidak memiliki keterampilan apa pun untuk ditampilkan, saya hampir tidak mendapatkan uang yang dibutuhkan dengan bertarung di ruang bawah tanah berlevel rendah… setidaknya sampai saya menemukan ruang bawah tanah tersembunyi dengan kesulitan tersulit dalam ruang bawah tanah peringkat-D! Pada akhirnya, saat aku menerima kematian, tiba-tiba aku menerima kekuatan aneh, log pencarian yang hanya bisa kulihat, rahasia untuk naik level yang hanya aku yang tahu! Jika saya berlatih sesuai dengan pencarian saya dan monster yang diburu, level saya akan naik. Berubah dari Hunter terlemah menjadi Hunter S-rank terkuat!', 'uploads/covers/1765207520875.jpg', 'completed', '2025-12-08 15:25:20'),
(3, 'Magic Emperor', '“Zhuo Yifan adalah seorang kaisar sihir atau bisa di panggil kaisar iblis, karena dia mempunyai buku kaisar kuno yang di sebut buku sembilan rahasia dia menjadi sasaran semua ahli beradiri bahkan dia di khianati dan di bunuh oleh muridnya. Kemudian jiwanya masuk dan hidup kembali dalam seorang anak pelayan keluarga bernama Zhuo Fan.Karena suatu sihir iblis mengekangnya, dia harus menyatukan ingatan anak itu dan tidak bisa mengabaikan keluarga dan nona yang dia layaninya. Bagaimana kehidupan nya membangun kembali keluarganya dan kembali menjadi yang terkuat didaratan benua…”', 'uploads/covers/1765209670996.gif', 'ongoing', '2025-12-08 16:01:10'),
(4, 'Return of the Mad Demon', 'Pria yang tergila-gila pada seni beladiri, Lee JaHa sang Mad Demon. Dia kembali ke masa dirinya masih orang normal yang belum menjadi gila. Lee JaHa dikenal sebagai Mad Demon, dirinya mencuri Heavenly Jade—harta pemimpin Kultus Demonic—alasannya sederhana, karena tidak menyukai si pemimpin. Setelah pengejaran tiada henti dari kultus demonic, Lee JaHa menemui jalan buntu dan tidak bisa kabur lagi setelah pengejaran berhari-hari sambil mengalahkan banyak elite Kultus Demonic. Demi menghina usaha para pengejar dan pemimpin kultus, dia menelan Heavenly Jade sebelum sekarat dan terjatuh dari tebing setelah pertempuran yang hebat. Ketika dirinya membuka mata, dia kembali ke waktu masih berada di penginapan Gyedu, pada masa dirinya masih dipandang rendah oleh semua orang. Dengan kembali ke masa lalu, dalam pikirannya bukan mempertanyakan situasi, melainkan satu hal. ‘aku bisa bertambah kuat!’ karena ini jalan yang sudah pernah dilaluinya, dan fakta kalau dia sangat memahami seni beladiri, dia sadar bisa menjadi lebih kuat ketimbang dirinya yang Mad Demon. Daripada memahami situasinya saat ini, JaHa memeriksa tubuhnya dan mulai menggunakan teknik kultivasi pernafasan. Baru setelah selesai, dia meluruskan situasinya dan menyadari bahwa, dirinya dipukuli karena tuduhan palsu dan penginapannya diporak-porandakan. Bukan seorang pembantu penginapan yang dipandang rendah, sekarang dirinya itu Mad Demon dari Dunia Martial yang angkuh. apa yang akan dilakukannya mulai sekarang?!', 'uploads/covers/1765212326570.webp', 'ongoing', '2025-12-08 16:45:26'),
(5, 'Player Who Returned 10,000 Years Later', 'Dari Studio yang sama Dengan Suatu Hari Ia Mendapati Dirinya Terjebak di dalam Neraka. Namun, Dia memiliki Tekad yang kuat Dan Kekuatan yang Kuat pula. Setelah 9999 tahun Berlalu, Ia telah Menyerap Jutaan Demon Dalam Dirinya dan Menjadi Penguasa neraka. Mengalahkan Para Monarch yang ada Di nereka. [ Kenapa Anda ingin Kembali Yang mulia? bukankah anda sudah punya Segalanya di sini?] Ucap Salah satu Monarch [ Apa yang aku punya di sini? Tidak ada yang bisa dimakan, tidak ada yang bisa dinikmati, Sudah Kuputuskan] [ Aku akan Kembali, Ke bumi.]', 'uploads/covers/1765433830374.jpg', 'completed', '2025-12-11 06:17:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comic_genres`
--

CREATE TABLE `comic_genres` (
  `comic_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comic_genres`
--

INSERT INTO `comic_genres` (`comic_id`, `genre_id`) VALUES
(2, 3),
(3, 1),
(3, 2),
(4, 1),
(5, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(4, 'Comedy'),
(3, 'Romance');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pages`
--

INSERT INTO `pages` (`id`, `chapter_id`, `order`, `file`) VALUES
(1, 1, 1, 'uploads/pages/1765209369391_0.jpeg'),
(2, 2, 1, 'uploads/pages/1765210051585_0.gif'),
(3, 3, 1, 'uploads/pages/1765210113514_0.gif'),
(4, 4, 1, 'uploads/pages/1765429825650_0.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comic_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `comic_id`, `rating`, `created_at`) VALUES
(1, 12, 3, 5, '2025-12-11 05:44:26'),
(2, 12, 4, 5, '2025-12-11 05:47:46'),
(3, 11, 4, 4, '2025-12-11 05:48:27'),
(5, 11, 3, 1, '2025-12-11 05:48:40'),
(6, 11, 2, 1, '2025-12-11 05:48:47'),
(7, 12, 5, 5, '2025-12-11 06:27:20'),
(8, 11, 5, 1, '2025-12-11 06:27:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reading_history`
--

CREATE TABLE `reading_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comic_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `last_read_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reading_history`
--

INSERT INTO `reading_history` (`id`, `user_id`, `comic_id`, `chapter_id`, `last_read_at`) VALUES
(1, 12, 3, 3, '2025-12-11 13:44:29'),
(2, 12, 3, 2, '2025-12-11 13:44:31'),
(3, 11, 4, 4, '2025-12-11 13:48:58'),
(4, 11, 3, 2, '2025-12-11 13:49:10'),
(5, 11, 3, 3, '2025-12-11 13:49:11'),
(6, 11, 2, 1, '2025-12-11 14:28:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Panzer', 'meindraguna@gmail.com', '$2y$10$3ktw2PDEnkA1vrIuZ66qG.Qi4m3U3scgCGe5gkZGrncpiTqSXFDEi', 'user', '2025-12-08 14:30:09'),
(4, 'Admin', 'admin@gmail.com', '$2y$10$wH1qQ6Vv1d0xq6b1F1w9xu1QK1Q9Hy1aQZ0mZJ2JQ0Z9cV1B1Y8XG', 'admin', '2025-12-08 14:57:28'),
(10, 'Admin', 'admin@example.com', '$2y$10$vQbNgmekpEEOdiLlKItJx.mR0tdvJ9tEdJZyy8TdUtODfKGaX5QeK', 'admin', '2025-12-08 15:06:08'),
(11, 'Panzer', 'meindra.gdeguna10@gmail.com', '$2y$10$cIHGI9N81yGQCSfQQ9myr.fxc2cv/vOpiKfVFkwCaCxIthJAe0o4C', 'user', '2025-12-08 17:04:29'),
(12, 'Panzer', 'testinguser@gmail.com', '$2y$10$yDXAnSgFuyGMsK7JgH9jjefGEuvTA5Xd4TBezhAuzHs0Wq3euauPq', 'user', '2025-12-11 05:19:10');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`comic_id`),
  ADD KEY `comic_id` (`comic_id`);

--
-- Indeks untuk tabel `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comic_id` (`comic_id`);

--
-- Indeks untuk tabel `comics`
--
ALTER TABLE `comics`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `comic_genres`
--
ALTER TABLE `comic_genres`
  ADD PRIMARY KEY (`comic_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indeks untuk tabel `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeks untuk tabel `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indeks untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`comic_id`),
  ADD KEY `comic_id` (`comic_id`);

--
-- Indeks untuk tabel `reading_history`
--
ALTER TABLE `reading_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_chapter` (`user_id`,`chapter_id`),
  ADD KEY `comic_id` (`comic_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `comics`
--
ALTER TABLE `comics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `reading_history`
--
ALTER TABLE `reading_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `comic_genres`
--
ALTER TABLE `comic_genres`
  ADD CONSTRAINT `comic_genres_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comic_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reading_history`
--
ALTER TABLE `reading_history`
  ADD CONSTRAINT `reading_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reading_history_ibfk_2` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reading_history_ibfk_3` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
