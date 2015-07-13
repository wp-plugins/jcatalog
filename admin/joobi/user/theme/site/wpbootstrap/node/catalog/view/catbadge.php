<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

$elementParams = $this->getContent( 'elementParams' );

$id = $this->getContent( 'htmlID' );

$itemA = $this->getContent( 'ItemListA' );

if ( !empty($id) ) $idHTML = 'id="' . $id . '" ';

else $idHTML = '';

$htmlChild = $this->getContent( 'htmlChild' );

$subCatStyle = $this->getContent( 'subCategoryStyle' );

?>

<div <?php echo $idHTML; ?>class="<?php echo $this->getContent('containerClass'); ?> catalogCat categoryStandard<?php echo $this->getContent('classSuffix'); ?>">

<?php if ( !empty( $elementParams->borderShow ) ): ?>

<div class="panel panel-<?php echo $this->getContent( 'borderColor', 'default' ); ?>">

  <div class="panel-body">

<?php endif; ?>

	<?php if ( $imagePath = $this->getContent('thumbnailPath') ) : ?>

	<div class="siteImage vertiMrgn">

	<?php 
		$imageWidth = $this->getContent('imageWidth');

		$imageHeight = $this->getContent('imageHeight');

		if ( !empty( $imageWidth) && !empty($imageHeight) ) $imageSize = ' width="'.$imageWidth.'" height="'.$imageHeight.'"';

		else $imageSize = '';

		if ( $this->getContent('imageLinked') ) {

			echo '<a href="'.$this->getContent('pageLink').'"><img title="'.$this->getContent('name').'" border="0" src="'. $imagePath . '"'.$imageSize.' /></a>';

		} else {

			echo WPage::createPopUpLink( $this->getContent('imagePath'), '<img title="'.$this->getContent('name').'" border="0" src="'. $imagePath . '"'.$imageSize.' />', ($this->getContent('originWidth')*1.15), ($this->getContent('originHeight')*1.15) );

		}
		?>

	</div>

	<?php endif; ?>

	<h4 class="siteName vertiMrgn"><?php if ( $name = $this->getContent('linkName') ) : echo $name; endif; ?>

	<?php if ( $nbItems = $this->getContent('nbItems') )  echo ' <span class="badge">' . $nbItems . '</span>'; ?>
<?php if ( $nbItemsSub = $this->getContent('nbItemSub') )  echo ' <span class="badge">' . $nbItemsSub . '</span>'; ?>
<?php if ( $nbItemsSub = $this->getContent('nbItemSub') )  echo ' <span class="badge">' . $nbItemsSub . '</span>'; ?>

	</h4>

	<?php

	if ( $desc = $this->getContent('description') ) : echo '<div class="siteDesc vertiMrgn">' . $desc . '</div>'; endif;

	?>

		<?php if ( $itemA ) : ?>

		<div class="clearfix">

		<ul class="catItemList">

		<?php foreach( $itemA as $catItem ) :

			if ( !empty( $catItem->ItemThumbnailPath ) ) {

				?>

				<li style="list-style-type: none;">

				<h6 style="margin-left:-19px;" class="siteName"><img border="0" src="<?php echo $catItem->ItemThumbnailPath; ?>" width="'15" height="15" />

				<?php echo $catItem->linkName; ?></h6>

				</li>

				<?php

			} else {

				?>

				<li><h6 class="siteName"><?php echo $catItem->linkName; ?></h6></li>

				<?php

			}
			endforeach; ?>

		</ul>

		</div>

		<?php endif; ?>





<?php if ( !empty( $elementParams->borderShow ) ): ?>

	</div>

</div>

<?php endif; ?>

<?php if ( !empty($htmlChild) && $subCatStyle === 'ul-li' ) :

echo $htmlChild;

endif; ?>

</div>

<?php

if ( !empty($htmlChild) && $subCatStyle === 'popOver' ) :

$idHTMLSub = $idHTML = 'id="' . $id . '_sub" ';

?>

<div <?php echo $idHTMLSub; ?> class="popoverCat">

<?php echo $htmlChild; ?>

</div>

<?php endif; ?>