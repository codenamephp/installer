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

namespace de\codenamephp\installer;

use de\codenamephp\installer\steps\iStep;

/**
 * Installer that executes a step. This step is most likely a step collection so multiple steps will be executed in order to accomplish a complete install
 */
final class StepExecutor implements iInstaller {

  public function __construct(
      private iStep $step //still not sure if I'm gonna be a fan of this
  ) {
  }

  /**
   * Just runs the step
   */
  public function run() : void {
    $this->step->run();
  }
}