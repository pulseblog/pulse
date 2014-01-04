<?php namespace Pulse\Cms;

use App;
use TestCase;
use Mockery as m;

class PresenterTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testShouldSetInstance()
    {
        // Set
        $instance = m::mock('Pulse\Cms\Page');

        $presenter = new Presenter;

        // Assertion
        $presenter->setInstance($instance);

        $this->assertEquals($instance, $presenter->instance);
    }

    public function testShouldDisplay()
    {
        // Set
        $presenter = new Presenter;
        $mdParser = m::mock('dflydev\markdown\MarkdownExtraParser');
        $instance = App::make('Pulse\Cms\Page');
        $instance->title   = 'Page Title';
        $instance->content = 'brutal content';

        // Expectation
        $mdParser->shouldReceive('transformMarkdown')
            ->with($instance->content)
            ->andReturn('processed content');

        App::instance('dflydev\markdown\MarkdownExtraParser', $mdParser);

        $shouldHas = [
            'Page Title',
            'processed content'
        ];

        // Assertion
        $presenter->setInstance($instance);

        $html = $presenter->display()->render();

        foreach ($shouldHas as $fragment) {
            $this->assertContains($fragment, $html);
        }
    }
}
