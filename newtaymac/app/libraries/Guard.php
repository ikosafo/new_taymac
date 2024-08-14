<?php

/**
 * Created by PhpStorm.
 * User: astro
 * Date: 25-Feb-18
 * Time: 13:42
 */

class Guard
{
  /**
   * Guard constructor.
   *
   * @param $loggedinuser
   * @param $roles
   */
  public function __construct()
  {
    if (!isset($_SESSION['uid'])) {
      //	Core::unauthorized('Access denied (incorrect role)');
      Redirecting::location('auth/login');
    }
    elseif (LOCKED == 'yes') {
          Redirecting::location('pages/locked');
        }
      }
}
