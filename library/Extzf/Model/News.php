<?php

namespace Extzf\Model;

/** 
 * @Entity @Table(name="news") 
 */
class News
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public $id;
    
    
    /** @Column(length=255) */
    public $title;
    
    
    /** @Column(type="text") */
    public $text;
    
    
    /** @Column(type="datetime") */
    public $timestamp;
    
    
    /** @Column(type="integer") */
    public $authorUserId;
}