<?php

/**
 * ================================================
 * Close current authenticated session
 * ================================================
 */

http_only_post();
http_only_auth();

logout();

http_redirect();
