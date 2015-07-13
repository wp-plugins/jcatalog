<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



$pageParams = WGlobals::get( 'itemPageMain', '', 'global' );

?>

<div class="catalogItemProduct<?php if ( !empty( $pageParams->cssclass ) ) echo $pageParams->cssclass; ?>">
	<section>
	<div id="siteHeader" class="clearfix">

		<div id="siteHeading" class="row">
			<?php
			$colWith = 12;
			$itemImage = $this->getRowContent('itemimage');
			$itemMediaPreview = $this->getRowContent('itempreview');
			if ( ( !empty($itemImage) && $pageParams->showImage) || (!empty($itemMediaPreview) && $pageParams->showPreview) ) :
				$colWith = 6;
				$pushRight = (  WPage::isRTL() ? ' col-md-push-' . $colWith : '' );
			?>
			<div id="siteMedia" class="col-md-6<?php echo $pushRight; ?>">
				<?php if ( $itemImage && $pageParams->showImage ) : ?>
				<div id="siteImage">
<?php if ( $sale = $this->getValue('onSaleProduct') ): ?>

<div class="<?php echo WPref::load( 'PCATALOG_NODE_ONSALESTYLE' ); ?> <?php echo WPref::load( 'PCATALOG_NODE_ONSALEPOSITION' ); ?> badge<?php echo WPref::load( 'PCATALOG_NODE_ONSALECOLOR' ); ?>"><span><?php echo $this->getValue('onSaleProductText'); ?></span></div>

<?php endif; ?>

<?php if ( $new = $this->getValue('newItem') ): ?>

<div class="<?php echo WPref::load( 'PCATALOG_NODE_NEWITEMSTYLE' ); ?> <?php echo WPref::load( 'PCATALOG_NODE_NEWITEMPOSITION' ); ?> badge<?php echo WPref::load( 'PCATALOG_NODE_NEWITEMCOLOR' ); ?>"><span><?php echo $this->getValue('newItemText'); ?></span></div>

<?php endif; ?>

<?php if ( $hot = $this->getValue('featured') ): ?>

<div class="<?php echo WPref::load( 'PCATALOG_NODE_FEATUREDSTYLE' ); ?> <?php echo WPref::load( 'PCATALOG_NODE_FEATUREDPOSITION' ); ?> badge<?php echo WPref::load( 'PCATALOG_NODE_FEATUREDCOLOR' ); ?>"><span><?php echo $this->getValue('featuredText'); ?></span></div>

<?php endif; ?>

					<div id="ImageBox">
					<?php echo $itemImage; ?>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( $itemMediaPreview && $pageParams->showPreview ) : ?>
				<div id="siteMediaPreview">
					<div id="sitePreview<?php echo $this->getValue('previewType'); ?>">
						<?php echo $itemMediaPreview; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div id="siteContent" class="col-md-<?php echo $colWith; ?>">
				<?php if ( $itemName = $this->getValue('name') ) : ?>
				<div class="page-header">
				<h2 class="title">
					<cite><?php echo $itemName; ?></cite>
				</h2>
				</div>
				<?php endif; ?>

				<?php
					$editButton = $this->getValue('editButton');
					$syndicateLink = $this->getValue('syndicateLink');
					$resellersLink = $this->getValue('resellersLink');
					$shwoControlButton = $editButton || $syndicateLink || $resellersLink;
					if ( !empty($shwoControlButton) ) :

				?>
				<div id="editable">
					<div class="btn-group">
					<?php
					if ( !empty($editButton) ) :

						$buttonO = WPage::newBluePrint( 'button' );
						$buttonO->type = 'infoLink';
						$buttonO->text = $editButton;
						$buttonO->icon = 'fa-edit';
						$buttonO->color = 'success';
						$buttonO->link = $this->getValue( 'editButtonLink' );
						$buttonO->popUpIs = true;
						$buttonO->popUpWidth = '90%';
						$buttonO->popUpHeight = '90%';
						echo WPage::renderBluePrint( 'button', $buttonO );

						$buttonO = WPage::newBluePrint( 'button' );
						$buttonO->type = 'infoLink';
						$buttonO->text = $this->getValue('deleteButton');
						$buttonO->icon = 'fa-trash-o';
						$buttonO->color = 'danger';
						$buttonO->link = $this->getValue( 'deleteButtonLink' );
						echo WPage::renderBluePrint( 'button', $buttonO );
					endif;

					if ( !empty($syndicateLink) ) :

						echo $syndicateLink;

					endif;

					if (!empty($resellersLink) ) :
						$buttonO = WPage::newBluePrint( 'button' );
						$buttonO->type = 'infoLink';
						$buttonO->text = $this->getValue('resellersText');
						$buttonO->icon = 'fa-dollar';
						$buttonO->color = 'warning';
						$buttonO->link = resellersLink;
						echo WPage::renderBluePrint( 'button', $buttonO );
					endif; ?>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( $pageParams->showRating && $itemRating = $this->getRowContent('itemrating') ) : ?>
				<div class="siteRating">
					<?php echo $itemRating; ?>
				</div>
				<?php endif; ?>

				<?php if ( $progressBar = $this->getValue('progressBar') ) : ?>
					<div id="cartTarget">
						<?php echo $progressBar; ?>
					</div>
				<?php endif; ?>

				<?php
				$stock = $this->getValue( 'stockInformation' );
				if ( !empty($stock) ) :
				$inStockText = $this->getValue( 'stockText' );
				?>
				<div id="stockInfo">
					<?php echo $inStockText . ': ' . $stock; ?>
				</div>
				<?php endif; ?>

				<?php if ( $pageParams->showIntro && $shortDesc = $this->getRowContent('itemintroduction') ) : ?>
				<div id="siteIntroduction" class="clearfix">
					<div class="siteIntroductionContent text-muted">
						<?php echo $shortDesc; ?>
					</div>
				</div>
				<?php endif; ?>
				<hr class="soft">


				<?php if ( $pageParams->showPromo && $promo = $this->getValue('promo') ) : ?>

				<div id="sitePromo" class="clearfix">

					<div class="sitePromoContent">

						<?php echo $promo; ?>

					</div>

				</div>

				<?php endif; ?>



				<?php if ( $pageParams->showPrice ) :
					$itemOption = $this->getRowContent( 'itemoption' );
					if ( strlen($itemOption) > 20 ) :
					$itemOption = substr( $itemOption, 5, -6 );
					$allOptionsA = unserialize( $itemOption );
					?>
						<div id="cartOption" class="priceLayout clearfix">
							<?php
							if ( !empty($allOptionsA) ) {
							foreach( $allOptionsA as $oneOption ) {
							?>
							<div class="control-group">
								<label class="control-label">
								<span><?php echo $oneOption->name; ?></span>
								</label>
								<div class="controls">
								<?php echo $oneOption->values; ?>
								</div>
							</div>
							<?php
							}							}							?>
						</div>
					<?php endif; ?>

					<?php
						$itemQuantity = $this->getRowContent('itemquantity');
						$itemPrice = $this->getRowContent( $this->getValue( 'pricetoshow' ) );
						$itemPriceTotal = $this->getValue( 'priceTotal' );
						$itemDiscountedPrice = $this->getValue('discountPrice');
						if ( $this->getValue( 'showpricetype' ) ) : ?>
					<div id="itemType" class="priceLayout clearfix">
						<div class="control-group">
							<label class="control-label">
							<span><?php echo $this->getTitle('itemprice'); ?></span>
							</label>
							<div class="controls">
							<?php echo $this->getRowContent('itemprice'); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $pageParams->showQuantity && $itemQuantity && $itemPrice ) :

						$onSalePercent = $this->getValue('onSaleYouSavePercent');

					 	if ( !empty($onSalePercent) ) $onSalePercent = ' (' . $onSalePercent . ')';

					 ?>
					<div id="sitePrice" class="priceLayout clearfix">
						<div class="control-group">
							<label class="control-label">
							<span><?php echo $this->getTitle( $this->getValue( 'pricetoshow' ) ); ?></span>
							</label>
							<div class="controls">
								<span class="productCurrency<?php echo $this->getValue('priceDiscountClass'); ?>"> <?php echo $itemPrice; ?> </span>
								<?php if ( $itemDiscountedPrice ): ?>
								<span id="productDiscount"> <?php echo $itemDiscountedPrice; ?> </span>

								<span id="productDiscountSaved"> <?php echo $this->getValue('onSaleYouSave') . ': ' . $this->getValue('onSaleYouSaveValue') . $onSalePercent; ?> </span>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $pageParams->showQuantity && $itemQuantity ) : ?>
					<div id="siteQuantity" class="priceLayout clearfix">
						<div class="control-group">
							<label class="control-label">
							<span><?php echo $this->getTitle('itemquantity'); ?></span>
							</label>
							<div class="controls">
							<?php echo $itemQuantity; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $itemPrice ) : ?>
					<div id="siteTotal" class="priceLayout clearfix">
						<div class="control-group">
							<label class="control-label">
							<span><?php echo $this->getTitle('itemtotal'); ?></span>
							</label>
							<div class="controls">
							<span id="productTotalValue" class="productCurrency<?php echo $this->getValue('priceDiscountClass'); ?>"> <?php echo $itemPriceTotal; ?> </span>
							</div>
						</div>
					</div>
					<?php endif; ?>

				<?php endif; ?>

				<?php if ( $pageParams->showCartButton && $addToCart = $this->getRowContent('addtocart') ) : ?>
					<div id="siteCartbutton">
						<?php echo $addToCart; ?>
					</div>
				<?php endif; ?>

				<?php if ( $shippingMethod = $this->getValue('shippingMessage') ) : ?>
					<div id="siteShipping">
						<?php echo $shippingMethod; ?>
					</div>
				<?php endif; ?>


				<?php
				$showShare = $pageParams->showFavorite || $pageParams->showWatch || $pageParams->showViews || $pageParams->showLikeDislike || $pageParams->showWish || $pageParams->showShareWall || $pageParams->showEmail || $pageParams->showPrint;
				if ( $showShare ) : ?>
				<hr class="soft">
				<div id="siteShareButton" class="clearfix">
					<?php
					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';
					if ( $pageParams->showViews ) echo $this->getValue( 'linkViews' );
					if ( $pageParams->showLikeDislike ) echo $this->getValue( 'linkLikeDislike' );
					if ( $pageParams->showFavorite ) echo $this->getValue( 'linkFavorite' );
					if ( $pageParams->showWatch ) echo $this->getValue( 'linkWatch' );
					if ( $pageParams->showWish ) echo $this->getValue( 'linkWish' );
					$shareWallButton = $this->getValue( 'linkShareWall' );
					if ( $pageParams->showShareWall && !empty($shareWallButton) ) echo $shareWallButton;
					if ( $pageParams->showEmail ) echo $this->getValue( 'linkEmail' );
					if ( $pageParams->showPrint ) echo $this->getValue( 'linkPrint' );
					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';
					?>
				</div>
				<?php endif; ?>

				<?php
				$licenseAgreement = $this->getContent('liceneAgreement');
				$refundPolicy = $this->getContent('refundPolicy');
				$refundPeriod = $this->getContent('refundPeriod');
				if ( !empty($licenseAgreement) || !empty($refundPolicy) || !empty($refundPeriod) ) :
				?>
				<div class="siteTerms">
					<?php if ( !empty($licenseAgreement) ) : ?>
					<div id="termsLicense">
						<?php echo $licenseAgreement; ?>
					</div>
					<?php endif; ?>
					<?php if ( !empty($refundPolicy) ) : ?>
					<div id="refundPolicy">
						<?php echo $refundPolicy; ?>
					</div>
					<?php endif; ?>
					<?php if ( !empty($refundPeriod) ) : ?>
					<div id="refundPeriod">
						<?php echo $refundPeriod; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>


				<?php
				$showShareOnline = $pageParams->showLike || $pageParams->showTweet || $pageParams->showBuzz || $pageParams->showShareThis;
				if ( $showShareOnline ) : ?>
					<div id="siteShareOnline" class="clearfix">
						<?php
						if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';
						if ( $pageParams->showLike ) echo $this->getValue( 'linkFacebook' );
						if ( $pageParams->showTweet ) echo $this->getValue( 'linkTwitter' );
						if ( $pageParams->showBuzz && $googlePlus1 = $this->getValue('linkGoogle') ) echo $googlePlus1;
						if ( $pageParams->showShareThis ) echo $this->getValue( 'linkShareThis' );
						if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';
						?>
					</div>
				<?php endif; ?>
				<?php echo $this->getValue( 'extraSocialHTML' ); ?>


				<?php if ( $pageParams->showAskQuestion || $pageParams->showVendor ) : ?>
				<div id="siteVendor">
					<?php
					$itemVendor = $this->getRowContent('itemvendor');
					if ( $pageParams->showVendor && !empty($itemVendor) ) : ?>
					<h5 class="siteName">
						<?php echo $this->getTitle('itemvendor') .' : '. $itemVendor . $this->getValue( 'syndicateVendor' ); ?>
					</h5>
					<?php if ( $pageParams->showVendorRating ) : ?>
					<div class="siteRating">
						<?php echo $this->getRowContent( 'itemvendorrating' ); ?>
					</div>
					<?php endif; ?>
					<?php endif; ?>
					<?php if ( $pageParams->showAskQuestion ) : ?>
					<div class="siteQuestion">
						<?php echo $this->getValue( 'askQuestionLink' ); ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>

		</div>

	</div>
	</section>

	<section>

	{widget:area|name=middleCenter}
	</section>

	<section>
	{widget:area|name=map}

	</section>


	<?php if ( $bundleItems = $this->getRowContent('itembundle') ) :
	$itmtitle = WGlobals::get( 'itmBundletitle', null, 'global' );

	$data = WPage::newBluePrint( 'widgetbox' );
	$data->content = $bundleItems;
	if ( $itmtitle ) $data->title = $this->getTitle( 'itembundle' );
	$bundlePagi = $this->getValue( 'bundlePagination' );
	if ( !empty($cateogriesPagi) ) {
		$data->headerCenterA[] = $bundlePagi;
		$data->bottomCenterA[] = $bundlePagi;
	}
	?>
	<div class="siteBundle clearfix">
	<section>
		<?php echo WPage::renderBluePrint( 'widgetbox', $data ); ?>
	</section>
	</div>
	<?php endif; ?>



	<?php if ( $relatedItems = $this->getValue('itemRelated')  ) :
	$showItemRelatedTitle = $this->getValue('itemRelatedTitle');

	$data = WPage::newBluePrint( 'widgetbox' );
	$data->content = $relatedItems;
	if ( $showItemRelatedTitle ) $data->title = $showItemRelatedTitle;
	$itemsRelatedPagi = $this->getValue( 'itemsRelatedPagination' );
	if ( !empty($itemsRelatedPagi) ) {
		$data->headerCenterA[] = $itemsRelatedPagi;
		$data->bottomCenterA[] = $itemsRelatedPagi;
	}
	?>
	<div class="siteRelated clearfix">
	<section>
		<?php echo WPage::renderBluePrint( 'widgetbox', $data ); ?>
	</section>
	</div>
	<?php endif; ?>



	{widget:area|name=aboveReview}


	<?php if ( $itemComment = $this->getRowContent('itemcommenttotal') ) : ?>
	<section>

	<div id="comment">
  		<?php echo $itemComment; ?>

  		<?php echo $this->getRowContent('itemcommentlist'); ?>

  		<?php echo $this->getRowContent('itemcommentbutton'); ?>

 	</div>
 	</section>

	<?php endif; ?>

</div>