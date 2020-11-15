<script type="text/javascript" src="https://merchi.co/static/js/dist/merchi-init.js"></script>
<script>
  window.MERCHI_SDK = MERCHI_INIT.MERCHI_SDK;
</script>

<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <?php settings_errors(); ?>

  <form action="options.php" method="post">
    <?php 
			settings_fields( 'merchi_options_group' );
			do_settings_sections( 'merchi_plugin' );
			submit_button( 'Save Settings' );
		?>
  </form>
</div>
