<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CodeAnalysisTest extends TestCase
{
    #[Test]
    public function testNoAnnotationTest(): void
    {
        $directory = __DIR__ . '/../';

        exec("grep -rl --exclude='CodeAnalysisTest.php' '$directory' -e '@test\|@dataProvider'", $output, $returnCode);

        if (!empty($output)) {
            $message = 'Found the @test or @dataProvider annotation in the following files. Use attributes instead:' . PHP_EOL;
            $message .= implode(PHP_EOL, $output);
        } else {
            $message = 'No @test or @dataProvider annotations found in any other file.';
        }

        $this->assertSame(1, $returnCode, $message);
    }
}
