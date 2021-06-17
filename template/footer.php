<footer class="main-footer">
    <div class="footer-left">
        <a href="#">Todo Barato</a></a>
    </div>
    <div class="footer-right">
    </div>
</footer>
</div>
</div>
<!-- General JS Scripts -->
<script src="<?= BASE_URL ?>/assets/js/app.min.js"></script>
<!-- JS Libraies -->
<!-- Page Specific JS File -->
<script src="<?= BASE_URL ?>/assets/bundles/izitoast/js/iziToast.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/sweetalert/sweetalert.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/datatables.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/export-tables/jszip.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
<script src="<?= BASE_URL ?>/assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/page/datatables.js"></script>
<!-- Template JS File -->
<!-- Page Specific JS File -->
<!-- Template JS File -->
<script src="<?= BASE_URL ?>/assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="<?= BASE_URL ?>/assets/js/custom.js"></script>
</body>

<!-- blank.html  21 Nov 2019 03:54:41 GMT -->

</html>

<?php if (isset($db)) {
    $db->db_disconnect();
} ?>