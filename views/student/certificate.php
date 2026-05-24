<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - <?= $data['roadmap']['title']; ?></title>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .cert-card { width: 800px; padding: 50px; background: white; border: 15px solid #0d6efd; text-align: center; position: relative; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .cert-card:before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 2px solid #0d6efd; margin: 5px; }
        h1 { font-size: 50px; color: #181b21; margin-bottom: 0; }
        p { font-size: 20px; color: #6c757d; }
        .name { font-size: 35px; font-weight: bold; color: #0d6efd; border-bottom: 2px solid #0d6efd; display: inline-block; padding: 10px 40px; margin: 20px 0; }
        .roadmap { font-size: 25px; font-weight: bold; color: #181b21; }
        .code { margin-top: 50px; font-size: 12px; color: #adb5bd; }
        .stamp { position: absolute; bottom: 40px; right: 40px; border: 3px double #10b981; color: #10b981; padding: 10px; transform: rotate(-15deg); font-weight: bold; }
    </style>
</head>
<body>
    <div class="cert-card">
        <p>Sertifikat Kelulusan Diberikan Kepada:</p>
        <div class="name"><?= htmlspecialchars($data['user']['username']); ?></div>
        <p>Telah berhasil menyelesaikan roadmap pembelajaran:</p>
        <div class="roadmap">"<?= htmlspecialchars($data['roadmap']['title']); ?>"</div>
        <p>Pada platform pembelajaran digital <strong>SkillPath</strong></p>
        
        <div class="stamp">LULUS VERIFIED</div>
        <div class="code">ID Sertifikat: <?= $data['cert_code']; ?> | Tanggal: <?= date('d M Y'); ?></div>
        <button onclick="window.print()" style="margin-top: 30px; cursor: pointer;">Cetak Sertifikat</button>
    </div>
</body>
</html>