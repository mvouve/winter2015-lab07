<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Orders
 *
 * @author Marc
 */
class Orders extends CI_Model{
    protected $xml = null;
    protected $order_name = null;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function all()
    {
        $this->load->helper('directory');
        
        $files = directory_map(DATAPATH);
        
        foreach($files as $file)
        {
            $str = '.xml';
            
            if(substr_compare($file, $str, strlen($file) - strlen($str))=== 0)
            {
                try
                {
                    $xml = simplexml_load_file(DATAPATH . $file);
                    if($xml->getName() === 'order')
                    {
                        $order_file = $file;
                        // remove XML from file name.
                        $order_file = substr($order_file, 0, strlen($order_file) - 4);
                        
                        $orders[] = $this->get($order_file);
                    }
                } catch (Exception $ex) {
                    print($ex);
                }
            }
        }
        
        return $orders;
    }
    
    public function get($order_str)
    {
        $this->xml = simplexml_load_file(DATAPATH.$order_str.'.xml');
        
        $this->order_name = $order_str;
        
        return clone $this;
    }
    
    public function get_order_name()
    {
        return $this->order_name;
    }
    
    public function get_customer_name()
    {
        return (string)$this->xml->customer[0];
    }
    
    public function get_order_type()
    {
        return (string) $this->xml['type'];
    }
    
    public function get_burgers()
    {
        $burgers = array();
        
        foreach($this->xml->burger as $xml_burger);
            $burgers[] = $this->burgers->get($xml_burger);
            
        return $burgers;
    }
    
    public function get_special()
    {
        if(isset($this->xml->special))
            return (string)$this->xml->special;
        else
            return '';
    }
    
    public function get_total()
    {
        $total = 0;
        $burgers = $this->get_burgers();
        foreach($burgers as $burger)
        {
            $total += $burger->get_total();
        }
        
        return $total;
    }
}
