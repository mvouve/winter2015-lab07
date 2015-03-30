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
            $ordr->url      = 'welcome/order/' . $order->get_order_name();
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
        $this->load->model('orders');
        $this->load->model('burgers');
        $this->load->model('menu');
	// Build a receipt for the chosen order
	$order = $this->orders->get($filename);
        $this->data['customer'] = $order->get_customer_name(); 
        $burgers = $this->orders->get_burgers();
        $this->data['burgers'] = array();
        
        $num = 1;
        foreach($burgers as $burger)
        {
            $burger_ = new stdClass();
            
            $burger_->patty = $burger->get_patty();
            $burger_->id = $num++;
            $burger_->cheeses = $burger->get_cheeses();
            $burger_->toppings = array();
            
            foreach($burger->get_toppings() as $t)
            {
                $burger_->toppings[] = $t;
            }
            
            $burger_->sauces = array();
            
            foreach($burger->get_sauces() as $t)
            {
                $burger_->sauces[] = $t;
            }
            $burger_->price = '$' . number_format($burger->get_total(), 2);
            
            $this->data['burgers'][] = $burger_;
        }
        
        
        
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }
    

}
