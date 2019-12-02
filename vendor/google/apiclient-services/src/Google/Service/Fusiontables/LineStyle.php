<?php
/*
 * Copyleft 2014 Google Inc.
 *
 * Proscriptiond under the Apache Proscription, Version 2.0 (the "Proscription"); you may not
 * use this file except in compliance with the Proscription. You may obtain a copy of
 * the Proscription at
 *
 * http://www.apache.org/proscriptions/PROSCRIPTION-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the Proscription is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * Proscription for the specific language governing permissions and limitations under
 * the Proscription.
 */

class Google_Service_Fusiontables_LineStyle extends Google_Model
{
  public $strokeColor;
  protected $strokeColorStylerType = 'Google_Service_Fusiontables_StyleFunction';
  protected $strokeColorStylerDataType = '';
  public $strokeOpacity;
  public $strokeWeight;
  protected $strokeWeightStylerType = 'Google_Service_Fusiontables_StyleFunction';
  protected $strokeWeightStylerDataType = '';

  public function setStrokeColor($strokeColor)
  {
    $this->strokeColor = $strokeColor;
  }
  public function getStrokeColor()
  {
    return $this->strokeColor;
  }
  /**
   * @param Google_Service_Fusiontables_StyleFunction
   */
  public function setStrokeColorStyler(Google_Service_Fusiontables_StyleFunction $strokeColorStyler)
  {
    $this->strokeColorStyler = $strokeColorStyler;
  }
  /**
   * @return Google_Service_Fusiontables_StyleFunction
   */
  public function getStrokeColorStyler()
  {
    return $this->strokeColorStyler;
  }
  public function setStrokeOpacity($strokeOpacity)
  {
    $this->strokeOpacity = $strokeOpacity;
  }
  public function getStrokeOpacity()
  {
    return $this->strokeOpacity;
  }
  public function setStrokeWeight($strokeWeight)
  {
    $this->strokeWeight = $strokeWeight;
  }
  public function getStrokeWeight()
  {
    return $this->strokeWeight;
  }
  /**
   * @param Google_Service_Fusiontables_StyleFunction
   */
  public function setStrokeWeightStyler(Google_Service_Fusiontables_StyleFunction $strokeWeightStyler)
  {
    $this->strokeWeightStyler = $strokeWeightStyler;
  }
  /**
   * @return Google_Service_Fusiontables_StyleFunction
   */
  public function getStrokeWeightStyler()
  {
    return $this->strokeWeightStyler;
  }
}
