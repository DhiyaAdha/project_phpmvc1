<?php

// Memulai sesi
session_start();

// Menghancurkan sesi yang ada
session_destroy();

// Mengarahkan pengguna ke halaman index.php
header("Location: index.php");
