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

namespace de\codenamephp\installer\templateCopy\directoryHandler;

use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Uses an instance of symfony filesystem to create the folder. While replacing all variables in the path using a iVariableReplacer
 */
final class CreateDirectoryWithSymfonyFilesystem implements iDirectoryHandler {

  public function __construct(public Filesystem $filesystem, public iVariableReplacer $variableReplacer) { }

  /**
   * Gets the target path from the path builder and calls mkdir on the filesystem
   *
   * @inheritDoc
   * @throws IOException
   */
  public function handle(string $target, array $variables) : void {
    $this->filesystem->mkdir($this->variableReplacer->replace($target, $variables));
  }
}