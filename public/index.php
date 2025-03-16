<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todolist</title>

    <!-- Connection -->
    <?php require_once './../config/connection.php' ?>

    <!-- Zona Waktu -->
    <?php

    setlocale(LC_TIME, 'id_ID.utf8', 'Indonesian', 'id_ID');
    date_default_timezone_set("Asia/Jakarta");

    ?>

    <!-- Greats -->
    <?php
    $jam = date("H");
    $ucapan = "";

    switch ($jam) {
        case $jam >= 5 && $jam <= 12:
            $ucapan = "Selamat Pagi!";
            break;
        case $jam >= 12 && $jam <= 15:
            $ucapan = "Selamat Siang!";
            break;
        case $jam >= 15 && $jam <= 18:
            $ucapan = "Selamat Sore!";
            break;
        default:
            $ucapan = "Selamat Malam!";
            break;
    }
    ?>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="./../src/css/output.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ecde4d1cd4.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <style>
        .selesai {
            text-decoration: line-through;
        }

        .overflow-x-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>

</head>

<body>

    <div class="bg-blue-500 p-5">
        <div class="bg-white p-5 h-full">

            <!-- Header -->
            <div class="grid grid-cols-3">
                <div class=""></div>
                <div class="justify-items-center">
                    <img src="./assets/images/Ahmad Sani Jabarulloh.jpg" alt="" class="w-32 h-32 rounded-full">
                    <h1 class="text-2xl">
                        <?= $ucapan; ?> <span class="font-semibold">Ahmad Sani Jabarulloh</span>
                    </h1>
                    <p class="text-lg">
                        <?= date("l, d F Y") ?> |
                        <span id="jam"><?= date("H:i:s") ?></span> WIB
                    </p>
                </div>
                <div class=""></div>
            </div>

            <!-- Insert -->
            <form class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 mt-5" action="./../api/insert.php"
                method="post">
                <input class="bg-blue-500 text-white p-2 col-span-2 md:col-span-1 rounded" type="text" name="nama_tasks"
                    placeholder="Nama Tasks">
                <input class="bg-blue-500 text-white p-2 rounded" type="date" name="tanggal">
                <select class="bg-blue-500 text-white p-2 rounded" name="prioritas">
                    <option>Pilih Prioritas</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
                <select class="bg-blue-500 text-white p-2 rounded" name="status">
                    <option>Pilih Status</option>
                    <option value="Belum">Belum</option>
                    <option value="Selesai">Selesai</option>
                </select>
                <button class="bg-blue-500 hover:bg-blue-900 text-white justify-items-center p-2 rounded"
                    type="submit">Add</button>
            </form>

            <!-- Select -->
            <?php
            $query = mysqli_query($connection, "SELECT id_tasks, checked, nama_tasks, tanggal, DATEDIFF(tanggal, CURDATE()) AS sisa_hari, prioritas, status FROM tasks");
            $tasks = mysqli_fetch_all($query, MYSQLI_ASSOC);
            ?>
            <div class="overflow-x-scroll mt-5">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border-2 border-blue-500 p-2">
                                No
                            </th>
                            <th class="border-2 border-blue-500 p-2">
                                <i class="fa-solid fa-check"></i>
                            </th>
                            <th class="border-2 border-blue-500 p-2 min-w-[200px]">
                                Nama Tasks
                            </th>
                            <th class="border-2 border-blue-500 p-2 min-w-[200px]">
                                Tanggal
                            </th>
                            <th class="border-2 border-blue-500 p-2 min-w-[120px]">
                                Sisa Hari
                            </th>
                            <th class="border-2 border-blue-500 p-2 min-w-[100px]">
                                Prioritas
                            </th>
                            <th class="border-2 border-blue-500 p-2 min-w-[100px]">
                                Status
                            </th>
                            <th class="border-2 border-blue-500 p-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="">

                        <?php foreach ($tasks as $index => $task): ?>
                            <tr class="hover:bg-slate-200">
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <?= $index + 1 ?>
                                </td>
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <form method="post" action="./../api/update-status.php">
                                        <input type="hidden" name="id" value="<?= $task['id_tasks']; ?>">
                                        <input type="checkbox" name="checked" <?= ($task['checked'] == 1) ? 'checked' : ''; ?>
                                            onchange="this.form.submit();">
                                    </form>
                                </td>
                                <td class="border-2 border-blue-500 p-2">
                                    <form action="./../api/update-nama_task.php" method="post">
                                        <input type="hidden" name="id_tasks" value="<?= $task['id_tasks']; ?>">
                                        <input
                                            class="w-full p-1 <?= ($task['checked'] == 1) ? 'line-through text-gray-500' : ''; ?>"
                                            type="text" name="nama_tasks" value="<?= $task['nama_tasks']; ?>"
                                            onchange="this.form.submit();">
                                    </form>
                                </td>
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <?= date('d F Y', strtotime($task['tanggal'])); ?>
                                </td>
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <?= $task['sisa_hari']; ?> Hari
                                </td>
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <?= ($task['prioritas'] == 'High') ? "<p class='bg-red-100 text-red-500 p-1 rounded-full'>High</p>" : (($task['prioritas'] == 'Medium') ? "<p class='bg-yellow-100 text-yellow-500 p-1 rounded-full'>Medium</p>" : "<p class='bg-green-100 text-green-500 p-1 rounded-full'>Low</p>"); ?>
                                </td>
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <?= ($task['status'] == 'Selesai') ? '<p class="bg-green-100 text-green-500 p-1 rounded-full">Selesai</p>' : '<p class="bg-red-100 text-red-500 p-1 rounded-full">Belum</p>'; ?>
                                </td>
                                <td class="border-2 border-blue-500 text-center p-2">
                                    <a href="./../api/delete.php?id=<?= $task['id_tasks']; ?>"
                                        class="bg-red-500 hover:bg-red-800 text-white p-2 transition-all duration-500 ease-in-out rounded">
                                        Hapus
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function updateJam() {
            let sekarang = new Date();
            let jam = sekarang.getHours().toString().padStart(2, '0');
            let menit = sekarang.getMinutes().toString().padStart(2, '0');
            let detik = sekarang.getSeconds().toString().padStart(2, '0');
            document.getElementById("jam").innerText = jam + ":" + menit + ":" + detik;
        }

        setInterval(updateJam, 1000); 
    </script>
</body>

</html>