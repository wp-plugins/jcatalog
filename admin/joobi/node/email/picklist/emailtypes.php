<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Email_Emailtypes_picklist extends WPicklist {

function create(){





    $model=WModel::get( 'email.type' );

    $model->makeLJ( 'email.typetrans' );

    $model->whereLanguage( 1 );

    
    $model->select( 'namekey', 0 );

    $model->select( 'mgtypeid', 0 );

    $model->select( 'name', 1 );

    $model->whereE( 'publish', 1 , 0 );



    $task=WGlobals::get('task');



    if($this->onlyOneValue() && $task=='show')

    {



        $typeid=WGlobals::get('typeid');

        $eid=WGlobals::getEID();



        $model->whereE( 'mgtypeid', $typeid , 0 );



        $results=$model->load( 'ol' );



        if( empty( $results )) return '';





        foreach( $results as $result )

        {

            $this->addElement( $result->mgtypeid , $result->name );

        }






    }

    else

    {

         $results=$model->load( 'ol');



         if(!empty($results))

         {

	      $allPossibleTypeA=$results;



	      
	      foreach( $allPossibleTypeA as $type )

	      {

		  $this->addElement( $type->mgtypeid , $type->name );

	      }
         }



    }


 return true;



}
}