<?php 

* @link joobi.co
* @license GNU GPLv3 */




$elementParams = $this->getContent( 'elementParams' );

$id = $this->getContent( 'htmlID' );

$itemA = $this->getContent( 'ItemListA' );

if ( !empty($id) ) $idHTML = 'id="' . $id . '" ';

else $idHTML = '';

$depth = $this->getContent( 'depth' );	
$level = $this->getContent( 'level' );	


$htmlChild = $this->getContent( 'htmlChild' );

?>





    

    

<?php if ( !empty( $elementParams->borderShow ) ): ?>

<div class="panel panel-<?php echo $this->getContent( 'borderColor', 'default' ); ?>">

  <div class="panel-body">

<?php endif; ?>

	<?php 

	    
	    if ( $name = $this->getContent('linkName') ) : echo $name; endif;

	    

	    
	    if( !empty($htmlChild) ) : echo '<span>+</span>'; endif;

	?>

      

	<?php

	    if ( $desc = $this->getContent('description') ) : echo '<div class="siteDesc">' . $desc . '</div>'; endif;

	?>

<?php if ( !empty( $elementParams->borderShow ) ): ?>

	</div>

</div>

<?php endif; ?>


