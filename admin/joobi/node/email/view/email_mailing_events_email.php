<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Email_Email_mailing_events_email_view extends Output_Forms_class {
function prepareView(){



	$receivertype=$this->getValue( 'receivertype' );

	

	switch ( $receivertype){

		case 1:

			$this->removeElements( array( 'events_email_email' ));

			break;

		case 2:

			$this->removeElements( array( 'events_email_email' ));

			break;

		case 3:

			$this->removeElements( array( 'events_email_email' ));

			break;

		default:

			$this->removeElements( array( 'events_email_email' ));

			break;

		}
	

	

	return true;



}}