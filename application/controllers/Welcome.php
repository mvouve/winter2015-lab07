<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
        $this->load->model('orders');
	// Build a list of orders
        $orders = $this->orders->all();
        
        $this->data['orders'] = array();
        
        foreach($orders as $order)
        {
            $ordr = new stdclass();
            $ordr->order    = $order->get_order_name();
            $ordr->url      = 'welcom/order/' . $order->get_order_name();
            $ordr->customer = $order->get_customer_name(); 
            
            $this->data['orders'][] = $ordr;
        }
        
	
	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
	
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }
    

}
