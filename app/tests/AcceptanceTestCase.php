<?php

use Mockery as m;

abstract class AcceptanceTestCase extends TestCase {

    /**
     * Closes mockery expectations
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /**
     * Feeds the crawler with the visited page
     * @param  string $url Url
     * @param  string $method HTTP Verb. IE: "GET", "POST", "DELETE", etc.
     * @return void
     */
    protected function i_visit_url($url, $method = 'GET')
    {
        $this->crawler = $this->client->request($method, $url);
    }

    /**
     * Simulates a click in a link. It will basically get the "href" and the
     * "method" attributes of the element found with the $linkSelector and then
     * call i_visit_url() with the url and HTTP verb found.
     * @param  string $linkSelector DOM Element selector
     * @return void
     */
    protected function i_click_the_link($linkSelector)
    {
        $link = $this->crawler->filter($linkSelector)
            ->first();

        $url = $link->attr('href');
        $method = strtoupper($link->attr('method') ?: 'get');

        $this->i_visit_url($url, $method);
    }

    /**
     * Submit the given form with the given input
     * @param  string $formSelector  Form selector
     * @param  array $input Form field input array
     * @return void
     */
    protected function i_submit_form_with($formSelector, $input)
    {
        $form = $this->crawler->filter($formSelector)
            ->first();

        try {
            $form = $form->form($input);
        } catch (\InvalidArgumentException $e) {
            $this->markTestIncomplete("Form with '$formSelector' clause coudn't be found.");
        }

        $this->crawler = $this->client->submit($form);
    }

    /**
     * Asserts if user sees a specific text
     * @return void
     */
    protected function i_should_see($text)
    {
        $this->assertContains(
            strtolower($text),
            strtolower($this->client->getResponse()->getContent())
        );
    }

    /**
     * Asserts if the user was redirected to the given url
     * @param  string $url Url
     * @return void
     */
    protected function i_should_be_redirected_to($url)
    {
        $this->assertRedirectedTo($url);
    }

    /**
     * Assert that the session has a given list of values.
     * @param  string|array  $key
     * @param  mixed  $value
     * @return void
     */
    protected function session_should_have($key, $value = null)
    {
        $this->assertSessionHas($key, $value);
    }

    /**
     * When calling a method that doesn't exists the test should be marked as
     * incomplete.
     * @param  string $name      Method name
     * @param  array $arguments Method arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        $this->markTestIncomplete("Step '$name' is not defined.");
    }
}
