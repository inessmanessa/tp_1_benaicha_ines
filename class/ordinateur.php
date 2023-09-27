<?php
class Ordinateur extends Crud {
    public $id;
    public $brand;
    public $price;
    public $generation;

    public function putOrdinateur($ordinateur) {
        return parent::putOrdinateur($ordinateur);
    }

    public function updateOrdinateur() {
        $ordinateurData = [
            'brand' => $this->brand,
            'price' => $this->price,
            'generation' => $this->generation
        ];
        parent::updateOrdinateurById($this->id, $ordinateurData);
    }

    public function deleteOrdinateur() {
        return parent::deleteOrdinateurById($this->id);
    }
}
