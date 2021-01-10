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

use de\codenamephp\installer\templateCopy\iTemplateCopy;

/**
 * Step to copy a template folder to a target folder. The actual work is delegated to an instance of iTemplateCopy
 */
final class CopyTemplateFolder implements iStep {

  public function __construct(public iTemplateCopy $templateCopy, public string $templateFolder, public string $targetFolder, public array $variables) { }

  public function run() : void {
    $this->templateCopy->copy($this->templateFolder, $this->targetFolder, $this->variables);
  }
}