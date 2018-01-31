<?php
namespace CodeDruids\Tests;

use Exception;
use Throwable;
use PHPUnit_Framework_TestCase as TestCase;
use CodeDruids\SimpleDiff;

class SimpleDiffTest extends TestCase
{
    /**
     * @test
     */
    public function testDiff()
    {
        $old = ['some','array','of','stuff'];
        $new = ['some','array','of','other','stuff'];

        $diff = SimpleDiff::diff($old, $new);

        $this->assertEquals(['some','array','of',['deleted' => [], 'inserted' => ['other']],'stuff'], $diff);
    }

    /**
     * @test
     */
    public function testDiffEmptyOld()
    {
        $old = [];
        $new = ['stuff'];

        $diff = SimpleDiff::diff($old, $new);

        $this->assertEquals([['deleted' => [], 'inserted' => ['stuff']]], $diff);
    }

    /**
     * @test
     */
    public function testDiffEmptyNew()
    {
        $old = ['stuff'];
        $new = [];

        $diff = SimpleDiff::diff($old, $new);

        $this->assertEquals([['deleted' => ['stuff'], 'inserted' => []]], $diff);
    }

    /**
     * @test
     */
    public function testDiffEmptyBoth()
    {
        $old = [];
        $new = [];

        $diff = SimpleDiff::diff($old, $new);

        $this->assertEquals([], $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiff()
    {
        $old = 'Some <b>HTML</b> you simply <i>cannot</i> ignore!';
        $new = 'Some <b>HTML</b> you just <i>cannot</i> ignore!';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('Some <b>HTML</b> you <del>simply</del><ins>just</ins> <i>cannot</i> ignore!', $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiffInsertOnly()
    {
        $old = 'Some <b>HTML</b> you <i>cannot</i> ignore!';
        $new = 'Some <b>HTML</b> you simply <i>cannot</i> ignore!';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('Some <b>HTML</b> you <ins>simply </ins><i>cannot</i> ignore!', $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiffDeleteOnly()
    {
        $old = 'Some <b>HTML</b> you simply <i>cannot</i> ignore!';
        $new = 'Some <b>HTML</b> you <i>cannot</i> ignore!';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('Some <b>HTML</b> you <del>simply </del><i>cannot</i> ignore!', $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiffEmptyOld()
    {
        $old = '';
        $new = 'Some <b>HTML</b>!';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('<ins>Some <b>HTML</b>!</ins>', $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiffEmptyNew()
    {
        $old = 'Some <b>HTML</b>!';
        $new = '';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('<del>Some <b>HTML</b>!</del>', $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiffEmptyBoth()
    {
        $old = '';
        $new = '';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('', $diff);
    }

    /**
     * @test
     */
    public function testHtmlDiffWhitespaceOnly()
    {
        $old = 'Some <b>HTML</b>!';
        $new = 'Some  <b>HTML</b>!';

        $diff = SimpleDiff::htmlDiff($old, $new);

        $this->assertEquals('Some<del> </del><ins>  </ins><b>HTML</b>!', $diff);
    }
}
