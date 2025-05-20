<?php require_once __DIR__ . '/includes/init.php'; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include __DIR__ . '/includes/sidebar.php'; ?>

            <div class="col-md-9 col-lg-10 p-0">
                <iframe name="content" class="w-100"></iframe>
            </div>
        </div>
    </div>

    <!-- Bootstrap & Lucide -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
