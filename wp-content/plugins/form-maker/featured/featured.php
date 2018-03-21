<?php
function fm_extensions_page($current_plugin = '') {
  wp_enqueue_style('fm-featured');
  wp_enqueue_style('fm-featured-admin');
	$addons = array(
		'Form Maker Add-ons' => array(
			'imp_exp'   => array(
				'name'        => 'Import/Export',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/export-import.html',
				'description' => 'Form Maker Export/Import WordPress plugin allows exporting and importing forms with/without submissions.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/import_export.png', __FILE__ ),
				'file_dir'	  => 'form-maker-export-import/fm_exp_imp.php'
			),
			'mailchimp' => array(
				'name'        => 'MailChimp',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/mailchimp.html',
				'description' => 'This add-on is an integration of the Form Maker with MailChimp which allows to add contacts to your subscription lists just from submitted forms.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/mailchimp.png', __FILE__ ),
				'file_dir'	  => 'form-maker-mailchimp/fm_mailchimp.php'
			),
			'reg' => array(
				'name'        => 'Registration',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/registration.html',
				'description' => 'User Registration add-on integrates with Form maker forms allowing users to create accounts at your website.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/reg.png', __FILE__ ),
				'file_dir'	  => 'form-maker-reg/fm_reg.php'
			),
			'post_generation' => array(
				'name'        => 'Post Generation',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/post-generation.html',
				'description' => 'Post Generation add-on allows creating a post, page or custom post based on the submitted data.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/post-generation-update.png', __FILE__ ),
				'file_dir'	  => 'form-maker-post-generation/fm_post_generation.php'
			),
			'conditional_emails' => array(
				'name'        => 'Conditional Emails',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/conditional-emails.html',
				'description' => 'Conditional Emails add-on allows to send emails to different recipients depending on the submitted data .',
				'icon'        => '',
				'image'       => plugins_url( '../assets/conditional-emails-update.png', __FILE__ ),
				'file_dir'	  => 'form-maker-conditional-emails/fm_conditional_emails.php'
			),
			'dropbox_integration' => array(
				'name'        => 'Dropbox Integration',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/dropbox.html',
				'description' => 'The Form Maker Dropbox Integration addon is extending the Form Maker capabilities allowing to store the form attachments straight to your Dropbox account.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/dropbox-integration-update.png', __FILE__ ),
				'file_dir'	  => 'form-maker-dropbox-integration/fm_dropbox_integration.php'
			),
			'gdrive_integration' => array(
				'name'        => 'Google Drive Integration',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/google-drive.html',
				'description' => 'The Google Drive Integration add-on integrates Form Maker with Google Drive and allows you to send the file uploads to the Google Drive',
				'icon'        => '',
				'image'       => plugins_url( '../assets/google_drive_integration.png', __FILE__ ),
				'file_dir'	  => 'form-maker-gdrive-integration/fm_gdrive_integration.php'
			),
			'pdf_integration' => array(
				'name'        => 'PDF Integration',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/pdf.html',
				'description' => 'The Form Maker PDF Integration add-on allows sending submitted forms in PDF format.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/pdf-integration.png', __FILE__ ),
				'file_dir'	  => 'form-maker-pdf-integration/fm_pdf_integration.php'
			),
			'pushover' => array(
				'name'        => 'Pushover',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/pushover.html',
				'description' => 'Form Maker Pushover integration allows to receive real-time notifications when a user submits a new form. This means messages can be pushed to Android and Apple devices, as well as desktop notification board.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/pushover.png', __FILE__ ),
				'file_dir'	  => 'form-maker-pushover/fm_pushover.php'
			),
			'form-maker-save-progress' => array(
				'name'        => 'Save Progress',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/save-progress.html',
				'description' => 'The add-on allows to save filled in forms as draft and continue editing them subsequently.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/save-progress.png', __FILE__ ),
				'file_dir'	  => 'form-maker-save-progress/fm_save.php'
			),
			'stripe' => array(
				'name'        => 'Stripe',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/stripe.html',
				'description' => 'Form Maker Stripe Integration Add-on allows to accept direct payments made by Credit Cards. Users will remain on your website during the entire process.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/stripe-integration-update.png', __FILE__ ),
				'file_dir'	  => 'form-maker-stripe/fm_stripe.php'
			),
			'calculator' => array(
				'name'        => 'Calculator',
				'url'         => 'https://web-dorado.com/products/wordpress-form/add-ons/calculator.html',
				'description' => 'The Form Maker Calculator add-on allows creating forms with dynamically calculated fields.',
				'icon'        => '',
				'image'       => plugins_url( '../assets/calculator.png', __FILE__ ),
				'file_dir'	  => 'form-maker-calculator/fm_calculator.php'
			)
		)
	);
?>
<div class="wrap">
	<?php settings_errors(); ?>
	<div id="fm-settings">
		<div id="fm-settings-content" >
			<h2 id="add_on_title"><?php echo esc_html(get_admin_page_title()); ?></h2>
			<?php
			if($addons){
				foreach ($addons as $name => $cat) {
					foreach ( $cat as $addon ) {
						$activated = '';
						if ( is_plugin_active( $addon['file_dir'] ) ) {
							$activated = 'activated';
						}
						?>
						<div class="fm-add-on">
							<h2><?php echo $addon['name'] ?></h2>
							<figure class="fm-figure <?php echo $activated; ?>">
								<div  class="fm-figure-img">
									<a href="<?php echo $addon['url'] ?>" target="_blank">
										<?php if ( $addon['image'] ) { ?>
											<img src="<?php echo $addon['image'] ?>"/>
										<?php } ?>
									</a>
								</div>
								<figcaption class="fm-addon-descr fm-figcaption">
									<?php if ( $addon['icon'] ) { ?>
										<img src="<?php echo $addon['icon'] ?>"/>
									<?php } ?>
									<?php echo $addon['description'] ?>
								</figcaption>
							</figure>
							<?php
								if ( $addon['url'] !== '#' ) {
									if ( !empty($activated) ) {
									?>
										<span class="fm-addon activated"><span><?php _e('Add on activated', WDFM()->prefix); ?></span></span>
									<?php }
									else { ?>
										<a href="<?php echo $addon['url'] ?>" target="_blank" class="fm-addon"><span><?php _e('Get this add on', WDFM()->prefix); ?></span></a>
									<?php }
								} else { ?>
								<div class="fm_coming_soon">
									<img src="<?php echo plugins_url( '../../assets/coming_soon.png', __FILE__ ); ?>"/>
								</div>
							<?php }  ?>
						</div>
					<?php
					}
				}
			}
			?>
		</div>
		<!-- #fm-settings-content -->
	</div>
	<!-- #fm-settings -->
</div><!-- .wrap -->
<?php
}