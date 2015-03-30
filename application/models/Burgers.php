<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Burgers
 *
 * @author Marc
 */
class Burgers extends CI_Model{
    
    public function get($xml_burger)
    {
        $this->xml = $xml_burger;
        
        return clone $this;
    }
    
    public function get_patty()
    {
        $this->load->model('menu');
        
        $patty_code = (string) $this->xml->patty['type'];
        $patty = $this->menu->getPatty($patty_code);
        
        return $patty->name;
    }
    
    public function get_cheeses()
    {
        
        if (isset($this->xml->cheeses['top']))
        {
            $cheese['top'] = $this->xml->cheeses['top'];
        }
        else
            $cheese['top'] = '';
        if (isset($this->xml->cheeses['bottom']))
        {
            $cheese['bottom'] = $this->xml->cheeses['bottom'];
        }
        else
            $cheese['bottom'] = '';
        
        return $cheese;
    }
    
    public function get_toppings()
    {
        $toppings = array();
        
        foreach($this->xml->topping as $topping)
        {
            $topping_code = (string) $topping['type'];
            $topping = $this->menu->getTopping($topping_code);
            $toppings[] = $topping->name;
        }
        
        return $toppings;
    }
    
    public function get_sauces()
    {
        $sauces = array();
        
        foreach($this->xml->sauce as $sauce)
        {
            $sauce_code = (string) $sauce['type'];
            $sauce = $this->menu->getSauce($sauce_code);
            $sauces[] = $sauce->name;
        }
        return $sauces;
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
        foreach($this->xml->children() as $child)
        {
            if($child->getName() === 'patty')
            {
                $code = (string) $child['type'];
                $menu_item = $this->menu->getPatty($code);
                $total += $menu_item->price;
            }
            if($child->getName() === 'cheeses')
            {
                if((string) $child['top'] != null)
                    $code = (string) $child['top'];
                else
                    $code = (string) $child['bottom'];
                $menu_item = $this->menu->getCheese($code);
                $total += $menu_item->price;
            }
            if($child->getName() === 'topping')
            {
                $code = (string) $child['type'];
                $menu_item = $this->menu->getTopping($code);
                $total += $menu_item->price;
            }
            if($child->getName() === 'sauce')
            {
                $code = (string) $child['type'];
                $menu_item = $this->menu->getSauce($code);
                $total += $menu_item->price;
            }
        }
        return $total;
    }
}
