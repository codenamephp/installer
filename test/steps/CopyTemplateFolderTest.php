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

use de\codenamephp\installer\steps\CopyTemplateFolder;
use de\codenamephp\installer\templateCopy\iTemplateCopy;
use PHPUnit\Framework\TestCase;

class CopyTemplateFolderTest extends TestCase {

  private CopyTemplateFolder $sut;

  protected function setUp() : void {
    $templateCopy = $this->createMock(iTemplateCopy::class);

    $this->sut = new CopyTemplateFolder($templateCopy, '?', '?', []);
  }

  public function testRun() : void {
    $this->sut->variables = ['some', 'vars'];
    $this->sut->targetFolder = 'some/target';
    $this->sut->templateFolder = 'some/template';

    $templateCopy = $this->createMock(iTemplateCopy::class);
    $templateCopy->expects(self::once())->method('copy')->with($this->sut->templateFolder, $this->sut->targetFolder, $this->sut->variables);
    $this->sut->templateCopy = $templateCopy;

    $this->sut->run();
  }
}
