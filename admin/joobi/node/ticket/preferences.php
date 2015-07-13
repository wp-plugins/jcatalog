<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_ticket_preferences {
public $allowfiles=1;
public $autoreply=1;
public $closedelay=15;
public $editclose=1;
public $editor='';
public $editor_fe='nicedit.basic';
public $emailallassigned=0;
public $emailnewaccount=1;
public $followupticket=0;
public $getavatar=5;
public $informoderator='';
public $infromoderator=0;
public $latereplydelay=48;
public $latereplynotify=0;
public $noregistered=0;
public $notifyassignedcustomer=0;
public $notifyclose=1;
public $notifymoderator=0;
public $queueposition=1;
public $signaturemoderator=1;
public $siteintegration=0;
public $spambadwords='anal,anus,arse,ass,ballsack,balls,bastard,bitch,biatch,bloody,blowjob,blow job,bollock,bollok,boner,boob,bugger,bum,butt,buttplug,clitoris,cock,coon,crap,cunt,damn,dick,dildo,dyke,fag,feck,fellate,fellatio,felching,fuck,f u c k,fudgepacker,fudge packer,flange,Goddamn,God damn,hell,homo,jerk,jizz,knobend,knob end,labia,lmao,lmfao,muff,nigger,nigga,omg,penis,piss,poop,prick,pube,pussy,queer,scrotum,sex,shit,s hit,sh1t,slut,smegma,spunk,tit,tosser,turd,twat,vagina,wank,whore,wtf';
public $spamblock=1;
public $spamnotify=1;
public $spamwords='pharmacy,free shipping,no waiting,mefenamic,ponstel,sumycin,pharmacies,condom,4U,accept credit cards,additional income,no age restrictions,viagra,more internet traffic,money making,meet singles,xxx,x rated';
public $status='';
public $supportlevel=3;
public $thread=0;
public $ticketbyemail='';
public $timing=0;
public $tkattachformats='jpg,jpeg,gif,png,zip,tar,rar,doc,docx,txt,rtf,odt,pdf,log,7z,xls,odf,mov,ogv,ogg,flv,ogv,ogg,wmv,mp4,mpg,mpeg';
public $tkattachmaxsize=1000;
public $tkboth=1;
public $tkcomment='';
public $tkdelay=20;
public $tkebounce='';
public $tkemailassign=1;
public $tkemailconf=1;
public $tkemailcopy=0;
public $tkemailreply=1;
public $tkesender='';
public $tkesenderemail='';
public $tkfollowup=0;
public $tkfrequency=2;
public $tkip='';
public $tkipdisplay='';
public $tklink=1;
public $tkmailing=1;
public $tknamekey='';
public $tkonstatcust='';
public $tkonstatus='';
public $tkprivate=1;
public $tkprojcomment='';
public $tkproject=0;
public $tkprojectassign=0;
public $tkratecolor='yellow';
public $tkratevisible='';
public $tkratinguse='';
public $tkrreply='';
public $tkrt=1;
public $tkrtfree=120;
public $tkrtwith=24;
public $tkrtwithout=72;
public $tksize=6;
public $tktitle='';
public $tktrans=0;
public $tktype=0;
public $tkusecomment='';
public $tkuseproject='';
public $tkusetype=0;
public $userchooseprivacy=1;
public $warndelay=5;
}
class Role_ticket_preferences {
public $allowfiles='supportmanager';
public $autoreply='supportmanager';
public $closedelay='supportmanager';
public $editclose='supportmanager';
public $editor='agent';
public $editor_fe='supportmanager';
public $emailallassigned='moderator';
public $emailnewaccount='admin';
public $followupticket='admin';
public $getavatar='supportmanager';
public $informoderator='admin';
public $infromoderator='manager';
public $latereplydelay='supportmanager';
public $latereplynotify='supportmanager';
public $noregistered='supportmanager';
public $notifyassignedcustomer='supportmanager';
public $notifyclose='supportmanager';
public $notifymoderator='admin';
public $queueposition='supportmanager';
public $signaturemoderator='supportmanager';
public $siteintegration='supportmanager';
public $spambadwords='supportmanager';
public $spamblock='supportmanager';
public $spamnotify='supportmanager';
public $spamwords='supportmanager';
public $status='manager';
public $supportlevel='supportmanager';
public $thread='admin';
public $ticketbyemail='admin';
public $timing='supportmanager';
public $tkattachformats='supportmanager';
public $tkattachmaxsize='supportmanager';
public $tkboth='supportmanager';
public $tkcomment='manager';
public $tkdelay='supportmanager';
public $tkebounce='manager';
public $tkemailassign='supportmanager';
public $tkemailconf='supportmanager';
public $tkemailcopy='allusers';
public $tkemailreply='sadmin';
public $tkesender='manager';
public $tkesenderemail='manager';
public $tkfollowup='allusers';
public $tkfrequency='sadmin';
public $tkip='sadmin';
public $tkipdisplay='sadmin';
public $tklink='allusers';
public $tkmailing='allusers';
public $tknamekey='sadmin';
public $tkonstatcust='manager';
public $tkonstatus='manager';
public $tkprivate='supportmanager';
public $tkprojcomment='sadmin';
public $tkproject='sadmin';
public $tkprojectassign='sadmin';
public $tkratecolor='sadmin';
public $tkratevisible='sadmin';
public $tkratinguse='sadmin';
public $tkrreply='sadmin';
public $tkrt='sadmin';
public $tkrtfree='sadmin';
public $tkrtwith='sadmin';
public $tkrtwithout='sadmin';
public $tksize='sadmin';
public $tktitle='sadmin';
public $tktrans='sadmin';
public $tktype='sadmin';
public $tkusecomment='sadmin';
public $tkuseproject='sadmin';
public $tkusetype='manager';
public $userchooseprivacy='supportmanager';
public $warndelay='sadmin';
}