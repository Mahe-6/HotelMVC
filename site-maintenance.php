<?php
$maintenanceEnabled = true; // Mettez false pour rouvrir le site

if (!$maintenanceEnabled) {
    return;
}

http_response_code(503);
header('Retry-After: 3600');
?>
<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><title>Maintenance</title></head>
<body><h1>Site en maintenance</h1><p>Veuillez revenir un peu plus tard.</p></body>
</html>
<?php exit; ?>