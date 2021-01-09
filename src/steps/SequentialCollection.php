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

namespace de\codenamephp\installer\steps;

final class SequentialCollection implements iStep {

  /**
   * @var iStep[]
   */
  private array $steps;

  public function __construct(iStep ...$steps) {
    $this->steps = $steps;
  }

  /**
   * @return iStep[]
   */
  public function getSteps() : array {
    return $this->steps;
  }

  public function setSteps(iStep ...$steps) : self {
    $this->steps = $steps;
    return $this;
  }

  public function run() : void {
    foreach($this->getSteps() as $step) $step->run();
  }
}