<?php


/* get cache or execute archive loop ---------------------------------------------------------------------------------*/
global $oes_archive_data;
$oes_archive_data = oes_get_archive_data();


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_archive_data['archive']['label']]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <script type="text/javascript">
        let oes_filter = <?php echo json_encode($oes_archive_data['archive']['filter_array']['json'] ?? []);?>;
    </script>
    <main class="oes-smooth-loading"><?php
        get_template_part('template-parts/archive', 'content'); ?>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();