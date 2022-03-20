<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PurchastBoatTest extends DuskTestCase
{
    public function test_can_navigate_to_checkout_from_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Introducing the all-new Boat')
                    ->press('Buy Now')
                    ->assertPathIs('/checkout');
        });
    }

    public function test_can_purchase_boat()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checkout')
                    ->assertSee('Enter your credit card information')                    
                    ->assertPathIs('/checkout')
                    ->waitFor('#card-element iframe')
                    ->screenshot('loaded_checkout_page');
            
            $iframe_name =  $browser->script('return $("#card-element iframe").attr("name");')[0];
            $browser->type('email', 'bobhampton388@hotmail.co.uk');
            $browser->withinFrame('iframe[name='.$iframe_name.']', function($browser){
                $browser->pause(3000);
                $browser->keys('input[placeholder="Card number"]', '4242 4242 4242 4242')
                    ->keys('input[placeholder="MM / YY"]', '0125')
                    ->keys('input[placeholder="CVC"]', '123')
                    ->screenshot('checkout_input_card_details');
            });
        });
    }
}
