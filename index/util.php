<?php

  class Util {

    protected $dayOfWeekThaiMap = [
      'Sunday' => 'วันอาทิตย์',
      'Monday' => 'วันจันทร์',
      'Tuesday' => 'วันอังคาร',
      'Wednesday' => 'วันพุธ',
      'Thursday' => 'วันพฤหัสบดี',
      'Friday' => 'วันศุกร์',
      'Saturday' => 'วันเสาร์'
    ];

    protected $monthOfYearThaiMap = [
      'January' => 'มกราคม',
      'February' => 'กุมภาพันธ์',
      'March' => 'มีนาคม',
      'April' => 'เมษายน',
      'May' => 'พฤษภาคม',
      'June' => 'มิถุนายน',
      'July' => 'กรกฎาคม',
      'August' => 'สิงหาคม',
      'September' => 'กันยายน',
      'October' => 'ตุลาคม',
      'November' => 'พฤศจิกายน',
      'December' => 'ธันวาคม'
    ];

    public function coverdate($date)
    {
      $timestamp = strtotime($date);
      $dateThai = $this->dayOfWeekThaiMap[strftime('%A', $timestamp)];
      $monthThai = $this->monthOfYearThaiMap[strftime('%B', $timestamp)];

      return $dateThai. date(' d ', $timestamp). $monthThai. date(' Y : เวลา H:i', $timestamp);
    }

  }

?>