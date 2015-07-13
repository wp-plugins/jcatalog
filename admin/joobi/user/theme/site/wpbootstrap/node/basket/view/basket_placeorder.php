<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<div id="checkOutPage">

	<div id="processTail" class="clearfix">
		<?php echo $this->getValue( 'processtail' ); ?>
	</div>

	<div id="processAddress" class="row clearfix">
		<?php if ( $billingAddress = $this->getValue( 'billingAddressContent' ) ) : ?>
		<div class="col-xs-6 alignLeft">
			<h3 class="panel-title"><?php echo $this->getValue( 'billingAddressTitle' ); ?></h3>
			<?php echo $billingAddress; ?>
		</div>
		<?php endif; ?>

		<?php if ( $shippingAddress = $this->getValue( 'shippingAddressContent' ) ) : ?>
		<div class="col-xs-6 alignLeft">
			<h3 class="panel-title"><?php echo $this->getValue( 'shippingAddressTitle' ); ?></h3>
			<?php echo $shippingAddress; ?>
		</div>
		<?php endif; ?>

	</div>

	<?php if ( $creditCard = $this->getValue( 'creditCardContent' ) ) : ?>
	<div id="processCreditCard" class="clearfix">
		<h3 class="panel-title"><?php echo $this->getValue( 'creditCardTitle' ); ?></h3>
		<?php echo $creditCard; ?>
	</div>
	<?php endif; ?>

	<div id="checkOutList" class="clearfix">
		<?php echo $this->getContent( 'checkoutlist' ); ?>
	</div>

	<div id="couponTotalBox" class="row clearfix">

		<div id="leftTotalBox" class="col-md-6">
			<?php if ( $this->getValue( 'showcoupon' ) ) : ?>
			<div id="couponBoxUpdate" class="clearfix">
				<?php if ( $couponDetails = $this->getContent( 'coupondetails' ) ) : ?>
					<div>
						<strong> <?php echo $this->getTitle( $this->getValue( 'coupontext' ) ); ?> </strong>
						<br/>
						<?php echo $couponDetails; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ( WPref::load( 'PBASKET_NODE_SHOWNOTE' ) ) : ?>
			<div id="noteBox" class="clearfix">
				<textarea class="form-control" rows="3" name="trucs[x][comment]" id="x_note_comment" placeholder="<?php echo $this->getValue( 'notePlaceHolder' ); ?>"></textarea>
			</div>
			<?php endif; ?>

			<?php if ( WPref::load( 'PBASKET_NODE_ALLOWGIFT' ) ) : ?>
			<div id="giftBox" class="clearfix">
				<div id="giftPanel" class="panel panel-info">
					<div class="panel-heading"><?php echo $this->getValue( 'giftTitle' ); ?></div>
						<div class="panel-body">
						<div class="form-group">
						<input class="form-control" name="trucs[x][giftrecname]" id="x_note_giftrecname" size="50" placeholder="<?php echo $this->getValue( 'giftrecname' ); ?>"/>
						</div>
						<div class="form-group">
						<input class="form-control" name="trucs[x][giftrecemail]" id="x_note_giftrecemail" size="50" placeholder="<?php echo $this->getValue( 'giftrecemail' ); ?>"/>
						</div>
						</div>
				</div>

			</div>
			<?php endif; ?>
		</div>

		<div class="col-md-6 checkOutTotal">
			<div id="checkOutCont" class="clearfix">
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

				<?php if ( $couponDiscount = $this->getValue( 'coupondiscount' ) ) : ?>
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
						<div class="col-xs-6"><?php echo $this->getTitle( 'shippingrate' ) . ' <span class="carrierName">' . $this->getValue( 'shippingCarrier' ); ?> </span><!--<div class="centerColon">:</div>--></div>
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
						<div class="col-xs-6 alignRight"><?php echo  $this->getValue( 'taxPlus' ) . ' ' .$totalTax; ?></div>
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
						<div class="col-xs-6"><?php echo $this->getTitle( 'totaltopay' ); ?><!--<div class="centerColon">:</div>--></div>
						<div class="col-xs-6 alignRight"><?php echo $this->getValue( 'totalpricetopay' ); ?></div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $currencyMessage = $this->getValue( 'currencyMessage' ) ) : ?>
				<div class="clearfix">
					<span><?php echo $currencyMessage; ?></span>
				</div>
			<?php endif; ?>

			<?php
			$currencyDropdown = $this->getContent( 'storecurrencies' );
			if ( !empty($currencyDropdown) && '<div class="col-sm-10"></div>' != $currencyDropdown ) :
			?>
				<div class="currenciesChoice clearfix">
					<strong> <?php echo $this->getTitle( 'storecurrencies' ); ?> </strong>
					<br/>
					<span><?php echo $currencyDropdown; ?></span>
				</div>
			<?php endif; ?>

			<?php if ( $termsDropdown = $this->getContent( 'terms' ) ) : ?>
				<div class="termsConditions clearfix">
					<strong> <?php echo $this->getTitle( 'terms' ); ?> </strong>
					<br/>
					<span><?php echo $termsDropdown; ?></span>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>