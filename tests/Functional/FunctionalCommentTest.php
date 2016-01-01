<?php

use Mockery as m;

/**
 * Class FunctionalCommentTest
 */
class FunctionalCommentTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\WithoutMiddleware;

    public function testShouldBeRedirectInstanceForValidationFailed()
    {
        $this->post('comment', ['comment' => 'testing']);
        $this->assertRedirectedToRoute('entry.index');

        $this->post('comment', ['entry_id' => 1]);
        $this->assertRedirectedToRoute('entry.show', [1]);
    }

    public function testCommentSubmitSuccessResponse()
    {
        $this->app->bind('App\Repositories\CommentRepositoryInterface', function () {
            $commentRepositoryMock = m::mock('App\Repositories\CommentRepositoryInterface');
            $commentRepositoryMock->shouldReceive('save')->andReturn(true);
            return $commentRepositoryMock;
        });
        $this->post('comment', ['comment' => 'testing', 'entry_id' => 1]);
        $this->assertRedirectedToRoute('entry.show', [1]);
    }
}
