<?php declare(strict_types=1);
/**
 * Copyright 2021 Bastian Schwarz <bastian@codename-php.de>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace de\codenamephp\installer\test\steps;

use de\codenamephp\installer\steps\iStep;
use de\codenamephp\installer\steps\SequentialCollection;
use PHPUnit\Framework\TestCase;

class SequentialCollectionTest extends TestCase {

  private SequentialCollection $sut;

  protected function setUp() : void {
    $this->sut = new SequentialCollection();
  }

  public function test__construct() : void {
    $step1 = $this->createMock(iStep::class);
    $step2 = $this->createMock(iStep::class);
    $step3 = $this->createMock(iStep::class);

    $this->sut = new SequentialCollection($step1, $step2, $step3);

    self::assertSame([$step1, $step2, $step3], $this->sut->getSteps());
  }

  public function testRun() : void {
    $step1 = $this->createMock(iStep::class);
    $step1->expects(self::once())->method('run');
    $step2 = $this->createMock(iStep::class);
    $step2->expects(self::once())->method('run');
    $step3 = $this->createMock(iStep::class);
    $step3->expects(self::once())->method('run');
    $this->sut->setSteps($step1, $step2, $step3);

    $this->sut->run();
  }
}
