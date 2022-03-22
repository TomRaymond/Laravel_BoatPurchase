<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PurchaseBoatTest extends DuskTestCase
{
    public function get_class_short_name()
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
    
    public function test_can_navigate_to_checkout_from_homepage()
    {
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Introducing the all-new Boat')
                    ->press('Preorder Now')
                    ->assertPathIs('/checkout');
        });
    }
    
    public function test_can_purchase_boat()
    {
        $this->browse(function (Browser $browser) {
            // Navigate to checkout page and wait for card payment iframe to load
            $browser->visit('/checkout')
                    ->assertSee('Enter your credit card information')                    
                    ->assertPathIs('/checkout')
                    ->waitFor('#card-element iframe')
                    ->screenshot('test_can_purchase_boat/loaded_checkout_page');
            
            // get name of stripes injected payment iframe
            $iframe_name =  $browser->script('return $("#card-element iframe").attr("name");')[0];
            $browser->type('email', 'bobhampton388@hotmail.co.uk');
            // within the stripe payment iframe, input test card information
            $browser->withinFrame('iframe[name='.$iframe_name.']', function($browser){
                $browser->keys('input[placeholder="Card number"]', '4242 4242 4242 4242')
                    ->keys('input[placeholder="MM / YY"]', '0130')
                    ->pause(100) // allow time for zip field to be displayed after entering card number
                    ->keys('input[placeholder="CVC"]', '123')
                    ->keys('input[placeholder="ZIP"]', '12345')
                    ->screenshot('test_can_purchase_boat/checkout_input_card_details');
            });

            // Hit submit and confirm we reach the confirmation page
            $browser->press('button[type="submit"')
                    ->pause(5000) // wait for stripe to authenticate transaction
                    ->waitForText('Thank you for your boat purchase')
                    ->assertSee('Thank you for your boat purchase')   
                    ->screenshot('test_can_purchase_boat/checkout_transaction_complete');
        });
    }

    public function test_cannot_purchase_boat_insufficient_funds()
    {
        $this->browse(function (Browser $browser) {
            // Navigate to checkout page and wait for card payment iframe to load
            $browser->visit('/checkout')
                    ->assertSee('Enter your credit card information')                    
                    ->assertPathIs('/checkout')
                    ->waitFor('#card-element iframe')
                    ->screenshot('test_cannot_purchase_boat_insufficient_funds/loaded_checkout_page');
            
            // get name of stripes injected payment iframe
            $iframe_name =  $browser->script('return $("#card-element iframe").attr("name");')[0];
            $browser->type('email', 'bobhampton388@hotmail.co.uk');
            // within the stripe payment iframe, input test card information
            $browser->withinFrame('iframe[name='.$iframe_name.']', function($browser){
                $browser->keys('input[placeholder="Card number"]', '4000 0000 0000 9995')
                    ->keys('input[placeholder="MM / YY"]', '0130')
                    ->pause(100) // allow time for zip field to be displayed after entering card number
                    ->keys('input[placeholder="CVC"]', '123')
                    ->keys('input[placeholder="ZIP"]', '12345')
                    ->screenshot('test_cannot_purchase_boat_insufficient_funds/checkout_input_card_details');
            });

            // Hit submit and confirm we reach the confirmation page
            $browser->press('button[type="submit"')
                    ->pause(5000) // wait for stripe to authenticate transaction
                    ->assertSee('Your card has insufficient funds.')
                    ->screenshot('test_cannot_purchase_boat_insufficient_funds/checkout_transaction_insufficient_funds');
        });
    }
}
