<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Email_Email_form_view extends Output_Forms_class {
	function prepareView(){



		
		$type=$this->getValue( 'type' );



		if( $type !=4){

			$this->removeElements( array( 'email_mailer_form_fieldset_smtp' ));

		}


		if( $type !=3){

			$this->removeElements( array( 'email_mailer_form_fieldset_send_mail' ));

		}


		if( $type==4 || $type > 100){

			$this->removeElements( array( 'email_mailer_form_fieldset_dkim' ));

		}






		if( $type > 100){

			$this->removeElements( array( 'email_mailer_form_fieldset_email_settings', 'email_mailer_form_fieldset_frequency_limitation_settings', 'email_mailer_form_fieldset_max_emails_limitation_settings' ));

		}


		return true;



	}}