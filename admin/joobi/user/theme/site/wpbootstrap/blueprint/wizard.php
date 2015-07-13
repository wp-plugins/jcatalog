<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

















class WRender_Wizard_class extends Theme_Render_class {













  	public function render($wizardO) {



  		if ( !IS_ADMIN && !WPref::load( 'PLIBRARY_NODE_WIZARDFE' ) ) return '';

  		if ( IS_ADMIN && !WPref::load( 'PLIBRARY_NODE_WIZARD' )) return '';



		if ( !empty($wizardO->wname) ) {



			$wizard_color = $this->value( 'wizard.color' );



			$description = nl2br( $wizardO->wdescription );



			
			
			if ( strpos( $description, '{widget:' ) ) {

				$tag = WClass::get('output.process');

				$tag->replaceTags( $description, WUser::get('data') );

			}


			$html = '<fieldset>';

			$html .= '';

			$html .= '<legend><i class="fa fa-magic';

			if ( $wizard_color ) $html .= ' text-warning';

			$html .= '"></i>' . $wizardO->wname . '</legend>';

			$html .= $description;

			$html .= '</fieldset>';





			if ( !empty( $wizardO->showWizard ) ) $style = 'style="display:block;"';

			else $style = 'style="display:none;"';



			return '<div id="viewWizard" class="clearfix" '.$style.'>' . $html . '</div>';



		}


		return '';



  	}


}