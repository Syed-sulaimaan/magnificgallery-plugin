<?php
namespace Mohsin\MagnificGallery\Components;

use Cms\Classes\ComponentBase;
use Mohsin\MagnificGallery\Models\Gallery;
use Lang;

class Magnific extends ComponentBase
{
  public function componentDetails()
  {
    return [
    'name' => 'Gallery',
    'description' => 'Display an album from the gallery in a page.'
    ];
  }

  public function defineProperties()
  {
    return [
    'idGallery' => [
      'title'        => 'Gallery',
      'description'  => 'Choose the gallery that will display',
      'type'         => 'dropdown'
      ],
    'height' => [
      'title'         => 'Height',
      'description'   => 'Height of each image.',
      'type'        => 'string',
      'validationPattern' => '^[0-9]+$|^auto$',
      'validationMessage' => 'Invalid value',
      'default'     => '100',
      'group'       => Lang::get('Dimensions'),
    ],
    'width' => [
      'title'         => 'Width',
      'description'   => 'Width of each image.',
      'type'        => 'string',
      'validationPattern' => '^[0-9]+$|^auto$',
      'validationMessage' => 'Invalid value',
      'default'     => 'auto',
      'group'       => Lang::get('Dimensions'),
      ],
    ];
  }

  public function getidGalleryOptions()
  {
    return Gallery::select('id', 'name')->orderBy('name')->get()->lists('name', 'id');
  }

  public function onRun()
  {
    $this->addCss('assets/css/magnific-popup.css');
    $this->addJs('assets/js/jquery.magnific-popup.min.js');
    $this->addJs('assets/js/magnific.js');
  }

  public function onRender(){
    $gallery = new Gallery;
    $this->gallery = $this->page['gallery'] = $gallery->where('id', '=', $this->propertyOrParam('idGallery'))->first();

    $this->page['height']=$this->propertyOrParam('height');
    $this->page['width']=$this->propertyOrParam('width');
  }
}
?>