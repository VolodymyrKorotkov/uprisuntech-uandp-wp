<?php

header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *"); // Дозволяємо доступ з будь-якого джерела
// header("Access-Control-Allow-Methods: POST, OPTIONS"); // Дозволяємо POST запити
// header("Access-Control-Allow-Headers: Content-Type"); // Дозволяємо заголовки Content-Type

// // Перевіряємо, чи прийшов OPTIONS запит (це запит перед відправленням POST запиту у деяких браузерах для перевірки CORS)
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     // Відповідаємо пустою відповіддю на OPTIONS запит і завершуємо виконання скрипта
//     http_response_code(200);
//     exit();
// }


// Ці константи можна налаштувати за потреби
define('UPLOAD_DIR', 'applications/');
define('ALLOWED_MIME_TYPES', ['application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']);
define('MAX_FILE_SIZE', 25 * 1024 * 1024); // 25MB

$response = ['success' => false, 'message' => '', 'path' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $response['message'] = 'Помилка завантаження файлу.';
        } elseif (!in_array($file['type'], ALLOWED_MIME_TYPES)) {
            $response['message'] = 'Непідтримуваний тип файлу. Будь ласка, завантажте PDF, XLSX або XLS файл.';
        } elseif ($file['size'] > MAX_FILE_SIZE) {
            $response['message'] = 'Розмір файлу перевищує максимальний допустимий розмір.';
        } else {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = $file['name'];
            $tmpPath = UPLOAD_DIR . uniqid() . '/';
            $filePath = $tmpPath . $filename;
            if (!is_dir($tmpPath)) {
                mkdir($tmpPath, 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $response['success'] = true;
                $response['message'] = 'Файл успішно завантажено.';
                $response['path'] = $filePath;
            } else {
                $response['message'] = print_r($_FILES,true);
            }
        }
    } else {
        $response['message'] = 'Файл не було передано.';
    }
} else {
    $response['message'] = 'Недопустимий метод запиту.';
}

echo json_encode($response);
?>
