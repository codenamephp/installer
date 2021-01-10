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

namespace de\codenamephp\installer\templateCopy\fileHandler;

use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Uses twig to replace the placeholders in the file, symfony filesystem to save the twig output into the file and a variable replace to replace all variables
 * in the path
 */
final class RenderWithTwigAndSumpWithSymfonyFilesystem implements iFileHandler {

  public function __construct(public Filesystem $filesystem, public iVariableReplacer $variableReplacer, public Environment $twig) { }

  /**
   * Uses the twig instance to render the file using the source path and the variables, builds the path to the target using the path builder with the source,
   * target and variables and dumps the twig output into the file using symfony filesystem
   *
   * @inheritDoc
   * @throws IOException
   * @throws LoaderError
   * @throws RuntimeError
   * @throws SyntaxError
   */
  public function handle(string $source, string $target, array $variables) : void {
    $this->filesystem->dumpFile($this->variableReplacer->replace($target, $variables), $this->twig->render($source, $variables));
  }
}