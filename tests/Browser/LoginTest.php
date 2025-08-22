<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Helper\UrlHelper;


class LoginTest extends DuskTestCase
{
    public function testLoginAdminFail():void
    {
        $this->browse(function(Browser $browser) {

            $browser->visit(UrlHelper::admin("login"))
                    ->assertSee("登入")
                    ->assertSee("提交");

            $browser->type("username", "abc")
                    ->type("password","123")
                    ->press('提交')
                    ->assertSee("User not found");
        });
    }

    public function testLoginAdminSuccess():void
    {
        $this->browse(function(Browser $browser, Browser $browser2) {

            $browser->visit(UrlHelper::admin("login"))
                    ->assertSee("登入")
                    ->assertSee("提交");

            $browser->type("username", "demo")
                    ->type("password","demo")
                    ->press('提交')
                    ->assertPathIs("/".UrlHelper::adminUri()."/dashboard");




        });
    }

    public function testRedirectDashboardAfterLogin():void
    {
        $this->browse(function(Browser $browser, Browser $browser2) {

            $browser->visit(UrlHelper::admin("login"))
                    ->pause(1000)
                    ->assertPathIs("/".UrlHelper::adminUri()."/dashboard");

            $browser->visit(UrlHelper::admin())
                    ->pause(1000)
                    ->assertPathIs("/".UrlHelper::adminUri()."/dashboard");

        });
    }

}
