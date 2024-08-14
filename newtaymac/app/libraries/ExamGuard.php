<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 25-Feb-18
 * Time: 13:42
 */

class ExamGuard {
    /**
     * Guard constructor.
     *
     * @param $loggedinuser
     * @param $roles
     */
    public function __construct() {
      if($_SESSION['accesslevel']=='Examination' || $_SESSION['accesslevel']=='Super' ){
  //	Core::unauthorized('Access denied (incorrect role)');
  

  }else{
   // Redirecting::location('pages/locked');
    Redirecting::location('pages/logout');
  }
}
}