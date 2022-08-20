<?php
/**
 * BSD 3-Clause License
 * @copyright (c) 2019, Google Inc.
 * @link https://www.recaptcha.net/recaptcha
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its
 *    contributors may be used to endorse or promote products derived from
 *    this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require __DIR__ . '/appengine-https.php';

// Initiate the autoloader. The file should be generated by Composer.
// You will provide your own autoloader or require the files directly if you did
// not install via Composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Register API keys at https://www.recaptcha.net/recaptcha/admin
$siteKey = '';
$secret = '';

// Copy the config.php.dist file to config.php and update it with your keys to run the examples
if ($siteKey == '' && is_readable(__DIR__ . '/config.php')) {
    $config = include __DIR__ . '/config.php';
    $siteKey = $config['v3']['site'];
    $secret = $config['v3']['secret'];
}

// Effectively we're providing an API endpoint here that will accept the token, verify it, and return the action / score to the page
// In production, always sanitize and validate the input you retrieve from the request.
$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                  ->setExpectedAction($_GET['action'])
                  ->setScoreThreshold(0.5)
                  ->verify($_GET['token'], $_SERVER['REMOTE_ADDR']);
header('Content-type:application/json');
echo json_encode($resp->toArray());
