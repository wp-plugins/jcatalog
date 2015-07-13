<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>

<main>
<div id="vendorHomePage">

	<jdoc:include type="modules" name="catalog-vendor-top" style="no" />

	<?php

	
	if ( !defined('PCATALOG_NODE_BANNER') ) WPref::get( 'catalog.node' );

	if ( !defined('PVENDOR_NODE_SHOWCOMMENT') ) WPref::get( 'vendor.node' );

	$showItems = PCATALOG_NODE_VDLYTITMITEMS;
	$searchBox = WPref::load( 'PVENDORS_NODE_SEARCHBOX' );

	$showCategory = PCATALOG_NODE_CTYITEMS;

	$showVendors = PCATALOG_NODE_VDRITEMS;

	$showRatings = PCATALOG_NODE_VENDORSHOWRATING && PVENDOR_NODE_SHOWCOMMENT && ( WGlobals::checkCandy(50) );

	$vendorName = $this->getContent('name');

	$pageParams = WGlobals::get( 'vendorPageMain', '', 'global' );
	$pushRight = (  WPage::isRTL() ? ' col-md-push-7' : '' );

	?>
	<section>

	<div id="siteHeader" class="clearfix">

		<div id="siteHeading" class="row">


			<div id="siteImage" class="col-md-5<?php echo $pushRight; ?>">
				<div id="ImageBox">
				<?php echo $this->getContent('image'); ?>
				</div>
			</div>

			<div id="siteContent" class="col-md-7">

				<div class="page-header">
				<h2 class="title"><cite><?php echo $vendorName; ?></cite>
					<?php
						$editButton = $this->getValue('editButton');
						if ( !empty($editButton) ) :

					?>
					<div id="editable" class="pull-right">
						<?php
						$buttonO = WPage::newBluePrint( 'button' );
						$buttonO->type = 'infoLink';
						$buttonO->text = $editButton;
						$buttonO->icon = 'fa-edit';
						$buttonO->color = 'danger';
						$buttonO->link = $this->getValue('editButtonLink');
						$buttonO->popUpIs = true;
						$buttonO->popUpWidth = '90%';
						$buttonO->popUpHeight = '90%';
						echo WPage::renderBluePrint( 'button', $buttonO );
						?>
					</div>
					<?php endif; ?>
				</h2>
				</div>

				<?php
					if ( $wallet = $this->getContent('wallet') ) :
				?>
				<div id="vendorWallet"><?php echo $wallet; ?></div>
				<?php endif; ?>

				<?php

					$ratingStars = $this->getContent('rating');

					$nbReviews = $this->getContent('nbreviews');

					if ( $showRatings ) :

				?>

				<div id="vendorReview">

				<?php echo $ratingStars; ?>

				<?php echo $nbReviews; ?>

				</div>

				<?php endif; ?>


				<?php

					if ( PCATALOG_NODE_VENDORSHOWWEBSITE && $website = $this->getValue('website') ) :

				?>

				<div id="vendorWebsite"><a href="<?php echo $website; ?>" target="_blank"><?php echo $website; ?></a></div>

				<?php endif; ?>

				<?php
					if ( PCATALOG_NODE_VENDORSHOWADDRESS && $address = $this->getValue('address') ) :

				?>

				<div id="vendorAddress"><?php echo $address; ?></div>

				<?php endif; ?>

				<?php

					if ( PCATALOG_NODE_VENDORSHOWPHONE && $phone = $this->getValue('phone') ) :

				?>

				<div id="vendorPhone"><?php echo $phone; ?></div>

				<?php endif; ?>

				<?php

					if ( PCATALOG_NODE_VENDORSHOWQUESTION && $question = $this->getValue('question') ) :

				?>

				<div class="siteQuestion"><?php echo $question; ?></div>

				<?php endif; ?>



				<div id="siteItemlistInfo">

					<?php
					$showShare = $pageParams->showFavorite || $pageParams->showWatch || $pageParams->showViews || $pageParams->showLikeDislike;
					if ( $showShare ) : ?>
					<div id="siteShareButton" class="clearfix">
					<?php
					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '<div class="btn-group">';
					if ( $pageParams->showViews ) echo $this->getValue( 'linkViews' );
					if ( $pageParams->showLikeDislike ) echo $this->getValue( 'linkLikeDislike' );
					if ( $pageParams->showFavorite ) echo $this->getValue( 'linkFavorite' );
					if ( $pageParams->showWatch ) echo $this->getValue( 'linkWatch' );
					$shareWallButton = $this->getValue( 'linkShareWall' );
					if ( $pageParams->showShareWall && !empty($shareWallButton) ) echo $shareWallButton;
					if ( !empty($pageParams->showEmail) ) echo $this->getValue( 'linkEmail' );
					if ( !empty($pageParams->showPrint) ) echo $this->getValue( 'linkPrint' );
					if ( WPage::renderBluePrint( 'socialicons', 'container' ) ) echo '</div>';
					?>
					</div>
					<?php endif; ?>

					<?php
					$showShareOnline = $pageParams->showShareWall || $pageParams->showPrint || $pageParams->showLike || $pageParams->showTweet || $pageParams->showBuzz;
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
				</div>
			</div>
		</div>
	</div>
	</section>

	<?php
	$showBanner = WPref::load( 'PVENDORS_NODE_VENDORBANNER' );
	$banner = $this->getContent('banner');	if ( $showBanner && !empty($banner) ) :
	?>
	<div id="siteBanner">
		<?php echo $banner; ?>
	</div>
	<?php endif; ?>

	<jdoc:include type="modules" name="catalog-vendor-banner" style="no" />

	<section>
	{widget:area|name=middleCenter}
	</section>

	<div id="siteMap" class="hidden-xs clearfix">
		<section>
		{widget:area|name=map}
		</section>
	</div>

	<jdoc:include type="modules" name="catalog-vendor-map" style="no" />

	<?php if ( $searchBox ) :
		$search = $this->getContent( 'search' );
		$rss = $this->getValue( 'rss' );
		$data = WPage::newBluePrint( 'widgetbox' );
		$data->content = $search;
		if ( !empty($rss) ) $data->headerRightA[] = $rss;
	?>
	<div class="catalog-search clearfix">
	<section>
	<?php echo WPage::renderBluePrint( 'widgetbox', $data ); ?>
	</section>
	</div>
	<?php endif; ?>

	<?php if ( $carrousel = $this->getValue('carrousel') ) : ?>
	<div id="siteTop" class="hidden-xs clearfix">
		<section>
		<div id="siteCarrousel">
			<div id="siteCarrouselContent">
				<?php echo $carrousel; ?>
			</div>
		</div>
		</section>
	</div>
	<?php endif; ?>

	<jdoc:include type="modules" name="catalog-vendor-carrousel" style="no" />

	{widget:area|name=aboveItems}

	<?php if ( $showItems && $items = $this->getValue('items') ) :
	$showItemsTitle = PCATALOG_NODE_VDLYTITMTITLE;
	$data = WPage::newBluePrint( 'widgetbox' );
	$data->content = $items;
	if ( $showItemsTitle ) $data->title = $this->getValue( 'itemTitle' );
	$data->headerRightA[] = $this->getValue( 'itemsPicklist' );
	$itemsPagi = $this->getValue( 'itemsPagination' );
	if ( !empty($itemsPagi) ) {
		$data->headerCenterA[] = $itemsPagi;
		$data->bottomCenterA[] = $itemsPagi;
	}
	?>
	<div class="siteItems clearfix">
		<section>
		<?php echo WPage::renderBluePrint( 'widgetbox', $data ); ?>
		</section>
	</div>
	<?php endif; ?>

	<jdoc:include type="modules" name="catalog-vendor-items" style="no" />

	{widget:area|name=aboveCategories}

	<?php if ( $showCategory && $categories = $this->getValue('categories') ) :
	$showCategoryTitle = PCATALOG_NODE_VDLYTCTYTITLE;
	$data = WPage::newBluePrint( 'widgetbox' );
	$data->content = $categories;
	if ( $showCategoryTitle ) $data->title = $this->getValue( 'categoryTitle' );
	$cateogriesPagi = $this->getValue( 'categoriesPagination' );
	if ( !empty($cateogriesPagi) ) {
		$data->headerCenterA[] = $cateogriesPagi;
		$data->bottomCenterA[] = $cateogriesPagi;
	}
	?>
	<div class="siteSubCategories clearfix">
	<section>
		<?php echo WPage::renderBluePrint( 'widgetbox', $data ); ?>
	</section>
	</div>
	<?php endif; ?>

	<jdoc:include type="modules" name="catalog-vendor-categories" style="no" />

	{widget:area|name=aboveReviews}


	<div id="comment">

	<?php echo $this->getContent('comments'); ?>

	</div>


	{widget:area|name=bottom}


	<jdoc:include type="modules" name="catalog-vendor-bottom" style="no" />

</div>
</main>