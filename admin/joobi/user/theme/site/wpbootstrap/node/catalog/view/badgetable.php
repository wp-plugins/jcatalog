<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>

<table class="catalogItem badgeTable<?php echo $this->getContent('classSuffix'); ?>"<?php echo $this->getContent('containerStyle'); ?>>

	<tr>

		<td colspan="2">

			<?php if ( $name = $this->getContent('name') ) : echo $name.'<br>'; endif; ?>

		</td>

	</tr>

	<tr>

		<?php

		$preview = $this->getContent('preview');

		$imagePath = $this->getContent('thumbnailPath');

		if (  $imagePath || $preview ) : ?>

		<td valign="top" style="padding:3px; text-align:center">

			<?php 
			if ($imagePath) :

				$imageWidth = $this->getContent('imageWidth');

				$imageHeight = $this->getContent('imageHeight');

				if ( !empty( $imageWidth) && !empty($imageHeight) ) $imageSize = ' width="'.$imageWidth.'" height="'.$imageHeight.'"';

				else $imageSize = '';

				if ( $this->getContent('imageLinked') ) {

					echo '<a href="'.$this->getContent('pageLink').'"><img title="'.$this->getContent('name').'" border="0" src="'. $imagePath . '"'.$imageSize.' /></a>';

				} else {

					echo WPage::createPopUpLink( $this->getContent('imagePath'), '<img title="'.$this->getContent('name').'" border="0" src="'. $imagePath . '"'.$imageSize.' />', ($this->getContent('originWidth')*1.15), ($this->getContent('originHeight')*1.15) );

				}


			endif;



			if ( $preview ) : ?>

			<div class="sitePreview<?php echo $this->getContent('previewType'); ?>">

				<?php echo $preview; ?>

			</div>

			<?php endif; ?>

		</td>

		<?php endif; ?>

		<?php

		$rating = $this->getContent('rating');

		$reviews = $this->getContent('nbReviews');

		$convertedPrice = $this->getContent('convertedPrice');

		$highestBid = $this->getContent('highestBid');

		$countDown = $this->getContent('countDown');



		$vendor = $this->getContent('vendorName');

		if ( !empty($rating) || !empty($convertedPrice) || !empty($vendor) || !empty($reviews) || !empty($highestBid) ) :

		?>

		<td valign="top" style="text-align:left;">

			<?php

			if ( $rating ) : echo '<br />'.$rating; endif;

			if ( $reviews ) : echo '<br />'.$reviews; endif;

			if ( $highestBid ) : echo '<br />'.$highestBid; endif;

			if ( $convertedPrice ) : echo '<br />'.$convertedPrice; endif;

			if ( $countDown ) : echo '<br />'.$countDown; endif;

			if ( $vendor ) :

				echo '<br />'.$this->getContent('vendorBy').': <a href="'.$this->getContent('vendorLink').'">' . $vendor . '</a>' . $this->getContent('syndicateVendorName');

			endif;

			if ( $question = $this->getContent('askQuestionLink') ) : echo '<div class="siteQuestion">'.$question . '</div>'; endif;



			$linkFavorite = $this->getContent('linkFavorite');

			$linkWish = $this->getContent('linkWish');

			$linkWatch = $this->getContent('linkWatch');

			$linkLike = $this->getContent('linkLike');

			$linkViews = $this->getContent('linkViews');



			$linkFacebook = $this->getContent('linkFacebook');

			$linkTwitter = $this->getContent('linkTwitter');

			$googlePlus1 = $this->getContent('linkGoogle');

			$linkShare = $this->getContent('linkShare');



			if ( $linkFavorite || $linkWish || $linkWatch || $linkLike || $linkViews ) :

				echo '<div class="badgeShare vertiMrgn">';

					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';

					if ( $linkFavorite ) : echo $linkFavorite; endif;

					if ( $linkWish ) : echo $linkWish; endif;

					if ( $linkWatch ) : echo $linkWatch; endif;

					if ( $linkLike ) : echo $linkLike; endif;

					if ( $linkViews ) : echo $linkViews; endif;

					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';

				echo '</div>';

			endif;

			if ( $linkFacebook || $linkTwitter || $googlePlus1 || $linkShare ) :

				echo '<div class="badgeShareOnline vertiMrgn">';

					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';

					if ( $linkFacebook ) : echo $linkFacebook; endif;

					if ( $linkTwitter ) : echo $linkTwitter; endif;

					if ( $googlePlus1 ) : echo $googlePlus1; endif;

					if ( $linkShare ) : echo $linkShare; endif;

					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';

				echo '</div>';

			endif;



			?>

		</td>

		<?php endif; ?>

	</tr>

	<?php if ( $this->getContent('introduction') || $this->getContent('description')) { ?>

	<tr>

		<td colspan="2" style="padding:3px; text-align:left">

			<?php

			if ( $intro = $this->getContent('introduction') ) : echo $intro; endif;

			if ( $readMore = $this->getContent('readMoreLink') ) : echo $readMore; endif;

			if ( $desc = $this->getContent('description') ) : echo $desc; endif;

			?>

		</td>

	</tr>

	<?php } ?>

	<tr>

		<td colspan="2" align="right"">

			<?php

			if ( $quantity = $this->getContent('quantity') ) : echo '<div class="siteQuantity">' . $quantity . '</div>';

			elseif ( $cart = $this->getContent('cart') ) : echo $cart.'<br>'; endif;

			?>

		</td>

	</tr>

</table>