<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<div id="checkOutPage">
	<div id="processTail" class="clearfix">
		<?php echo $this->getValue( 'processtail' ); ?>
	</div>

	<div id="checkOutList">
		<?php echo $this->getContent( 'checkoutlist' ); ?>
	</div>

	<div id="couponTotalBox" class="row clearfix">
		<div class="col-md-7 couponBoxUpdate">

			<?php if ( $taxIDText = $this->getValue( 'taxIDText' ) ) :
				$updateCartButton = $this->getContent( 'updatecartbutton' );
			?>
				<div class="VATnbTitle">
					<label for="VATnbAction"> <?php echo $taxIDText; ?> </label>
				</div>
				<?php if ( $taxIDValid = $this->getValue( 'taxIDValid' ) ) : ?>
 					<div class="VATnbValid">
					<p class="text-success"><?php echo $taxIDValid; ?></p>
					</div>
				<?php endif; ?>
				<div class="input-group VATnbArea">
					<div>
						<input type="text" id="VATnbAction" name="vatnumber" value="<?php echo $this->getValue( 'taxid' ); ?>" class="form-control VATnbAdd" placeholder="<?php echo $this->getValue( 'taxIDPlaceholder' ); ?>">
 					</div>
 					<?php if ( $updateCartButton ) : ?>
 					<div class="input-group-btn">
					<?php echo $updateCartButton; ?>
					</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>


			<?php if ( $wallet = $this->getValue( 'wallet' ) ) : ?>
				<div class="basketWallet">
					<strong> <?php echo $wallet; ?> </strong>
				</div>
			<?php endif; ?>

			<?php if ( $this->getValue( 'showcoupon' ) ) :
				$couponButton = $this->getContent( $this->getValue( 'couponbutton' ) );
				$updateCartButton = $this->getContent( 'updatecartbutton' );
			?>
				<div class="couponTitle">
					<label for="couponAction"> <?php echo $this->getTitle( $this->getValue( 'coupontext' ) ); ?> </label>
				</div>
				<div class="input-group couponArea">
					<?php echo $this->getContent( 'coupon' ); ?>
					<?php if ( $couponButton ) : ?>
					<div class="input-group-btn">
					<?php echo $couponButton ?>
 					</div>
 					<?php endif; ?>
 					<?php if ( $updateCartButton ) : ?>
 					<div class="input-group-btn">
					<?php echo $updateCartButton; ?>
					</div>
					<?php endif; ?>
				</div>

				<?php if ( $couponDetails = $this->getContent( 'coupondetails' ) ) : ?>
					<div>
						<?php echo $couponDetails; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="col-md-5 checkOutTotal">
			<div class="checkOutCont">
				<?php if ( $this->getValue( 'showSubTotal' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getTitle( 'subtotal' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $this->getValue( 'subtotal' ); ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $itemDiscount = $this->getValue( 'itemdiscount' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getTitle( 'itemdiscount' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $itemDiscount; ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $couponDiscount = $this->getValue( 'couponDiscount' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getTitle( 'coupondiscount' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $couponDiscount; ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $shippingRate = $this->getValue( 'shippingRate' ) ) : ?>

				<?php if ( $this->getValue( 'showSubTotal' ) || $itemDiscount || $couponDiscount ) : ?>
					<div class="row">
						<div class="col-xs-6">&nbsp;</div>
						<div class="col-xs-6"><div class="underlineSpace">&nbsp;</div></div>
					</div>
				<?php endif; ?>

					<div class="row">
						<div class="col-xs-6"><?php echo $this->getTitle( 'shippingrate' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $shippingRate; ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $this->getValue( 'showSubTotal' ) ) : ?>
					<div class="row">
						<div class="col-xs-6">&nbsp;</div>
						<div class="col-xs-6"><div class="underlineSpace">&nbsp;</div></div>
					</div>
				<?php endif; ?>

				<?php if ( $shippingTax = $this->getValue( 'shippingTax' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getTitle( 'shippingtax' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo  $this->getValue( 'taxPlus' ) . ' ' .$shippingTax; ?></div>
					</div>
				<?php endif; ?>

				<?php if ( $paymentFeeTotal = $this->getValue( 'paymentFeeTotal' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getValue( 'paymentFeeText' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $paymentFeeTotal; ?></div>
					</div>
					<div class="row">
						<div class="col-xs-6">&nbsp;</div>
						<div class="col-xs-6"><div class="underlineSpace">&nbsp;</div></div>
					</div>
				<?php endif; ?>

				<?php if ( ($totalTax = $this->getValue( 'taxTotal' )) || WPref::load( 'PCATALOG_NODE_SHOWZEROTAX' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getValue( 'taxText' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo  $this->getValue( 'taxPlus' ) . ' ' . $totalTax; ?></div>
					</div>
					<div class="row">
						<div class="col-xs-6">&nbsp;</div>
						<div class="col-xs-6"><div class="underlineSpace">&nbsp;</div></div>
					</div>
				<?php endif; ?>

				<div class="row">
					<div class="col-xs-6 boldText"><?php echo $this->getTitle( $this->getValue( 'totalTitle' ) ); ?><!--<div class="centerColon">:</div>--></div>
					<div class="col-xs-6 alignRight boldText"><?php echo $this->getValue( 'total' ); ?></div>
				</div>

				<?php if ( $this->getValue( 'bookingIsUsed' ) ) : ?>
					<div class="row">
						<div class="col-xs-6"><?php echo $this->getTitle( 'bookingfee' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $this->getValue( 'bookingfee' ); ?></div>
					</div>

					<div class="row">
						<div class="col-xs-6">&nbsp;</div>
						<div class="col-xs-6"><div class="underlineSpace">&nbsp;</div></div>
					</div>

					<div class="row">
						<div class="col-xs-6 boldText"><?php echo $this->getTitle( 'totaltopay' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight boldText"><?php echo $this->getValue( 'totalpricetopay' ); ?></div>
					</div>
				<?php endif; ?>

			</div>

			<?php
			$currencyDropdown = $this->getContent( 'storecurrencies' );
			if ( !empty($currencyDropdown) && '<div class="col-sm-10"></div>' != $currencyDropdown ) :
			?>
				<div>
					<strong> <?php echo $this->getTitle( 'storecurrencies' ); ?> </strong>
					<br/>
					<?php echo $currencyDropdown; ?>
				</div>
			<?php endif; ?>

			<?php if ( $this->getValue( 'showemailfield' ) ) : ?>
				<div id="checkOutEmail">
					<strong> <?php echo $this->getTitle( 'emailaddress' ); ?> </strong><small><span class="requieredText">( <?php echo $this->getContent( 'emailRequired' ); ?> )</span></small>
					<br/>
					<?php echo $this->getContent( 'emailaddress' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="clr"></div>