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

namespace de\codenamephp\installer\test;

use de\codenamephp\installer\StepExecutor;
use de\codenamephp\installer\steps\iStep;
use PHPUnit\Framework\TestCase;

class StepExecutorTest extends TestCase {

  private StepExecutor $sut;

  protected function setUp() : void {
    $step = $this->createMock(iStep::class);

    $this->sut = new StepExecutor($step);
  }

  public function testRun() : void {
    $step = $this->createMock(iStep::class);
    $step->expects(self::once())->method('run');

    $this->sut = new StepExecutor($step);

    $this->sut->run();
  }
}
