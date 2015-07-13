<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<?php
$elements = $this->getContent( 'elements' );
$elementParams = $this->getContent( 'elementParams' );
$header = $this->getContent( 'header' );

if ( !empty($elements) ) : ?>
<div class="table-responsive">
<table class="table table-striped catalogItem badgeTable<?php echo $this->getContent('classSuffix'); ?>">
<?php if ( !empty($header) && !empty($elementParams->showHeader) ) : ?>
<tr>
	<?php if ( empty($elementParams->showNoImage) ) : ?>
	<th><?php echo $header->photo; ?></th>
	<?php endif; ?>
	<th><?php echo $header->name; ?></th>
	<?php if ( !empty($elementParams->showPrice) ) : ?>
	<th><?php echo $header->price; ?></th>
	<?php endif; ?>
</tr>
<?php endif; ?>
<?php foreach( $elements as $i => $element ) :
$style = ( !empty( $element->style ) ? ' style="' . $element->style . '"' : '' );
?>
<tr<?php echo $style; ?>>
	<?php if ( empty($elementParams->showNoImage) && !empty($element->thumbnailPath) ) : ?>
	<td style="text-align: center;">
	<?php
		if ( !empty($element->imageWidth) ) $imageWidth = $element->imageWidth;
		if ( !empty($element->imageHeight) ) $imageHeight = $element->imageHeight;
		if ( !empty( $imageWidth) && !empty($imageHeight) ) $imageSize = ' width="'.$imageWidth.'" height="'.$imageHeight.'"';
		else $imageSize = '';
		$originWidth = $element->originWidth;if ( empty($originWidth) ) $originWidth = 150;
		$originHeight = $element->originHeight;if ( empty($originHeight) ) $originHeight = 200;
		$imagePath = $element->thumbnailPath;

		if ( $element->imageLinked ) {
			echo '<a href="'.$element->pageLink .'"><img title="'.$element->name .'" border="0" src="'. $imagePath . '"'.$imageSize.' /></a>';
		} else {
			echo WPage::createPopUpLink( $element->imagePath, '<img title="'.$element->name.'" border="0" src="'. $imagePath . '"'.$imageSize.' />', ($element->originWidth*1.15), ($element->originHeight*1.15) );
		}		?>
	</td>
	<?php endif; ?>
	<td>
	<?php
		if ( empty($elementParams->showNoName) ) echo '<h4 class="itemName">' . $element->linkName . '</h4>';
		if ( !empty($element->rating) ) echo $element->rating;
		if ( !empty($elementParams->showReview) && !empty($element->comment) ) echo $element->nbReviews;
		if ( !empty($element->introduction) ) echo '<br>' . $element->introduction;
		if ( !empty($element->readMoreLink) ) echo $element->readMoreLink;
		if ( !empty($element->description) ) echo '<br>' . $element->description;
		if ( !empty($elementParams->showVendor) && !empty($element->vendorName) ) : echo '<br />'. $element->vendorBy . ': <a href="'. $element->vendorLink.'">' . $element->vendorName . '</a>' . ( !empty($element->syndicateVendorName) ? $element->syndicateVendorName : '' ); endif;
		if ( !empty($element->preview) ) echo '<br><span class="catalogPreview">' . $element->preview . '</span>';

		if ( !empty($element->linkFavorite) || !empty($element->linkWish) || !empty($element->linkWatch) || !empty($element->linkLike) || !empty($element->linkViews) ) :
			echo '<div class="badgeShare vertiMrgn">';
				if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';
				if ( !empty($element->linkFavorite) ) : echo $element->linkFavorite; endif;
				if ( !empty($element->linkWish) ) : echo $element->linkWish; endif;
				if ( !empty($element->linkWatch) ) : echo $element->linkWatch; endif;
				if ( !empty($element->linkLike) ) : echo $element->linkLike; endif;
				if ( !empty($element->linkViews) ) : echo $element->linkViews; endif;
				if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';
			echo '</div>';
		endif;
		if ( !empty($element->linkFacebook) || !empty($element->linkTwitter) || !empty($element->linkGoogle) || !empty($element->linkShare) ) :
			echo '<div class="badgeShareOnline vertiMrgn">';
				if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';
				if ( !empty($element->linkFacebook) ) : echo $element->linkFacebook; endif;
				if ( !empty($element->linkTwitter) ) : echo $element->linkTwitter; endif;
				if ( !empty($element->linkGoogle) ) : echo $element->linkGoogle; endif;
				if ( !empty($element->linkShare) ) : echo $element->linkShare; endif;
				if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';
			echo '</div>';
		endif;

	?>
	</td>
	<?php if ( !empty($elementParams->showPrice) || !empty($element->highestBid) ) : ?>
	<td style="vertical-align:top; text-align:center;">
	<?php if( !empty($element->highestBid) ) echo $element->highestBid; ?>
	<?php if( !empty($element->convertedPrice) ) echo $element->convertedPrice; ?>
	<?php if( !empty($elementParams->addCart) ) echo $element->cart; ?>
	</td>
<?php if ( !empty($element->badge) ): ?>
<td>
<div class="<?php echo $element->badge->style; ?> <?php echo $element->badge->badgeColor; ?>"><span><?php echo $element->badge->badgeName; ?></span></div>
</td>
<?php endif; ?>
	<?php endif; ?>
</tr>
<?php endforeach; ?>
</table>
</div>
<?php endif; ?>