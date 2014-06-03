<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright © 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */
defined('_JEXEC') or die();
?>

<div id="community-events-wrap" class="cIndex">

	<?php if( $featuredHTML ) { ?>
		<?php echo $featuredHTML; ?><!--call events.featured.php -->
	<?php } ?>



		<div class="cLayout">
			<div class="cSidebar">
				<!-- START nearby event search -->
				<?php echo $this->view('events')->modEventNearby(); ?>
				<!-- END nearby event search -->

				<!-- Categories -->
				<?php
				if ( $index && $handler->showCategories() ) :
					echo $this->view('events')->modEventCategories($category, $categories);
				endif;
				?>
				<!-- End Categories -->

				<!-- START event calendar -->
				<?php echo $this->view('events')->modEventCalendar(); ?>

				<!-- END event calendar -->
			</div>


			<!-- EVENT INDEX'S FUNCTIONS -->
			<div class="cMain">
				<!-- EVENT SORTINGS-->
				<?php echo $sortings; ?>

				<!-- EVENT LISTINGS -->
				<?php echo $eventsHTML;?>
			</div>



			<script type="text/javascript">
			joms.jQuery(document).ready(function(){
					// Get the Current Location from cookie
					var location =	joms.geolocation.getCookie( 'currentLocation' );

					if( location.length != 0 )
					{
							joms.jQuery('#showNearByEventsLoading').show();
							joms.geolocation.showNearByEvents( location );
					}

					// Check if the browsers support W3C Geolocation API
					// If yes, show the auto-detect link
					if( navigator.geolocation )
					{
						joms.jQuery('#autodetectLocation').show();
					}
			});
			</script>
		</div>

</div>