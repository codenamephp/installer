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

use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Step to create folders since git doesn't commit empty folders. This way we don't have to create folders in the base template and place .gitkeep files in them
 */
final class CreateFolders implements iStep {

  /**
   * @param iVariableReplacer $variableReplacer Used to replace variables in the folder paths
   * @param Filesystem $filesystem Used to create the folders
   * @param array<string> $folders The absolute paths of the folders to be created
   * @param array<string, string> $variables Used in variable replacement in the folder paths
   */
  public function __construct(public iVariableReplacer $variableReplacer, public Filesystem $filesystem, public array $folders, public array $variables) { }

  /**
   * Iterates over all folders, replaces the variables in each path using the variables and the variableReplacer passes each path to symfony filesystem to
   * create the folders
   *
   * @inheritDoc
   * @throws IOException
   */
  public function run() : void {
    $this->filesystem->mkdir(array_map(fn(string $folder) => $this->variableReplacer->replace($folder, $this->variables), $this->folders));
  }
}