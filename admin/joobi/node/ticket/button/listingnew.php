<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_CoreListingnew_button extends WButtons_external {

function create(){



    $uid=WUser::get('uid');



    $ticketM=WModel::get('ticket');        			

    $ticketM->makeLJ('project','pjid','pjid',0,1);            	
    $ticketM->makeLJ('project.members','pjid','pjid',0,2);        
    $ticketM->whereOn('uid','=',$uid,2);                	
    $ticketM->select('tkid',0,null,'count');            	


    $ticketM->whereE('authoruid',$uid,0,null,1,0,0);		
    $ticketM->whereE('uid',$uid,2,null,0,1,1);           	 
    $ticketM->whereE('publish',1,1);                		
    $ticketM->whereE('replies',0,0);               		 
    $ticketM->whereE('status',20,0);				

    if (!PTICKET_NODE_TKUSECOMMENT){                    		
        $ticketM->where('comment','<=',1,0);            	
    }
    $newTickets=$ticketM->load('lr');



    
    
    $this->setAction('listingnew');

    $this->setIcon('after');

    $this->setTitle(WText::t('1243948338KVSR').'('.$newTickets.')');



    return true;

}}