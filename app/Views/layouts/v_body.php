<body>
    <script src="<?= base_url('/dist/js/demo-theme.min.js?1692870487') ?>"></script>
    <div class="page">
        <?= $this->include('layouts/v_sidebar') ?>
        <div class="page-wrapper">
            <?= $this->include($content) ?>
            <?= $this->include('layouts/v_footer') ?>
        </div>
    </div>

    <!-- Tabler Core -->
    <script src="<?= base_url('/dist/js/tabler.min.js?1692870487') ?>" defer></script>
    <script src="<?= base_url('/dist/js/demo.min.js?1692870487') ?>" defer></script>

</body>

</html>